<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Spec;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ServiceSpecController extends Controller
{
    public function index(Request $request, $service) {
        try {
            $serviceId = Crypt::decryptString($service);
            $service = ServiceCategory::findOrFail($serviceId);
        } catch (DecryptException $e) {
            abort(404);
        }

        if ($request->ajax()){
            $search = trim((string) $request->input('search'));

            $specs = Spec::query()
                ->where('service_category_id', $serviceId)
                ->orderByDesc('is_active')
                ->orderByRaw('CASE WHEN is_active = 1 THEN sort_order ELSE 999999 END ASC')
                ->orderBy('id', 'ASC');
            if ($search !== '') {
                $like = "%{$search}%";
                $specs->where(function ($q) use ($like) {
                    $q->where('spec_key', 'like', $like)
                        ->orWhere('spec_label', 'like', $like);
                });
            }

            return DataTables::eloquent($specs)
                ->addIndexColumn()
                ->addColumn('spec_key', function ($spec) {
                    return view('admin.specs.columns.spec_key', compact('spec'))->render();
                })
                ->orderColumn('spec_key', function ($query, $order) {
                    $query->orderBy('spec_key', $order);
                })
                ->addColumn('spec_label', function ($spec) {
                    return view('admin.specs.columns.spec_label', compact('spec'))->render();
                })
                ->orderColumn('spec_label', function ($query, $order) {
                    $query->orderBy('spec_label', $order);
                })
                ->addColumn('is_required', function ($spec) {
                    return view('admin.specs.columns.is_required', compact('spec'))->render();
                })
                ->addColumn('status', function ($spec) {
                    return view('admin.specs.columns.status', compact('spec'))->render();
                })
                ->addColumn('sort_order', function ($spec) {
                    return view('admin.specs.columns.sort_order', compact('spec'))->render();
                })
                ->orderColumn('sort_order', function ($query, $order) {
                    $query->orderBy('sort_order', $order);
                })
                ->addColumn('action', function ($spec) {
                    return view('admin.specs.columns.action', compact('spec'))->render();
                })
                ->rawColumns(['spec_key', 'spec_label', 'is_required', 'status', 'sort_order', 'action'])
                ->make(true);
        }
        return view('admin.specs.index', compact('service'));
    }

    public function store(Request $request) {
        $serviceId = $this->decryptId($request->service);
        if (!$serviceId) {
            return $this->failResponse('ID service tidak valid.');
        }

        $validator = Validator::make($request->all(), [
            'service'  => 'required|string',
            'key'      => [
                'required', 'string', 'max:100', 'regex:/^[a-zA-Z0-9_]+$/', 
                Rule::unique('specs', 'spec_key')->where(fn($q) => $q->where('service_category_id', $serviceId))
            ],
            'label'    => 'required|string|max:120',
            'required' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal, silakan cek kembali input.', 422, $validator->errors());
        }

        $service = ServiceCategory::where('id', $serviceId)->first();
        if (!$service) {
            return $this->failResponse('Data layanan tidak ditemukan.', 404);
        }

        return $this->handleDatabase(function() use ($request, $service) {
            $nextSortOrder = Spec::query()
                ->where('service_category_id', $service->id)
                ->where('is_active', 1)
                ->max('sort_order');

            $nextSortOrder = ((int) $nextSortOrder) + 1;

            Spec::create([
                'service_category_id' => $service->id,
                'spec_key'            => $request->key,
                'spec_label'          => $request->label,
                'is_required'         => $request->required,
                'is_active'           => 1,
                'sort_order'          => $nextSortOrder,
            ]);
        }, 'Berhasil menambahkan Data Spesifikasi baru.', true);
    }

    public function update(Request $request) {
        $specId = $this->decryptId($request->id);
        if (!$specId) {
            return $this->failResponse('ID tidak valid.');
        }

        $spec = Spec::where('id', $specId)->first();
        if (!$spec) {
            return $this->failResponse('Data Spesifikasi Layanan tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'id'        => 'required|string',
            'key'       => [
                'required', 'string', 'max:100', 'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('specs', 'spec_key')
                    ->ignore($spec->id)
                    ->where(fn($q) => $q->where('service_category_id', $spec->service_category_id))
            ],
            'label'     => 'required|string|max:120',
            'required'  => 'required|in:0,1',
            'status'    => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal, silakan cek kembali input.', 422, $validator->errors());
        }

        $newStatus = (int) $request->status;
        $oldStatus = (int) $spec->is_active;
        try {
            DB::beginTransaction();

            $payload = [
                'spec_key'    => $request->key,
                'spec_label'  => $request->label,
                'is_required' => $request->required,
                'is_active'   => $newStatus,
            ];

            // aktif -> nonaktif
            if ($oldStatus === 1 && $newStatus === 0) {
                $payload['sort_order'] = 0;
            }

            // nonaktif -> aktif
            if ($oldStatus === 0 && $newStatus === 1) {
                $maxSortOrder = Spec::query()
                    ->where('service_category_id', $spec->service_category_id)
                    ->where('is_active', 1)
                    ->max('sort_order');

                $payload['sort_order'] = ((int) $maxSortOrder) + 1;
            }

            // status tetap nonaktif, pastikan 0
            if ($oldStatus === 0 && $newStatus === 0) {
                $payload['sort_order'] = 0;
            }

            $spec->update($payload);

            // kalau aktif -> nonaktif, rapikan ulang urutan aktif yang tersisa
            if ($oldStatus === 1 && $newStatus === 0) {
                $this->reorderActiveSpecs($spec->service_category_id);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil Memperbarui Data Spesifikasi Layanan.',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->failResponse('Terjadi kesalahan saat memperbarui Data Spesifikasi Layanan.', 500);
        }
        
        return $this->handleDatabase(function() use ($spec, $request) {
            $spec->update([
                'spec_key'    => $request->key,
                'spec_label'  => $request->label,
                'is_required' => $request->required,
                'is_active'   => $request->status,
            ]);
        }, 'Berhasil Memperbarui Data Spesifikasi Layanan.', true);
    }

    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal, silakan cek kembali input.', 422, $validator->errors());
        }

        $specId = $this->decryptId($request->id);
        if (!$specId) {
            return $this->failResponse('ID tidak valid.');
        }

        $spec = Spec::where('id', $specId)->first();
        if (!$spec) {
            return $this->failResponse('Data Spesifikasi Layanan tidak ditemukan.', 404);
        }

        try {
            DB::beginTransaction();

            $serviceCategoryId = $spec->service_category_id;
            $wasActive = (int) $spec->is_active === 1;

            $spec->delete();

            // hanya reindex kalau yang dihapus itu aktif
            if ($wasActive) {
                $this->reorderActiveSpecs($serviceCategoryId);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menghapus Data Spesifikasi Layanan.',
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->failResponse('Terjadi kesalahan saat menghapus Data Spesifikasi Layanan.', 500);
        }
    }

    public function getDataOrder(Request $request, $service) {
        // if (!$request->ajax()) {
        //     abort(404, 'halaman ini tidak bisa diakses langsung.');
        // }

        try {
            $serviceId = Crypt::decryptString($service);
            $service = ServiceCategory::findOrFail($serviceId);
        } catch (DecryptException $e) {
            return $this->failResponse('Data layanan tidak valid.', 404);
        }

        $items = Spec::query()
            ->where('service_category_id', $service->id)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get([
                'id',
                'spec_key',
                'spec_label',
                'sort_order',
            ])
            ->map(function ($item) {
                return [
                    'id'         => $item->hash_id,
                    'spec_key'   => $item->spec_key,
                    'spec_label' => $item->spec_label,
                    'sort_order' => (int) $item->sort_order,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data'   => $items,
        ]);
    }

    public function reorder(Request $request) {
        $validator = Validator::make($request->all(), [
            'service'            => 'required|string',
            'items'              => 'required|array|min:1',
            'items.*.id'         => 'required|string',
            'items.*.sort_order' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal, silakan cek kembali input.', 422, $validator->errors());
        }

        $serviceId = $this->decryptId($request->service);
        if (!$serviceId) {
            return $this->failResponse('ID service tidak valid.');
        }

        $service = ServiceCategory::where('id', $serviceId)->first();
        if (!$service) {
            return $this->failResponse('Data layanan tidak ditemukan.', 404);
        }

        try {
            DB::beginTransaction();

            $activeSpecIds = Spec::query()
                ->where('service_category_id', $serviceId)
                ->where('is_active', 1)
                ->pluck('id')
                ->toArray();

            $allowedIds = collect($activeSpecIds)->map(fn ($id) => (string) $id)->toArray();

            foreach ($request->items as $item) {
                $specId = $this->decryptId($item['id']);
                if (!$specId) {
                    DB::rollBack();
                    return $this->failResponse('Ada ID spesifikasi yang tidak valid.');
                }

                if (!in_array((string) $specId, $allowedIds, true)) {
                    DB::rollBack();
                    return $this->failResponse('Ada data spesifikasi yang tidak sesuai layanan atau tidak aktif.');
                }

                Spec::where('id', $specId)->update([
                    'sort_order' => (int) $item['sort_order'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil memperbarui urutan spesifikasi layanan.',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->failResponse('Terjadi kesalahan saat memperbarui urutan spesifikasi layanan.', 500);
        }
    }

    private function reorderActiveSpecs(int $serviceCategoryId): void {
        $activeSpecs = Spec::query()
            ->where('service_category_id', $serviceCategoryId)
            ->where('is_active', 1)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        foreach ($activeSpecs as $index => $item) {
            $item->update([
                'sort_order' => $index + 1,
            ]);
        }
    }
}
