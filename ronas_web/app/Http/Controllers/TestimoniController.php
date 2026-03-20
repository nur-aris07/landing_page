<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class TestimoniController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $search = trim((string) $request->input('search'));

            $testimoni = Testimonial::query();
            if ($search !=='') {
                $like = "%{$search}%";
                $testimoni->where(function ($q) use ($like) {
                    $q->where('customer_name', 'like', $like)
                        ->orWhere('customer_title', 'like', $like)
                        ->orWhere('message', 'like', $like);
                });
            }

            return DataTables::eloquent($testimoni)
                ->addIndexColumn()
                ->addColumn('customer_name', function ($testimoni) {
                    return view('admin.testimoni.columns.customer_name', compact('testimoni'))->render();
                })
                ->orderColumn('customer_name', function ($query, $order) {
                    $query->orderBy('customer_name', $order);
                })
                ->addColumn('message', function ($testimoni) {
                    return view('admin.testimoni.columns.message', compact('testimoni'))->render();
                })
                ->orderColumn('message', function ($query, $order) {
                    $query->orderBy('message', $order);
                })
                ->addColumn('rating', function ($testimoni) {
                    return view('admin.testimoni.columns.rating', compact('testimoni'))->render();
                })
                ->orderColumn('rating', function ($query, $order) {
                    $query->orderBy('rating', $order);
                })
                ->addColumn('status', function ($testimoni) {
                    return view('admin.testimoni.columns.status', compact('testimoni'))->render();
                })
                ->addColumn('action', function ($testimoni) {
                    return view('admin.testimoni.columns.action', compact('testimoni'))->render();
                })
                ->rawColumns(['customer_name', 'message', 'rating', 'status', 'action'])
                ->make(true);
        }
        return view('admin.testimoni.index');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'customer_name'  => 'required|string|max:120',
            'customer_title' => 'nullable|string|max:120',
            'customer_city'  => 'nullable|string|max:120',
            'message'        => 'required|string',
            'rating'         => 'required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        return $this->handleDatabase(function() use ($request) {
            Testimonial::create([
                'customer_name'  => $request->customer_name,
                'customer_title' => $request->customer_title,
                'customer_city'  => $request->customer_city,
                'message'        => $request->message,
                'rating'         => $request->rating,
                'image'          => null,
                'is_active'      => 1,
            ]);
        }, 'Berhasil menambahkan Data Testimoni baru.', true);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'            => 'required|string',
            'customer_name' => 'required|string|max:120',
            'message'       => 'required|string',
            'rating'        => 'required|integer|min:1|max:5',
            'status'        => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        $testimoni = Testimonial::where('id', Crypt::decryptString($request->id))->first();
        if (!$testimoni) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data Testimoni tidak ditemukan.',
            ], 404);
        }

        return $this->handleDatabase(function() use ($testimoni, $request) {
            $testimoni->update([
                'customer_name' => $request->customer_name,
                'message'       => $request->message,
                'rating'        => $request->rating,
                'is_active'     => $request->status,
            ]);
        }, 'Berhasil Memperbarui Data Testimoni.', true);
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
            $testimoni = Testimonial::where('id', Crypt::decryptString($request->id))->first();
            if (!$testimoni) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data Testimoni tidak ditemukan.',
                ], 404);
            }

            $testimoni->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menghapus Data Testimoni.',
            ]);
        } catch(Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus Data Testimoni, silahkan coba lagi.',
            ], 500);
        }
    }
}
