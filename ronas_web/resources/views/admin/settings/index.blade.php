@extends('admin.layouts.admin')
@section('title', 'Settings')

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
    </style>
@endpush

@section('content')
   <div class="page-header fade-in-up">
        <div>
            <h1 class="page-title">Settings</h1>
            <p class="page-subtitle">Kelola konfigurasi aplikasi secara dinamis tanpa ubah kode.</p>
        </div>
        <button id="add-btn" class="qa-btn primary">
            <i class="ti ti-plus"></i>
            <span>Tambah Setting</span>
        </button>
    </div>

    <section class="card fade-in-up">
        <div class="table-wrap">
            <table id="datatable" class="admin-data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Label</th>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Type</th>
                        <th>Group</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>
    @php
        $isSuperadmin = (Auth::user()->role === 'superadmin');
    @endphp
    {{-- Modal Add --}}
    <div id="modalAdd" class="modal">
        <div class="modal-backdrop" id="modalBackdropAdd"></div>

        <div class="modal-container">
            <div class="modal-dialog">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">Tambah Seetings</h3>
                        <p class="modal-subtitle">Isi data Konfigurasi dengan benar.</p>
                    </div>

                    <button type="button" id="modalCloseAdd" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormAdd" class="modal-form" action="{{ route('settings.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Label</label>
                            <input name="label" type="text" class="form-input" placeholder="Contoh: Nama Website" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Key</label>
                            <input name="key" type="text" class="form-input" placeholder="contoh: site_name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select name="type" id="typeAdd" class="form-select">
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="number">Number</option>
                                <option value="boolean">Boolean</option>
                                <option value="url">URL</option>
                                <option value="email">Email</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Value</label>
                            <input id="valueAdd" name="value" type="text" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Group</label>
                            <input name="group_name" type="text" class="form-input" placeholder="general">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-input"></textarea>
                        </div>
                        @if($isSuperadmin)
                            <div class="form-group">
                                <label class="form-label">Core Setting</label>
                                <select id="isCoreEdit" name="is_core" class="form-select">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        @endif
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

                <form id="modalFormEdit" class="modal-form" action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="idEdit" name="id">

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Label</label>
                            <input id="labelEdit" name="label" type="text" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Key</label>
                            <input id="keyEdit" name="key" type="text" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select id="typeEdit" name="type" class="form-select">
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="number">Number</option>
                                <option value="boolean">Boolean</option>
                                <option value="url">URL</option>
                                <option value="email">Email</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Value</label>
                            <div id="valueEditWrapper"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Group</label>
                            <input id="groupEdit" name="group_name" type="text" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea id="descriptionEdit" name="description" class="form-input"></textarea>
                        </div>

                        @if($isSuperadmin)
                            <div class="form-group">
                                <label class="form-label">Core Setting</label>
                                <select id="isCoreEdit" name="is_core" class="form-select">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        @endif
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
                        <h3 class="modal-title" style="color:#dc2626;">Hapus Setting</h3>
                        <p class="modal-subtitle">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>

                    <button type="button" id="modalCloseDelete" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormDelete" class="modal-form" method="POST" action="{{ route('settings.delete') }}">
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
                                    Yakin ingin menghapus setting ini?
                                </p>
                                <p style="font-size:.9rem; color:var(--text-muted); line-height:1.5;">
                                    Data Konfigurasi 
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
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        $(document).ready(function () {
            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('settings.index') }}',
                    data: function(d) {
                        d.search = d.search.value;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'label', name: 'label' },
                    { data: 'key', name: 'key' },
                    { data: 'value', name: 'value' },
                    { data: 'type', name: 'type' },
                    { data: 'group_name', name: 'group_name' },
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
                $('#labelEdit').val($(this).data('label'));
                $('#keyEdit').val($(this).data('key'));
                $('#typeEdit').val($(this).data('type'));
                $('#groupEdit').val($(this).data('group'));
                $('#descriptionEdit').val($(this).data('description'));
                $('#isCoreEdit').val($(this).data('is_core'))
                renderValueInputEdit($(this).data('type'), $(this).data('value'));

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

        function renderValueInputEdit(type, value = '') {
            let input = '';

            switch(type) {
                case 'textarea':
                    input = `<textarea id="valueEdit" name="value" class="form-input">${value ?? ''}</textarea>`;
                    break;

                case 'boolean':
                    input = `
                        <select id="valueEdit" name="value" class="form-select">
                            <option value="1" ${value == 1 ? 'selected' : ''}>True</option>
                            <option value="0" ${value == 0 ? 'selected' : ''}>False</option>
                        </select>`;
                    break;

                case 'number':
                    input = `<input id="valueEdit" type="number" name="value" class="form-input" value="${value ?? ''}">`;
                    break;

                default:
                    input = `<input id="valueEdit" type="text" name="value" class="form-input" value="${value ?? ''}">`;
            }

            $('#valueEditWrapper').html(input);
        }
    </script>
@endpush