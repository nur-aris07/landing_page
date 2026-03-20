<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy(Request $request) {}
}
