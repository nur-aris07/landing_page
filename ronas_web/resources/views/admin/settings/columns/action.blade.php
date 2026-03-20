<div style="display:flex; align-items:center; gap:8px;">
    <button
        type="button"
        class="qa-btn edit-btn"
        title="Edit"
        data-id="{{ $setting->id }}"
        data-label="{{ $setting->label }}"
        data-key="{{ $setting->key }}"
        data-value="{{ e($setting->value) }}"
        data-type="{{ $setting->type }}"
        data-group_name="{{ $setting->group_name }}"
        data-description="{{ e($setting->description) }}"
        data-is_core="{{ $setting->is_core }}"
    >
        <i class="ti ti-edit"></i>
    </button>

    @if(Auth::user()->role === 'superadmin' || !$setting->is_core)
        <button
            type="button"
            class="qa-btn delete-btn"
            title="Hapus"
            data-id="{{ $setting->id }}"
            data-label="{{ $setting->label }}"
        >
            <i class="ti ti-trash"></i>
        </button>
    @endif
</div>