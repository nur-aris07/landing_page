<div style="display:flex; align-items:center; gap:8px;">
    <a
        href="{{ route('services.specs', $service->hash_id) }}"
        class="qa-btn"
        title="Detail Spec"
    >
        <i class="ti ti-list-details"></i>
    </a>
    <button
        type="button"
        class="qa-btn edit-btn"
        title="Edit"
        data-id="{{ $service->hash_id }}"
        data-name="{{ $service->name }}"
        data-description="{{ e($service->description) }}"
        data-icon="{{ $service->icon }}"
        data-image="{{ $service->image }}"
        data-status="{{ $service->is_active }}"
    >
        <i class="ti ti-edit"></i>
    </button>

    <button
        type="button"
        class="qa-btn delete-btn"
        title="Hapus"
        data-id="{{ $service->hash_id }}"
        data-name="{{ $service->name }}"
    >
        <i class="ti ti-trash"></i>
    </button>
</div>