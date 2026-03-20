<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
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

    public function store(Request $request) {}

    public function update(Request $request) {}

    public function destroy(Request $request) {}
}
