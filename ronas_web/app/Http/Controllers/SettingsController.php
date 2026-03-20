<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

use function Symfony\Component\Clock\now;

class SettingsController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $search = trim((string) $request->input('search'));

            $settings = Setting::query();

            if (Auth::user()->role!='superadmin') {
                $settings->where('is_core', '!=', 0);
            }
            if ($search !=='') {
                $like = "%{$search}%";
                $settings->where(function ($q) use ($like) {
                    $q->where('key', 'like', $like)
                        ->orWhere('value', 'like', $like)
                        ->orWhere('group_name', 'like', $like)
                        ->orWhere('label', 'like', $like)
                        ->orWhere('description', 'like', $like);
                });
            }

            return DataTables::eloquent($settings)
                ->addIndexColumn()
                ->addColumn('label', function ($setting) {
                    return view('admin.settings.columns.label', compact('setting'))->render();
                })
                ->orderColumn('label', function ($query, $order) {
                    $query->orderBy('label', $order);
                })
                ->addColumn('key', function ($setting) {
                    return view('admin.settings.columns.key', compact('setting'))->render();
                })
                ->orderColumn('key', function ($query, $order) {
                    $query->orderBy('key', $order);
                })
                ->addColumn('value', function ($setting) {
                    return view('admin.settings.columns.value', compact('setting'))->render();
                })
                ->orderColumn('value', function ($query, $order) {
                    $query->orderBy('value', $order);
                })
                ->addColumn('type', function ($setting) {
                    return view('admin.settings.columns.type', compact('setting'))->render();
                })
                ->orderColumn('type', function ($query, $order) {
                    $query->orderBy('type', $order);
                })
                ->addColumn('group_name', function ($setting) {
                    return view('admin.settings.columns.group_name', compact('setting'))->render();
                })
                ->orderColumn('group_name', function ($query, $order) {
                    $query->orderBy('group_name', $order);
                })
                ->addColumn('action', function ($setting) {
                    return view('admin.settings.columns.action', compact('setting'))->render();
                })
                ->rawColumns(['label', 'key', 'value', 'type', 'group_name', 'action'])
                ->make(true);
            
        }
        return view('admin.settings.index');
    }

    public function store(Request $request) {
        $rules = [
            'label' => 'required|string|max:150',
            'key' => 'required|string',
            'type' => 'required|string|in:text,textarea,number,boolean,json,image,url,email',
            'value' => 'nullable',
            'group_name' => 'nullable|string',
            'description' => 'nullable|string',
        ];

        $isSuperadmin = (Auth::user()->role === 'superadmin');
        if ($isSuperadmin) {
            $rules['is_core'] = 'required|in:0,1';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        $isCore = 0;
        if ($isSuperadmin) {
            $isCore = $request->is_core;
        }

        return $this->handleDatabase(function() use ($isCore, $request) {
            Setting::create([
                'label'       => $request->label,
                'key'         => $request->key,
                'type'        => $request->type,
                'value'       => $request->value,
                'group_name'  => $request->group_name,
                'description' => $request->description,
                'is_core'     => $isCore,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }, 'Berhasil menambahkan Data Konfigurasi baru.', true);
    }

    public function update(Request $request) {
        $rules = [
            'id' => 'required|string',
            'label' => 'required|string|max:150',
            'key' => 'required|string',
            'type' => 'required|string|in:text,textarea,number,boolean,json,image,url,email',
            'value' => 'nullable',
            'group_name' => 'nullable|string',
            'description' => 'nullable|string',
        ];

        $isSuperadmin = (Auth::user()->role === 'superadmin');
        if ($isSuperadmin) {
            $rules['is_core'] = 'required|in:0,1';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        $setting = Setting::where('id', Crypt::decryptString($request->id))->first();
        if (!$setting) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data Konfigurasi tidak ditemukan.',
            ], 404);
        }

        $isCore = 0;
        if ($isSuperadmin) {
            $isCore = $request->is_core;
        }
        
        return $this->handleDatabase(function() use ($isCore, $setting, $request) {
            $setting->update([
                'label'       => $request->label,
                'key'         => $request->key,
                'type'        => $request->type,
                'value'       => $request->value,
                'group_name'  => $request->group_name,
                'description' => $request->description,
                'is_core'     => $isCore,
                'updated_at'  => now(),
            ]);
        }, 'Berhasil Memperbarui Data Konfigurasi.', true);
    }

    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        try {
            $setting = Setting::where('id', Crypt::decryptString($request->id))->first();
            if (!$setting) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data Konfigurasi tidak ditemukan.',
                ], 404);
            }
            $setting->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menghapus Data Konfigurasi.',
            ]);
        } catch(Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus Data Konfigurasi, silahkan coba lagi.',
            ], 500);
        }
    }
}
