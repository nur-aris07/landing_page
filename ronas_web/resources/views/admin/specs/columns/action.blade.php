<div style="display:flex; align-items:center; gap:8px;">
    <button
        type="button"
        class="qa-btn edit-btn"
        title="Edit"
        data-id="{{ $spec->hash_id }}"
        {{-- data-service_category_id="{{ $spec->service_category_id }}" --}}
        data-key="{{ $spec->spec_key }}"
        data-label="{{ $spec->spec_label }}"
        data-required="{{ $spec->is_required }}"
        data-status="{{ $spec->is_active }}"
        data-sort_order="{{ $spec->sort_order }}"
    >
        <i class="ti ti-edit"></i>
    </button>

    <button
        type="button"
        class="qa-btn delete-btn"
        title="Hapus"
        data-id="{{ $spec->hash_id }}"
        data-name="{{ $spec->spec_label }}"
    >
        <i class="ti ti-trash"></i>
    </button>
</div>