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
        $rules = [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:150|unique:users,username',
            'password' => [ 'required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->max(15), 'confirmed' ],
        ];
        if (Auth::user()->role === 'superadmin') {
            $rules['role'] = 'required|string|in:superadmin,admin';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal, silakan cek kembali input.',
            ], 422);
        }
        
        return $this->handleDatabase(function() use ($request) {
            $role = 'admin';
            if (Auth::user()->role === 'superadmin') {
                $role = $request->role;
            }
            User::create([
                'name'       => $request->name,
                'username'   => $request->username,
                'password'   => Hash::make($request->password),
                'role'       => $role,
                'is_active'  => 1,
                'created_at' => now(),
            ]);
        }, 'Berhasil menambahkan Data User baru.', true);
    }

    public function update(Request $request) {
        $rules = [
            'id'       => 'required|string',
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:150',
            'status'   => 'required|boolean|',
        ];
        if(Auth::user()->role === 'superadmin') {
            $rules['role'] = 'required|string|in:superadmin,admin';
        }
        $validator = Validator::make($request->all(), $rules);
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
            $role = $user->role;
            if (Auth::user()->role === 'superadmin') {
                $role = $request->role;
            }
            $user->update([
                'name'      => $request->name,
                'username'  => $request->username,
                'role'      => $role,
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
        if (Auth::user()->role !== 'superadmin') {
            $this->failResponse('Anda tidak memiliki akses untuk ini.', 403);
        }
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
