<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy(Request $request) {}
}
