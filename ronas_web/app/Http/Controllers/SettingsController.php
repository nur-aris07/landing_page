<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy(Request $request) {}
}
