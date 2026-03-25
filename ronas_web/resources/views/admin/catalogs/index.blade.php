@extends('admin.layouts.admin')
@section('title', 'Catalogs')

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
        .dataTables_wrapper .dataTables_length select,
        .catalog-filter-select {
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

        .catalog-filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .catalog-filter-item {
            min-width: 240px;
        }
    </style>
@endpush

@section('content')
   <div class="page-header fade-in-up">
        <div>
            <h1 class="page-title">Catalogs</h1>
            <p class="page-subtitle">Kelola data katalog layanan.</p>
        </div>
        <button id="add-btn" class="qa-btn primary">
            <i class="ti ti-plus"></i>
            <span>Tambah Catalog</span>
        </button>
    </div>

    <section class="card fade-in-up">
        <div class="catalog-filter-bar">
            <div class="catalog-filter-item">
                <select id="filterService" class="catalog-filter-select" style="width:100%;">
                    <option value="">Semua Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->hash_id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button" id="resetFilter" class="btn-secondary">
                Reset Filter
            </button>
        </div>
        <div class="table-wrap">
            <table id="datatable" class="admin-data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Status</th>
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
                        <h3 class="modal-title">Tambah Catalog</h3>
                        <p class="modal-subtitle">Isi data Katalog dengan benar.</p>
                    </div>

                    <button type="button" id="modalCloseAdd" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormAdd" class="modal-form" action="{{ route('catalogs.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label required-field">Service</label>
                            <select name="service" class="form-select" required>
                                <option value="">Pilih Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->hash_id }}">
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required-field">Title</label>
                            <input name="title" type="text" class="form-input" placeholder="Masukkan judul katalog" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-input" placeholder="Masukkan deskripsi katalog"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label required-field">Gambar</label>

                            <div class="image-upload" id="imageUploadAdd">
                                <input type="file" name="image" id="imageInputAdd" class="image-upload__input" accept="image/*" required>

                                <label for="imageInputAdd" class="image-upload__label">
                                    <div class="image-upload__icon">
                                        <i class="ti ti-photo-plus"></i>
                                    </div>

                                    <div class="image-upload__content">
                                        <div class="image-upload__title">Pilih gambar</div>
                                        <div class="image-upload__subtitle">
                                            Klik untuk upload atau drag & drop ringan
                                        </div>
                                        <div class="image-upload__meta" id="imageFileNameAdd">
                                            Belum ada file dipilih
                                        </div>
                                    </div>

                                    <span class="image-upload__button">Browse</span>
                                </label>

                                <div class="image-upload__preview" id="imagePreviewBoxAdd" style="display:none;">
                                    <img id="imagePreviewAdd" alt="Preview gambar">
                                    <button type="button" class="image-upload__remove" id="removeImageAdd">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                            </div>

                            <small class="form-note">Format jpg, png, webp. Disarankan rasio gambar konsisten.</small>
                        </div> 

                        <div class="form-group">
                            <label class="form-label required-field">Price</label>
                            <input name="price" type="number" step="0.01" class="form-input" placeholder="Contoh: 150000" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Price Label</label>
                            <input name="price_label" type="text" class="form-input" placeholder="Contoh: Mulai dari / Hubungi Kami">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input name="location" type="text" class="form-input" placeholder="Contoh: Gresik, Jawa Timur">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Whatsapp Message</label>
                            <textarea name="message" class="form-input" placeholder="Pesan default whatsapp"></textarea>
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
                        <h3 class="modal-title">Edit Catalog</h3>
                        <p class="modal-subtitle">Perbarui data Katalog dengan benar.</p>
                    </div>

                    <button type="button" id="modalCloseEdit" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormEdit" class="modal-form" action="{{ route('catalogs.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="idEdit" name="id">

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label required-field">Service</label>
                            <select id="serviceEdit" name="service" class="form-select" required>
                                <option value="">Pilih Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required-field">Title</label>
                            <input id="titleEdit" name="title" type="text" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea id="descriptionEdit" name="description" class="form-input"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label required-field">Gambar</label>

                            <div class="image-upload" id="imageUploadEdit">
                                <input type="file" name="image" id="imageInputEdit" class="image-upload__input" accept="image/*">

                                <label for="imageInputEdit" class="image-upload__label">
                                    <div class="image-upload__icon">
                                        <i class="ti ti-photo-edit"></i>
                                    </div>

                                    <div class="image-upload__content">
                                        <div class="image-upload__title">Ubah gambar</div>
                                        <div class="image-upload__subtitle">
                                            Upload gambar baru jika ingin mengganti gambar lama
                                        </div>
                                        <div class="image-upload__meta" id="imageFileNameEdit">
                                            Gunakan file baru atau biarkan kosong
                                        </div>
                                    </div>

                                    <span class="image-upload__button">Browse</span>
                                </label>

                                <div class="image-upload__preview" id="imagePreviewBoxEdit" style="display:none;">
                                    <img id="imagePreviewEdit" alt="Preview gambar">
                                    <button type="button" class="image-upload__remove" id="removeImageEdit">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group required-field">
                            <label class="form-label">Price</label>
                            <input id="priceEdit" name="price" type="number" step="0.01" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Price Label</label>
                            <input id="priceLabelEdit" name="price_label" type="text" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input id="locationEdit" name="location" type="text" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Whatsapp Message</label>
                            <textarea id="whatsappMessageEdit" name="message" class="form-input"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label required-field">Status</label>
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
                        <h3 class="modal-title" style="color:#dc2626;">Hapus Catalog</h3>
                        <p class="modal-subtitle">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>

                    <button type="button" id="modalCloseDelete" class="modal-close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form id="modalFormDelete" class="modal-form" method="POST" action="{{ route('catalogs.delete') }}">
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
                                    Yakin ingin menghapus Catalog ini?
                                </p>
                                <p style="font-size:.9rem; color:var(--text-muted); line-height:1.5;">
                                    Data Katalog 
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

        function initImageUploader(inputId, fileNameId, previewBoxId, previewImgId, removeBtnId, wrapperId, defaultText = 'Belum ada file dipilih') {
            const $input = $('#' + inputId);
            const $fileName = $('#' + fileNameId);
            const $previewBox = $('#' + previewBoxId);
            const $previewImg = $('#' + previewImgId);
            const $removeBtn = $('#' + removeBtnId);
            const $wrapper = $('#' + wrapperId);

            if (!$input.length) return;

            $input.on('change', function () {
                const file = this.files && this.files[0];

                if (!file) {
                    $fileName.text(defaultText);
                    $previewBox.hide();
                    $previewImg.attr('src', '');
                    $wrapper.removeClass('is-active');
                    return;
                }

                $fileName.text(file.name);
                $wrapper.addClass('is-active');

                if (file.type.indexOf('image/') === 0) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        $previewImg.attr('src', e.target.result);
                        $previewBox.show();
                    };

                    reader.readAsDataURL(file);
                }
            });

            $removeBtn.on('click', function () {
                $input.val('');
                $fileName.text(defaultText);
                $previewBox.hide();
                $previewImg.attr('src', '');
                $wrapper.removeClass('is-active');
            });
        }

        $(document).ready(function () {
            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('catalogs.index') }}',
                    data: function(d) {
                        d.search = d.search.value;
                        d.service = $('#filterService').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image_preview', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'service', name: 'category.name', orderable: false, searchable: false },
                    { data: 'price_text', name: 'price' },
                    { data: 'location', name: 'location' },
                    { data: 'status', name: 'is_active' },
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

            $('#filterService').on('change', function () {
                table.ajax.reload();
            });

            $('#resetFilter').on('click', function () {
                $('#filterService').val('');
                table.search('').draw();
                table.ajax.reload();
            });

            $('#add-btn').on('click', function () {
                $('#modalFormAdd')[0].reset();

                $('#imageInputAdd').val('');
                $('#imageFileNameAdd').text('Belum ada file dipilih');
                $('#imagePreviewAdd').attr('src', '');
                $('#imagePreviewBoxAdd').hide();
                $('#imageUploadAdd').removeClass('is-active');
                
                openModal('#modalAdd');
            });            
            $('#modalCloseAdd, #modalCancelAdd, #modalBackdropAdd').on('click', function () {
                closeModal('#modalAdd');
            });
            $('#modalFormAdd').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let data = new FormData(this);
                let btn = $('#formSubmitAdd');

                btn.prop('disabled', true);
                $('#formSubmitTextAdd').text('Menyimpan...');
                $('#formSpinnerAdd').removeClass('is-hidden');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        closeModal('#modalAdd');
                        form[0].reset();
                        $('#imageInputAdd').val('');
                        $('#imageFileNameAdd').text('Belum ada file dipilih');
                        $('#imagePreviewAdd').attr('src', '');
                        $('#imagePreviewBoxAdd').hide();
                        $('#imageUploadAdd').removeClass('is-active');
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
                $('#titleEdit').val($(this).data('title'));
                $('#descriptionEdit').val($(this).data('description'));
                $('#serviceEdit').val($(this).data('service'));
                $('#priceEdit').val($(this).data('price'));
                $('#priceLabelEdit').val($(this).data('price_label'));
                $('#locationEdit').val($(this).data('location'));
                $('#whatsappMessageEdit').val($(this).data('message'));
                $('#statusEdit').val($(this).data('status'));
                $('#imageInputEdit').val('');
                const image = $(this).data('image');
                if (image) {
                    $('#imagePreviewEdit').attr('src', image);
                    $('#imagePreviewBoxEdit').show();
                    $('#imageFileNameEdit').text('Gambar saat ini');
                    $('#imageUploadEdit').addClass('is-active');
                } else {
                    $('#imagePreviewEdit').attr('src', '');
                    $('#imagePreviewBoxEdit').hide();
                    $('#imageFileNameEdit').text('Gunakan file baru atau biarkan kosong');
                    $('#imageUploadEdit').removeClass('is-active');
                }

                openModal('#modalEdit');
            });
            $('#modalCloseEdit, #modalCancelEdit, #modalBackdropEdit').on('click', function () {
                closeModal('#modalEdit');
            });
            $('#modalFormEdit').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let data = new FormData(this);
                let btn = $('#formSubmitEdit');

                btn.prop('disabled', true);
                $('#formSubmitTextEdit').text('Mengupdate...');
                $('#formSpinnerEdit').removeClass('is-hidden');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
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
                console.log($(this).data('id'));
                console.log($('#idDelete').val());
                
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

            initImageUploader(
                'imageInputAdd',
                'imageFileNameAdd',
                'imagePreviewBoxAdd',
                'imagePreviewAdd',
                'removeImageAdd',
                'imageUploadAdd'
            );

            initImageUploader(
                'imageInputEdit',
                'imageFileNameEdit',
                'imagePreviewBoxEdit',
                'imagePreviewEdit',
                'removeImageEdit',
                'imageUploadEdit',
                'Gunakan file baru atau biarkan kosong'
            );
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
@endpush