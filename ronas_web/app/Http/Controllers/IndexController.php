<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Testimonial;
// use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function index() {
        $settings = Setting::pluck('value', 'key');

        $categories = ServiceCategory::query()
            ->where('is_active', 1)
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                $category->slug_name = Str::slug($category->name);
                return $category;
            });

        $catalogs = Catalog::query()
            ->with([
                'category:id,name,description,icon,is_active',
                'specs.spec:id,service_category_id,spec_label,is_active,sort_order',
            ])
            ->where('is_active', 1)
            ->orderBy('service_category_id')
            ->orderBy('title')
            ->get()
            ->filter(function ($catalog) {
                return $catalog->category && (int) $catalog->category->is_active === 1;
            })
            ->map(function ($catalog) {
                $catalog->category_slug = Str::slug(optional($catalog->category)->name ?? 'lainnya');

                $sortedSpecs = $catalog->specs
                    ->filter(function ($item) {
                        return $item->spec && (int) $item->spec->is_active === 1;
                    })
                    ->sortBy(function ($item) {
                        return $item->spec->sort_order ?? 9999;
                    })
                    ->values();

                $catalog->setRelation('specs', $sortedSpecs);

                return $catalog;
            })
            ->values();

        $testimonials = Testimonial::query()
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->get();

        return view('index', [
            'settings'     => $settings,
            'categories'   => $categories,
            'catalogs'     => $catalogs,
            'testimonials' => $testimonials,
        ]);
    }

    public function temp() {
        $settings = Setting::pluck('value', 'key');

        $categories = ServiceCategory::query()
            ->where('is_active', 1)
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                $category->slug_name = Str::slug($category->name);
                return $category;
            });

        $catalogs = Catalog::query()
            ->with([
                'category:id,name,description,icon,is_active',
                'specs.spec:id,service_category_id,spec_label,is_active,sort_order',
            ])
            ->where('is_active', 1)
            ->orderBy('service_category_id')
            ->orderBy('title')
            ->get()
            ->filter(function ($catalog) {
                return $catalog->category && (int) $catalog->category->is_active === 1;
            })
            ->map(function ($catalog) {
                $catalog->category_slug = Str::slug(optional($catalog->category)->name ?? 'lainnya');

                $sortedSpecs = $catalog->specs
                    ->filter(function ($item) {
                        return $item->spec && (int) $item->spec->is_active === 1;
                    })
                    ->sortBy(function ($item) {
                        return $item->spec->sort_order ?? 9999;
                    })
                    ->values();

                $catalog->setRelation('specs', $sortedSpecs);

                return $catalog;
            })
            ->values();

        $testimonials = Testimonial::query()
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->get();

        return view('temp_index', [
            'settings'     => $settings,
            'categories'   => $categories,
            'catalogs'     => $catalogs,
            'testimonials' => $testimonials,
        ]);
    }
}
