<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

use function Symfony\Component\Clock\now;

class ServicesController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $search = trim((string) $request->input('search'));

            $services = ServiceCategory::query();
            if ($search !=='') {
                $like = "%{$search}%";
                $services->where(function ($q) use ($like) {
                    $q->where('name', 'like', $like)
                        ->orWhere('description', 'like', $like);
                });
            }

            return DataTables::eloquent($services)
                ->addIndexColumn()
                ->addColumn('name', function ($service) {
                    return view('admin.services.columns.name', compact('service'))->render();
                })
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->addColumn('description', function ($service) {
                    return view('admin.services.columns.description', compact('service'))->render();
                })
                ->orderColumn('description', function ($query, $order) {
                    $query->orderBy('description', $order);
                })
                ->addColumn('icon', function ($service) {
                    return view('admin.services.columns.icon', compact('service'))->render();
                })
                ->addColumn('status', function ($service) {
                    return view('admin.services.columns.status', compact('service'))->render();
                })
                ->addColumn('action', function ($service) {
                    return view('admin.services.columns.action', compact('service'))->render();
                })
                ->rawColumns(['name', 'description', 'icon', 'status', 'action'])
                ->make(true);
        }
        return view('admin.services.index');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:100',
            'description' => 'required|string',
            'image'       => 'nullable',
            'icon'        => 'nullable|string|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        return $this->handleDatabase(function() use ($request) {
            ServiceCategory::create([
                'name'        => $request->name,
                'description' => $request->description,
                'image'       => null,
                'icon'        => null,
                'is-active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }, 'Berhasil menambahkan Data Layanan baru.', true);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'          => 'required|string',
            'name'        => 'required|string|max:100',
            'description' => 'required|string',
            'icon'        => 'nullable|string|max:100',
            'image'       => 'nullable',
            'status'      => 'requireD|in:0,1'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        $service = ServiceCategory::where('id', Crypt::decryptString($request->id))->first();
        if(!$service) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data Layanan tidak ditemukan.',
            ], 404);
        }

        return $this->handleDatabase(function() use ($service, $request) {
            $service->update([
                'name'        => $request->name,
                'description' => $request->description,
                'image'       => null,
                'icon'        => $request->icon,
                'is_active'   => $request->status,
                'updated_at'  => now(),
            ]);
        }, 'Berhasil Memperbarui Data Layanan.', true);
    }

    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        try {
            $service = ServiceCategory::where('id', Crypt::decryptString($request->id))->first();
            if (!$service) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data Layanan tidak ditemukan.',
                ], 404);
            }
            $service->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menghapus Data Layanan.',
            ]);
        } catch(Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus Data Layanan, silahkan coba lagi.',
            ], 500);
        }
    }
}
