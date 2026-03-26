<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\CatalogSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatalogSpecController extends Controller
{
    public function index($catalogHashId) {
        $catalogId = $this->decryptId($catalogHashId);
        if(!$catalogId) {
            return $this->failResponse('ID tidak valid.');
        }

        $catalog = Catalog::where('id', $catalogId)->first();
        if (!$catalog) {
            return $this->failResponse('Data Katalog tidak ditemukan.', 404);
        }

        if ($catalog->category) {
            $specs = $catalog->category->specs()
                ->where('is_active', 1)
                ->orderBy('sort_order')
                ->orderBy('id')->get();
        } else {
            $specs = collect();
        }

        $existingValues = CatalogSpec::query()
            ->where('catalog_id', $catalog->id)
            ->get()
            ->keyBy('spec_id');
        
        return view('admin.catalogs.specs', compact('catalog','specs', 'existingValues'));
    }

    public function store(Request $request, $catalogHashId) {
        $catalogId = $this->decryptId($catalogHashId);
        if (!$catalogId) {
            return $this->failResponse('ID Tidak Valid.');
        }

        // $catalog = Catalog::with('category')->find($catalogId);
        $catalog = Catalog::where('id', $catalogId)->with('category')->first();
        if (!$catalog) {
            return $this->failResponse('Data katalog tidak ditemukan.', 404);
        }
        if (!$catalog->category) {
            return $this->failResponse('Kategori tidak ditemukan.', 404);
        }

        $specs = $catalog->category->specs()
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        
        $rules = [];
        $messages = [];
        foreach ($specs as $spec) {
            $field = 'specs.' . $spec->id;

            if ((int) $spec->is_required === 1) {
                $rules[$field] = ['required', 'string'];
                $messages[$field . '.required'] = $spec->spec_label . ' wajib diisi.';
            } else {
                $rules[$field] = ['nullable', 'string'];
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->failResponse('Validasi gagal.', 422, $validator->errors());
        }

        $submittedSpecs = $request->input('specs', []);
        return $this->handleDatabase(function() use ($catalog, $specs, $submittedSpecs) {
            $existing = CatalogSpec::where('catalog_id', $catalog->id)
                ->get()
                ->keyBy('spec_id');
            $allowedSpecIds = $specs->pluck('id')->toArray();

            foreach ($specs as $spec) {
                $value = trim($submittedSpecs[$spec->id] ?? '');
                // 🔥 INTI PERUBAHAN: skip kalau kosong & optional
                if ($value === '') {
                    if ((int) $spec->is_required === 1) {
                        // required → tetap simpan kosong (biar valid)
                        CatalogSpec::updateOrCreate(
                            [
                                'catalog_id' => $catalog->id,
                                'spec_id' => $spec->id
                            ],
                            [
                                'spec_value' => $value
                            ]
                        );
                    } else {
                        // optional → DELETE kalau ada
                        if (isset($existing[$spec->id])) {
                            $existing[$spec->id]->delete();
                        }
                    }

                    continue;
                }

                // Simpan normal
                CatalogSpec::updateOrCreate(
                    [
                        'catalog_id' => $catalog->id,
                        'spec_id' => $spec->id
                    ],
                    [
                        'spec_value' => $value,
                    ]
                );
            }
            CatalogSpec::where('catalog_id', $catalog->id)
                ->whereNotIn('spec_id', $allowedSpecIds)
                ->delete();
        }, 'Berhasil menyimpan spesifikasi katalog.', true, true);
    }
}
