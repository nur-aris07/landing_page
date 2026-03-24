<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
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

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy(Request $request) {}
}
