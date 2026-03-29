<div style="display:flex; align-items:center; gap:8px;">
    <button
        type="button"
        class="qa-btn edit-btn"
        title="Edit"
        data-id="{{ $setting->hash_id }}"
        data-label="{{ e($setting->label) }}"
        data-key="{{ e($setting->key) }}"
        data-value="{{ e($setting->value) }}"
        data-type="{{ $setting->type }}"
        data-group="{{ e($setting->group_name) }}"
        data-description="{{ e($setting->description) }}"
        data-is_core="{{ $setting->is_core }}"
        data-can-manage="{{ $user->role === 'superadmin' ? 1 : 0 }}"
    >
        <i class="ti ti-edit"></i>
    </button>

    @if($user->role === 'superadmin')
        <button
            type="button"
            class="qa-btn delete-btn"
            title="Hapus"
            data-id="{{ $setting->hash_id }}"
            data-label="{{ e($setting->label) }}"
        >
            <i class="ti ti-trash"></i>
        </button>
    @endif
</div>