@extends('admin.layouts.admin')

@section('title', 'Detail Spec Layanan')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .admin-data-table {
            width: 100% !important;
            border-collapse: collapse;
        }

        .admin-data-table thead th {
            font-size: .78rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .04em;
            white-space: nowrap;
        }

        .admin-data-table tbody td {
            vertical-align: middle;
        }

        .table-user-name {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .table-user-name__main {
            font-weight: 600;
            color: var(--text-dark);
        }

        .table-user-name__sub,
        .table-user-muted {
            color: var(--text-muted);
            font-size: .86rem;
        }

        .table-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-actions .qa-btn {
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
        }

        .badge-role-admin {
            background: rgba(232,184,75,.12);
            color: #b7791f;
        }

        .badge-role-super {
            background: rgba(59,130,246,.12);
            color: #2563eb;
        }

        .badge-role-user {
            background: rgba(16,185,129,.12);
            color: #059669;
        }

        .badge-status-active {
            background: rgba(16,185,129,.12);
            color: #059669;
        }

        .badge-status-inactive {
            background: rgba(239,68,68,.10);
            color: #dc2626;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 16px;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 8px 12px;
            background: #fff;
            color: var(--text-dark);
            outline: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 10px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #111 !important;
        }

        #sortSpecModal .modal-dialog {
            width: 100%;
            max-height: calc(100vh - 48px);
            display: flex;
            flex-direction: column;
        }

        #sortSpecModal .modal-body {
            overflow-y: auto;
        }

        #sortSpecModal .modal-dialog-sort {
            width: 100%;
            max-width: 760px;
            max-height: calc(100vh - 64px);
            display: flex;
            flex-direction: column;
            border-radius: 24px;
            overflow: hidden;
        }

        #sortSpecModal .modal-header {
            padding: 22px 24px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        #sortSpecModal .modal-title {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.2;
        }

        #sortSpecModal .modal-subtitle {
            margin: 8px 0 0;
            font-size: .95rem;
            color: #6b7280;
            line-height: 1.5;
        }

        #sortSpecModal .modal-body-sort {
            padding: 20px 24px;
            overflow-y: auto;
        }

        #sortSpecModal .modal-footer-sort {
            padding: 16px 24px 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .sort-state {
            padding: 18px 16px;
            border: 1px dashed #d1d5db;
            border-radius: 16px;
            background: #f9fafb;
            color: #6b7280;
            font-size: .95rem;
            line-height: 1.5;
            text-align: center;
        }

        .sort-helper-text {
            margin-bottom: 14px;
            font-size: .92rem;
            color: #6b7280;
            line-height: 1.5;
        }

        .sort-hidden {
            display: none !important;
        }

        .sortable-spec-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 420px;
            overflow-y: auto;
        }

        .sortable-spec-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fff;
        }

        .sortable-spec-item:hover {
            border-color: #d1d5db;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        }

        .sortable-spec-handle {
            cursor: grab;
            user-select: none;
            color: #6b7280;
            flex-shrink: 0;
        }

        .sortable-spec-order {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: #f3f4f6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #4b5563;
            flex-shrink: 0;
        }

        .sortable-spec-content {
            min-width: 0;
            flex: 1;
        }

        .sortable-spec-label {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            line-height: 1.3;
        }

        .sortable-spec-key {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
            line-height: 1.3;
        }

        .sortable-ghost {
            opacity: .45;
        }

        .sortable-chosen {
            background: #f9fafb;
        }
    </style>
@endpush

@section('content')
    <div class="page-header fade-in-up">
        <div>
            <h1 class="page-title">Detail Spec Layanan</h1>
            <p class="page-subtitle">
                Kelola spesifikasi untuk kategori layanan
                <strong>{{ $service->name }}</strong>.
            </p>
        </div>

        <div style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('services.index') }}" class="qa-btn">
                <i class="ti ti-arrow-left"></i>
                <span>Kembali</span>
            </a>

            <button type="button" class="qa-btn" id="btn-open-sort-modal">
                <i class="ti ti-arrows-sort"></i>
                Atur Urutan
            </button>

            <button id="add-btn" class="qa-btn primary">
                <i class="ti ti-plus"></i>
                <span>Tambah Spec</span>
            </button>
        </div>
    </div>

    <section class="card fade-in-up">
        <div class="card-header">
            <div>
                <h2 class="card-title">{{ $service->name }}</h2>
                <p class="card-subtitle">
                    Spec ini akan dipakai untuk mengisi detail katalog pada kategori ini.
                </p>
            </div>
        </div>

        <div class="table-wrap">
            <table id="datatable" class="admin-data-table" style="width:100%">
                <thead>
                    <tr>
                        <th width="6%">No</th>
                        <th>Key</th>
                        <th>Label</th>
                        <th>Wajib</th>
                        <th>Status</th>
                        <th>Urutan</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>
    {{-- Modal Add --}}
    <div id="modalAdd" class="modal">
        <div class="modal-backdrop" id="modalBackdropAdd"></div>

        <div class="modal-container">
            <div class="modal-dialog">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">Tambah Settings</h3>
                        <p class="modal-subtitle">Isi data Konfigurasi dengan benar.</p>
                    </div>

                    <button type="button" id="modalCloseAdd" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormAdd" class="modal-form" action="{{ route('specs.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service" value="{{ request()->route('service') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Spec Key</label>
                            <input type="text" name="key" class="form-input" placeholder="contoh: brand, color, capacity" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Spec Label</label>
                            <input type="text" name="label" class="form-input" placeholder="contoh: Brand, Warna, Kapasitas" required>
                        </div>

                        {{-- <div class="form-group">
                            <label class="form-label">Urutan</label>
                            <input
                                type="number"
                                name="sort_order"
                                class="form-input"
                                min="0"
                                value="0"
                            >
                        </div> --}}

                        <div class="form-group">
                            <label class="form-label">Wajib Diisi?</label>
                            <select name="required" class="form-select" required>
                                <option value="1">Ya</option>
                                <option value="0" selected>Tidak</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="modalCancelAdd" class="btn-secondary">Batal</button>

                        <button type="submit" id="formSubmitAdd" class="btn-primary-dark">
                            <span id="formSubmitTextAdd">Simpan</span>
                            <i id="formSpinnerAdd" class="ti ti-loader-2 is-hidden"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
    <div id="modalEdit" class="modal">
        <div class="modal-backdrop" id="modalBackdropEdit"></div>

        <div class="modal-container">
            <div class="modal-dialog">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">Edit Setting</h3>
                        <p class="modal-subtitle">Perbarui data Konfigurasi dengan benar.</p>
                    </div>

                    <button type="button" id="modalCloseEdit" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormEdit" class="modal-form" action="{{ route('specs.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="idEdit" name="id">

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Spec Key</label>
                            <input type="text" id="keyEdit" name="key" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Spec Label</label>
                            <input type="text" id="labelEdit" name="label" class="form-input" required>
                        </div>

                        {{-- <div class="form-group">
                            <label class="form-label">Urutan</label>
                            <input type="number" id="sortOrderEdit" name="sort_order" class="form-input" min="0">
                        </div> --}}

                        <div class="form-group">
                            <label class="form-label">Wajib Diisi?</label>
                            <select id="requiredEdit" name="required" class="form-select" required>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select id="statusEdit" name="status" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="modalCancelEdit" class="btn-secondary">Batal</button>

                        <button type="submit" id="formSubmitEdit" class="btn-primary-dark">
                            <span id="formSubmitTextEdit">Update</span>
                            <i id="formSpinnerEdit" class="ti ti-loader-2 is-hidden"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Delete --}}
    <div id="modalDelete" class="modal">
        <div class="modal-backdrop" id="modalBackdropDelete"></div>

        <div class="modal-container">
            <div class="modal-dialog" style="max-width: 420px;">
                
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title" style="color:#dc2626;">Hapus Specs</h3>
                        <p class="modal-subtitle">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>

                    <button type="button" id="modalCloseDelete" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormDelete" class="modal-form" method="POST" action="{{ route('specs.delete') }}">
                    @csrf
                    <input type="hidden" name="id" id="idDelete">

                    <div class="modal-body">               
                        <div style="display:flex; align-items:flex-start; gap:14px;">
                            <div style="
                                width:48px;
                                height:48px;
                                border-radius:12px;
                                background:rgba(220,38,38,.1);
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                color:#dc2626;
                                font-size:22px;
                                flex-shrink:0;
                            ">
                                <i class="ti ti-alert-triangle"></i>
                            </div>
                            <div>
                                <p style="font-weight:600; color:var(--text-dark); margin-bottom:4px;">
                                    Yakin ingin menghapus Specs ini?
                                </p>
                                <p style="font-size:.9rem; color:var(--text-muted); line-height:1.5;">
                                    Data Spesifikasi
                                    <span id="deleteUserName" style="font-weight:600;"></span> 
                                    akan dihapus permanen dan tidak bisa dikembalikan.
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" id="modalCancelDelete" class="btn-secondary">
                            Batal
                        </button>

                        <button type="submit" id="formSubmitDelete" class="btn-primary-dark" style="background:#dc2626;">
                            <span id="formSubmitTextDelete">Hapus</span>
                            <i id="formSpinnerDelete" class="ti ti-loader-2 is-hidden"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Modal Order --}}
    <div id="sortSpecModal" class="modal">
        <div class="modal-backdrop" id="modalBackdropSort"></div>

        <div class="modal-container">
            <div class="modal-dialog modal-dialog-sort">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">Atur Urutan Spesifikasi</h3>
                        <p class="modal-subtitle">Geser item untuk mengatur urutan, lalu simpan perubahan.</p>
                    </div>

                    <button type="button" id="modalCloseSort" class="modal-close" aria-label="Tutup">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <div class="modal-body modal-body-sort">
                    <div id="sort-loading-state" class="sort-state sort-hidden">
                        Memuat data...
                    </div>

                    <div id="sort-empty-state" class="sort-state sort-hidden">
                        Tidak ada spesifikasi aktif yang bisa diatur urutannya.
                    </div>

                    <div id="sort-list-wrapper" class="sort-hidden">
                        <div class="sort-helper-text">
                            Geser item untuk mengatur urutan.
                        </div>

                        <div id="sortable-spec-list" class="sortable-spec-list"></div>
                    </div>
                </div>

                <div class="modal-footer modal-footer-sort">
                    <button type="button" id="modalCancelSort" class="btn-secondary">
                        Batal
                    </button>

                    <button type="button" id="btn-save-sort" class="btn-primary-dark">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <script>
        let table;
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        $(document).ready(function () {
            table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('services.specs', $service->hash_id) }}',
                    data: function(d) {
                        d.search = d.search.value;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'spec_key', name: 'spec_key' },
                    { data: 'spec_label', name: 'spec_label' },
                    { data: 'is_required', name: 'is_required', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'sort_order', name: 'sort_order', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [],
                pageLength: 10,
                language: {
                    processing: "Memuat...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "›",
                        previous: "‹"
                    }
                }
            });

            $('#add-btn').on('click', function () {
                $('#modalFormAdd')[0].reset();
                openModal('#modalAdd');
            });            
            $('#modalCloseAdd, #modalCancelAdd, #modalBackdropAdd').on('click', function () {
                closeModal('#modalAdd');
            });
            $('#modalFormAdd').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('#formSubmitAdd');

                btn.prop('disabled', true);
                $('#formSubmitTextAdd').text('Menyimpan...');
                $('#formSpinnerAdd').removeClass('is-hidden');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        closeModal('#modalAdd');
                        form[0].reset();
                        table.ajax.reload(null, false);
                        toastr.success(res.message);
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        if (xhr.status === 422) {
                            toastr.error(res.message);
                        } else {
                            toastr.error(res?.message || 'Terjadi kesalahan');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        $('#formSubmitTextAdd').text('Simpan');
                        $('#formSpinnerAdd').addClass('is-hidden');
                    }
                });
            });

            $(document).on('click', '.edit-btn', function () {
                $('#idEdit').val($(this).data('id'));
                $('#keyEdit').val($(this).data('key'));
                $('#labelEdit').val($(this).data('label'));
                $('#requiredEdit').val($(this).data('required'));
                $('#statusEdit').val($(this).data('status'));

                openModal('#modalEdit');
            });
            $('#modalCloseEdit, #modalCancelEdit, #modalBackdropEdit').on('click', function () {
                closeModal('#modalEdit');
            });
            $('#modalFormEdit').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('#formSubmitEdit');

                btn.prop('disabled', true);
                $('#formSubmitTextEdit').text('Mengupdate...');
                $('#formSpinnerEdit').removeClass('is-hidden');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(res) {
                        closeModal('#modalEdit');
                        table.ajax.reload(null, false);
                        toastr.success(res.message);
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        if (xhr.status === 422) {
                            toastr.error(res.message);
                        } else {
                            toastr.error(res?.message || 'Terjadi kesalahan');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        $('#formSubmitTextEdit').text('Update');
                        $('#formSpinnerEdit').addClass('is-hidden');
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {
                $('#idDelete').val($(this).data('id'));
                $('#deleteUserName').text($(this).data('name'));
                openModal('#modalDelete');
            });
            $('#modalCloseDelete, #modalCancelDelete, #modalBackdropDelete').on('click', function () {
                closeModal('#modalDelete');
            });
            $('#modalFormDelete').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                $('#formSubmitDelete').prop('disabled', true);
                $('#formSubmitTextDelete').text('Menghapus...');
                $('#formSpinnerDelete').removeClass('is-hidden');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function (res) {
                        closeModal('#modalDelete');
                        table.ajax.reload(null, false);
                        toastr.success(res.message);
                    },
                    error: function (xhr) {
                        let res = xhr.responseJSON;
                        if (xhr.status === 422) {
                            toastr.error(res.message);
                        } else {
                            toastr.error(res?.message || 'Terjadi kesalahan');
                        }
                    },
                    complete: function() {
                        $('#formSubmitDelete').prop('disabled', false);
                        $('#formSubmitTextDelete').text('Hapus');
                        $('#formSpinnerDelete').addClass('is-hidden');
                    }
                });
            });
        });

        function openModal(modalId) {
            $(modalId).addClass('show');
            $('body').css('overflow', 'hidden');
        }

        function closeModal(modalId) {
            $(modalId).removeClass('show');
            $('body').css('overflow', '');
        }
    </script>
    <script>
        const serviceHashId = @json($service->hash_id);
        const orderItemsUrl = @json(route('specs.order-items', $service->hash_id));
        const updateOrderUrl = @json(route('specs.reorder'));

        const btnSaveSort = document.getElementById('btn-save-sort');
        const $sortLoadingState = $('#sort-loading-state');
        const $sortEmptyState = $('#sort-empty-state');
        const $sortListWrapper = $('#sort-list-wrapper');
        const $sortableSpecList = $('#sortable-spec-list');

        let sortableInstance = null;
        let isSortRequestRunning = false;

        function escapeHtml(text) {
            return $('<div>').text(text ?? '').html();
        }

        function hideAllSortStates() {
            $sortLoadingState.addClass('sort-hidden');
            $sortEmptyState.addClass('sort-hidden');
            $sortListWrapper.addClass('sort-hidden');
        }

        function setSortModalState(state) {
            hideAllSortStates();

            if (state === 'loading') {
                $sortLoadingState.removeClass('sort-hidden');
            } else if (state === 'empty') {
                $sortEmptyState.removeClass('sort-hidden');
            } else if (state === 'ready') {
                $sortListWrapper.removeClass('sort-hidden');
            }
        }

        function resetSortModal() {
            $sortableSpecList.html('');
            hideAllSortStates();

            if (sortableInstance) {
                sortableInstance.destroy();
                sortableInstance = null;
            }

            if (btnSaveSort) {
                btnSaveSort.disabled = false;
            }
        }

        function renderSortableItems(items) {
            $sortableSpecList.html('');

            items.forEach((item, index) => {
                const label = item.spec_label ? escapeHtml(item.spec_label) : '-';
                const key = item.spec_key ? escapeHtml(item.spec_key) : '-';

                $sortableSpecList.append(`
                    <div class="sortable-spec-item" data-id="${item.id}">
                        <div class="sortable-spec-handle">
                            <i class="ti ti-grip-vertical"></i>
                        </div>
                        <div class="sortable-spec-order">${index + 1}</div>
                        <div class="sortable-spec-content">
                            <div class="sortable-spec-label">${label}</div>
                            <div class="sortable-spec-key">${key}</div>
                        </div>
                    </div>
                `);
            });

            updateVisualOrderNumber();

            if (sortableInstance) {
                sortableInstance.destroy();
            }

            sortableInstance = new Sortable(document.getElementById('sortable-spec-list'), {
                animation: 150,
                handle: '.sortable-spec-handle',
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                onSort: function () {
                    updateVisualOrderNumber();
                }
            });
        }

        function updateVisualOrderNumber() {
            $('#sortable-spec-list .sortable-spec-item').each(function(index) {
                $(this).find('.sortable-spec-order').text(index + 1);
            });
        }

        function getSortedPayload() {
            const items = [];

            $('#sortable-spec-list .sortable-spec-item').each(function(index) {
                items.push({
                    id: $(this).data('id'),
                    sort_order: index + 1
                });
            });

            return items;
        }

        function loadSortableItems() {
            if (isSortRequestRunning) return;

            isSortRequestRunning = true;
            resetSortModal();
            setSortModalState('loading');

            $.ajax({
                url: orderItemsUrl,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const items = Array.isArray(response.data) ? response.data : [];

                    if (response.status !== 'success') {
                        toastr.error(response.message || 'Gagal memuat data urutan.');
                        setSortModalState('empty');
                        return;
                    }

                    if (items.length === 0) {
                        setSortModalState('empty');
                        return;
                    }

                    renderSortableItems(items);
                    setSortModalState('ready');
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat memuat data.';
                    toastr.error(message);
                    setSortModalState('empty');
                },
                complete: function() {
                    isSortRequestRunning = false;
                }
            });
        }

        $(document).on('click', '#btn-open-sort-modal', function () {
            openModal('#sortSpecModal');
            loadSortableItems();
        });

        $(document).on('click', '#btn-save-sort', function () {
            const items = getSortedPayload();

            if (!items.length) {
                toastr.info('Tidak ada data untuk disimpan.');
                return;
            }

            btnSaveSort.disabled = true;

            $.ajax({
                url: updateOrderUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    service: serviceHashId,
                    items: items
                },
                success: function(response) {
                    if (response.status === 'success') {
                        closeModal('#sortSpecModal');
                        resetSortModal();
                        toastr.success(response.message || 'Urutan berhasil diperbarui.');

                        if (table) {
                            table.ajax.reload(null, false);
                        }
                        return;
                    }

                    toastr.error(response.message || 'Gagal menyimpan urutan.');
                },
                error: function(xhr) {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan urutan.';
                    toastr.error(message);
                },
                complete: function() {
                    btnSaveSort.disabled = false;
                }
            });
        });

        $(document).on('click', '#modalCloseSort, #modalCancelSort, #modalBackdropSort', function () {
            closeModal('#sortSpecModal');
            resetSortModal();
        });
    </script>
@endpush