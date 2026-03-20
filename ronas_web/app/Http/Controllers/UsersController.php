<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

use function Symfony\Component\Clock\now;

class UsersController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $search = trim((string) $request->input('search'));
            $users = User::query();
            if (Auth::user()->role!='superadmin') {
                $users->where('role', '!=', 'superadmin');
            }
            if ($search !=='') {
                $like = "%{$search}%";
                $users->where(function ($q) use ($like) {
                    $q->where('name', 'like', $like)
                        ->orWhere('username', 'like', $like)
                        ->orWhere('role', 'like', $like);
                });
            }
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn('name', function ($user) {
                    return view('admin.users.columns.name', compact('user'))->render();
                })
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->addColumn('username', function ($user) {
                    return view('admin.users.columns.username', compact('user'))->render();
                })
                ->orderColumn('username', function ($query, $order) {
                    $query->orderBy('username', $order);
                })
                ->addColumn('role', function ($user) {
                    return view('admin.users.columns.role', compact('user'))->render();
                })
                ->orderColumn('role', function ($query, $order) {
                    $query->orderBy('role', $order);
                })
                ->addColumn('status', function ($user) {
                    return view('admin.users.columns.status', compact('user'))->render();
                })
                ->orderColumn('status', function ($query, $order) {
                    $query->orderBy('status', $order);
                })
                ->addColumn('action', function ($user) {
                    return view('admin.users.columns.action', compact('user'))->render();
                })
                ->rawColumns(['name', 'username', 'role', 'status', 'action'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:150',
            'role'     => 'required|string|in:superadmin,admin',
            'password' => [ 'required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->max(15), 'confirmed' ],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }
        
        return $this->handleDatabase(function() use ($request) {
            User::create([
                'name'       => $request->name,
                'username'   => $request->username,
                'password'   => Hash::make($request->password),
                'role'       => $request->role,
                'is_active'  => 1,
                'created_at' => now(),
            ]);
        }, 'Berhasil menambahkan Data User baru.', true);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|string',
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:150',
            'role'     => 'required|string|in:superadmin,admin',
            'status'   => 'required|boolean|',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        $user = User::where('id', Crypt::decryptString($request->id))->first();
        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data User tidak ditemukan.',
            ], 404);
        }

        return $this->handleDatabase(function() use ($user, $request) {
            $user->update([
                'name'      => $request->name,
                'username'  => $request->username,
                'role'      => $request->role,
                'is_active' => $request->status,
            ]);
        }, 'Berhasil Memperbarui Data User.', true);
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'id'       => 'required|string',
            'password' => [ 'required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->max(15), 'confirmed' ],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }

        $user = User::where('id', Crypt::decryptString($request->id))->first();
        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data User tidak ditemukan.',
            ], 404);
        }

        return $this->handleDatabase(function() use ($user, $request) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }, 'Berhasil Memperbarui Password User.', true);
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
            $user = User::where('id', Crypt::decryptString($request->id))->first();
            if (!$user) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data User tidak ditemukan.',
                ], 404);
            }
            $user->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menghapus Data User.',
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus Data User, silahkan coba lagi.',
            ], 500);
        }
    }
}
