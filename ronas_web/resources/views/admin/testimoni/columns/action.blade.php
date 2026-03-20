<div style="display:flex; align-items:center; gap:8px;">
    <button
        type="button"
        class="qa-btn edit-btn"
        title="Edit"
        data-id="{{ $testimoni->id }}"
        data-customer_name="{{ $testimoni->customer_name }}"
        data-customer_title="{{ $testimoni->customer_title }}"
        data-customer_city="{{ $testimoni->customer_city }}"
        data-message="{{ e($testimoni->message) }}"
        data-rating="{{ $testimoni->rating }}"
        data-image="{{ $testimoni->image }}"
        data-is_active="{{ $testimoni->is_active }}"
    >
        <i class="ti ti-edit"></i>
    </button>

    <button
        type="button"
        class="qa-btn delete-btn"
        title="Hapus"
        data-id="{{ $testimoni->id }}"
        data-name="{{ $testimoni->customer_name }}"
    >
        <i class="ti ti-trash"></i>
    </button>
</div>