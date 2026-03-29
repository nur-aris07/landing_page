<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    protected string $uploadPath = 'uploads/settings';

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = trim((string) $request->input('search'));
            $user = Auth::user();

            $settings = Setting::query()->select([
                'id',
                'key',
                'value',
                'type',
                'group_name',
                'label',
                'description',
                'is_core',
                'created_at',
                'updated_at',
            ]);

            if ($user->role !== 'superadmin') {
                $settings->where('is_core', 0);
            }

            if ($search !== '') {
                $like = "%{$search}%";
                $settings->where(function ($q) use ($like) {
                    $q->where('key', 'like', $like)
                        ->orWhere('value', 'like', $like)
                        ->orWhere('group_name', 'like', $like)
                        ->orWhere('label', 'like', $like)
                        ->orWhere('description', 'like', $like)
                        ->orWhere('type', 'like', $like);
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
                ->addColumn('action', function ($setting) use ($user) {
                    return view('admin.settings.columns.action', compact('setting', 'user'))->render();
                })
                ->rawColumns(['label', 'key', 'value', 'type', 'group_name', 'action'])
                ->make(true);
        }

        return view('admin.settings.index');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return $this->failResponse('Hanya superadmin yang dapat menambahkan setting.', 403);
        }

        $validator = Validator::make(
            $request->all(),
            $this->definitionRules($request),
            [],
            $this->validationAttributes()
        );

        if ($validator->fails()) {
            return $this->failResponse(
                'Validasi gagal, silakan cek kembali input.',
                422,
                $validator->errors()
            );
        }

        return $this->handleDatabase(function () use ($request) {
            $value = $this->prepareValueByType($request);

            Setting::create([
                'label'       => trim($request->label),
                'key'         => trim($request->key),
                'type'        => $request->type,
                'value'       => $value,
                'group_name'  => $request->filled('group_name') ? trim($request->group_name) : 'general',
                'description' => $request->description,
                'is_core'     => (int) $request->is_core,
            ]);
        }, 'Berhasil menambahkan data konfigurasi baru.', true, true);
    }

    public function update(Request $request)
    {
        $id = $this->decryptId($request->id);
        if (!$id) {
            return $this->failResponse('ID setting tidak valid.', 422);
        }

        $setting = Setting::find($id);
        if (!$setting) {
            return $this->failResponse('Data konfigurasi tidak ditemukan.', 404);
        }

        $user = Auth::user();
        $isSuperadmin = $user->role === 'superadmin';

        if (!$isSuperadmin && (int) $setting->is_core === 1) {
            return $this->failResponse('Anda tidak memiliki akses untuk mengubah setting core.', 403);
        }

        $rules = $isSuperadmin
            ? $this->definitionRules($request, $setting)
            : $this->valueOnlyRules($setting);

        $validator = Validator::make(
            $request->all(),
            $rules,
            [],
            $this->validationAttributes()
        );

        if ($validator->fails()) {
            return $this->failResponse(
                'Validasi gagal, silakan cek kembali input.',
                422,
                $validator->errors()
            );
        }

        return $this->handleDatabase(function () use ($request, $setting, $isSuperadmin) {
            $oldType = $setting->type;
            $oldValue = $setting->value;

            if ($isSuperadmin) {
                $newType = $request->type;
                $newValue = $this->prepareValueByType($request, $setting, true);

                $setting->update([
                    'label'       => trim($request->label),
                    'key'         => trim($request->key),
                    'type'        => $newType,
                    'value'       => $newValue,
                    'group_name'  => $request->filled('group_name') ? trim($request->group_name) : 'general',
                    'description' => $request->description,
                    'is_core'     => (int) $request->is_core,
                ]);

                $this->cleanupObsoleteFile($oldType, $oldValue, $newType, $newValue);
            } else {
                $newValue = $this->prepareValueByType($request, $setting, false);

                $setting->update([
                    'value' => $newValue,
                ]);

                $this->cleanupObsoleteFile($oldType, $oldValue, $setting->type, $newValue);
            }
        }, 'Berhasil memperbarui data konfigurasi.', true, true);
    }

    public function destroy(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return $this->failResponse('Hanya superadmin yang dapat menghapus setting.', 403);
        }

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->failResponse(
                'Validasi gagal, silakan cek kembali input.',
                422,
                $validator->errors()
            );
        }

        $id = $this->decryptId($request->id);
        if (!$id) {
            return $this->failResponse('ID setting tidak valid.', 422);
        }

        $setting = Setting::find($id);
        if (!$setting) {
            return $this->failResponse('Data konfigurasi tidak ditemukan.', 404);
        }

        return $this->handleDatabase(function () use ($setting) {
            $this->deleteFileIfImage($setting->type, $setting->value);
            $setting->delete();
        }, 'Berhasil menghapus data konfigurasi.', true, true);
    }

    protected function definitionRules(Request $request, ?Setting $setting = null): array {
        $settingId = $setting?->id;

        return array_merge([
            'id'          => ['nullable', 'string'],
            'label'       => ['required', 'string', 'max:150'],
            'key'         => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-z0-9_]+$/',
                Rule::unique('settings', 'key')->ignore($settingId),
            ],
            'type'        => ['required', Rule::in(['text', 'textarea', 'number', 'boolean', 'json', 'image', 'url', 'email'])],
            'group_name'  => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_core'     => ['required', 'in:0,1'],
        ], $this->valueRulesByType($request->input('type'), $setting));
    }

    protected function valueOnlyRules(Setting $setting): array {
        return array_merge([
            'id' => ['required', 'string'],
        ], $this->valueRulesByType($setting->type, $setting));
    }

    protected function valueRulesByType(?string $type, ?Setting $setting = null): array {
        return match ($type) {
            'text' => [
                'value' => ['nullable', 'string'],
            ],
            'textarea' => [
                'value' => ['nullable', 'string'],
            ],
            'number' => [
                'value' => ['nullable', 'numeric'],
            ],
            'boolean' => [
                'value' => ['required', 'in:1,0,true,false,on,off,yes,no'],
            ],
            'json' => [
                'value' => ['nullable', 'json'],
            ],
            'url' => [
                'value' => ['nullable', 'url'],
            ],
            'email' => [
                'value' => ['nullable', 'email'],
            ],
            'image' => [
                'value' => [
                    $setting ? 'nullable' : 'required',
                    'file',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:10240',
                ],
            ],
            default => [
                'value' => ['nullable'],
            ],
        };
    }

    protected function prepareValueByType(Request $request, ?Setting $setting = null, bool $allowTypeChange = true): ?string {
        $type = $allowTypeChange ? $request->type : $setting->type;

        return match ($type) {
            'number' => $request->filled('value') ? (string) $request->value : null,
            'boolean' => $this->normalizeBoolean($request->input('value')),
            'json' => $request->filled('value')
                ? json_encode(json_decode($request->input('value'), true), JSON_UNESCAPED_UNICODE)
                : null,
            'image' => $this->handleImageUpload($request, $setting),
            default => $request->filled('value') ? trim((string) $request->input('value')) : null,
        };
    }

    protected function handleImageUpload(Request $request, ?Setting $setting = null): ?string {
        if ($request->hasFile('value')) {
            $file = $request->file('value');
            $destination = public_path($this->uploadPath);

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $filename = time() . '_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->move($destination, $filename);

            return $this->uploadPath . '/' . $filename;
        }

        if ($setting && $setting->type === 'image') {
            return $setting->value;
        }

        return null;
    }

    protected function cleanupObsoleteFile(?string $oldType, ?string $oldValue, ?string $newType, ?string $newValue): void {
        if ($oldType !== 'image' || empty($oldValue)) {
            return;
        }

        if ($newType === 'image' && $oldValue === $newValue) {
            return;
        }

        $this->deletePhysicalFile($oldValue);
    }

    protected function deleteFileIfImage(?string $type, ?string $value): void {
        if ($type === 'image' && !empty($value)) {
            $this->deletePhysicalFile($value);
        }
    }

    protected function deletePhysicalFile(string $relativePath): void {
        $fullPath = public_path($relativePath);

        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    protected function normalizeBoolean($value): string {
        return in_array((string) $value, ['1', 'true', 'on', 'yes'], true) ? '1' : '0';
    }

    protected function validationAttributes(): array {
        return [
            'label' => 'label',
            'key' => 'key',
            'type' => 'type',
            'value' => 'value',
            'group_name' => 'group',
            'description' => 'deskripsi',
            'is_core' => 'core setting',
        ];
    }
}