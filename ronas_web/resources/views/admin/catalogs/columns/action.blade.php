<div style="display:flex; align-items:center; gap:8px;">
    <a
        {{-- href="{{ route('catalogs.details.index', $catalog->id) }}" --}}
        class="qa-btn"
        title="Detail Katalog"
    >
        <i class="ti ti-list-details"></i>
    </a>

    <button
        type="button"
        class="qa-btn warning edit-btn"
        title="Edit"
        data-id="{{ $catalog->hash_id }}"
        data-title="{{ $catalog->title }}"
        data-description="{{ e($catalog->description) }}"
        data-service="{{ optional($catalog->category)->hash_id ?? '' }}"
        data-price="{{ $catalog->price }}"
        data-price_label="{{ $catalog->price_label }}"
        data-location="{{ $catalog->location }}"
        data-message="{{ e($catalog->whatsapp_message) }}"
        data-status="{{ $catalog->is_active }}"
    >
        <i class="ti ti-pencil"></i>
    </button>

    <button
        type="button"
        class="qa-btn danger delete-btn"
        title="Hapus"
        data-id="{{ $catalog->id }}"
        data-name="{{ $catalog->title }}"
    >
        <i class="ti ti-trash"></i>
    </button>
</div>