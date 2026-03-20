<div class="table-actions">
    <button href="#" class="reset-btn qa-btn" title="Reset" data-id="{{ ($user->hash_id) }}">
        <i class="ti ti-refresh"></i>
    </button>

    <button href="#" class="edit-btn qa-btn" title="Edit"
        data-id="{{ $user->hash_id }}"
        data-name="{{ $user->name }}"
        data-username="{{ $user->username }}"
        data-role="{{ $user->role }}"
        data-status="{{ $user->is_active }}"
    >
        <i class="ti ti-edit"></i>
    </button>

    <button type="button" class="delete-btn qa-btn" title="Hapus" data-id="{{ $user->hash_id }}" data-name="{{ $user->name }}">
        <i class="ti ti-trash"></i>
    </button>
</div>