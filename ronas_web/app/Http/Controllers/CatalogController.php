<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CatalogController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $search = trim((string) $request->input('search'));
            $serviceHash = trim((string) $request->input('service'));

            $catalogs = Catalog::query()->with('category');
            if ($serviceHash !== '') {
                $serviceId = $this->decryptId($serviceHash);
                if (!$serviceId) {
                    return $this->failResponse('Filter service tidak valid.', 422);
                }

                $catalogs->where('service_category_id', $serviceId);
            }
            if ($search !== '') {
                $like = "%{$search}%";
                $catalogs->where(function ($q) use ($like) {
                    $q->where('title', 'like', $like)
                        ->orWhere('description', 'like', $like);
                });
            }

            return DataTables::eloquent($catalogs)
                ->addIndexColumn()
                ->addColumn('image_preview', function ($catalog) {
                    return view('admin.catalogs.columns.image_preview', compact('catalog'))->render();
                })
                ->addColumn('title', function ($catalog) {
                    return view('admin.catalogs.columns.title', compact('catalog'))->render();
                })
                ->orderColumn('title', function ($query, $order) {
                    $query->orderBy('title', $order);
                })
                ->addColumn('service', function ($catalog) {
                    return view('admin.catalogs.columns.service', compact('catalog'))->render();
                })
                ->addColumn('price_text', function ($catalog) {
                    return view('admin.catalogs.columns.price_text', compact('catalog'))->render();
                })
                ->orderColumn('price_text', function ($query, $order) {
                    $query->orderBy('price', $order);
                })
                ->addColumn('location', function ($catalog) {
                    return view('admin.catalogs.columns.location', compact('catalog'))->render();
                })
                ->orderColumn('location', function ($query, $order) {
                    $query->orderBy('location', $order);
                })
                ->addColumn('status', function ($catalog) {
                    return view('admin.catalogs.columns.status', compact('catalog'))->render();
                })
                ->addColumn('action', function ($catalog) {
                    return view('admin.catalogs.columns.action', compact('catalog'))->render();
                })
                ->rawColumns(['image_preview', 'title', 'service', 'price_text', 'location', 'status', 'action'])
                ->make(true);
            
        }

        $services = ServiceCategory::query()
            ->where('is_active', 1)
            ->orderBy('name')
            ->get(['id', 'name']);
        return view('admin.catalogs.index', compact('services'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'service'     => 'required|string',
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:,jpeg,jpg,png|max:2048',
            'price'       => 'required|numeric|min:0',
            'price_label' => 'nullable|string|max:150',
            'location'    => 'nullable|string',
            'message'     => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal, silakan cek kembali input.', 422, $validator->errors());
        }

        $serviceId = $this->decryptId($request->service);
        if (!$serviceId) {
            return $this->failResponse('ID tidak valid.');
        }
        $service = ServiceCategory::where('id', $serviceId)->first();
        if (!$service) {
            return $this->failResponse('Data Layanan tidak ditemukan.', 404);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $destination = public_path('uploads/catalogs');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destination, $filename);
            $imagePath = 'uploads/services/' . $filename;
        }

        return $this->handleDatabase(function() use ($imagePath, $request, $serviceId) {
            Catalog::create([
                'service_category_id' => $serviceId,
                'title'               => $request->title,
                'description'         => $request->description,
                'image'               => $imagePath,
                'price'               => $request->price,
                'price_label'         => $request->price_label,
                'location'            => $request->location,
                'whatsapp_message'    => $request->message,
                'is_active'           => 1,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }, 'Berhasil menambahkan Data Katalog baru.', true);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string',
            'service'     => 'required|string',
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'price'       => 'required|numeric|min:0',
            'price_label' => 'nullable|string|max:150',
            'location'    => 'nullable|string|max:150',
            'message'     => 'nullable|string',
            'status'      => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal, silakan cek kembali input.', 422, $validator->errors());
        }

        $catalogId = $this->decryptId($request->id);
        if (!$catalogId) {
            return $this->failResponse('ID katalog tidak valid.');
        }
        $serviceId = (int) ($request->service);
        // $serviceId = $this->decryptId($request->service);
        // if (!$serviceId) {
        //     return $this->failResponse('ID Service tidak valid.');
        // }

        $service = ServiceCategory::where('id', $serviceId)->first();
        if (!$service) {
            return $this->failResponse('Data Layanan tidak ditemukan.', 404);
        }
        $catalog = Catalog::where('id', $catalogId)->first();
        if (!$catalog) {
            return $this->failResponse('Data Katalog tidak ditemukan.', 404);
        }

        $imagePath = $service->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $destination = public_path('uploads/catalogs');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destination, $filename);
            $newImagePath = 'uploads/catalogs/' . $filename;

            // 🧹 hapus gambar lama kalau ada
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }

            $imagePath = $newImagePath;
        }

        return $this->handleDatabase(function() use ($catalog, $imagePath, $request, $serviceId) {
            $catalog->update([
                'service_category_id' => $serviceId,
                'title'               => $request->title,
                'description'         => $request->description,
                'image'               => $imagePath,
                'price'               => $request->price,
                'price_label'         => $request->price_label,
                'location'            => $request->location,
                'whatsapp_message'    => $request->message,
                'is_active'           => $request->status,
                'updated_at'          => now(),
            ]);
        }, 'Berhasil Memperbarui Data Katalog.', true);
    }

    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal, silakan cek kembali input.', 422, $validator->errors());
        }

        $catalogId = $this->decryptId($request->id);
        if (!$catalogId) {
            return $this->failResponse('ID tidak valid.');
        }

        $catalog = Catalog::where('id', $catalogId)->first();
        if (!$catalog) {
            return $this->failResponse('Data Katalog tidak ditemukan.', 404);
        }

        return $this->handleDatabase(function() use ($catalog) {
            if ($catalog->image && file_exists(public_path($catalog->image))) {
                unlink(public_path($catalog->image));
            }
            $catalog->delete();
        }, 'Berhasil menghapus Data Katalog.', true);
    }
}
