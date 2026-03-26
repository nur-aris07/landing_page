@extends('admin.layouts.admin')
@section('title', 'Detail Spec Katalog')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999999 !important;
        }

        .modal-box {
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            width: 320px;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }
    </style>
@endpush
@section('content')
    <div class="page-header fade-in-up">
        <div>
            <h1 class="page-title">Detail Spec Katalog</h1>
            <p class="page-subtitle">
                Kelola detail spec untuk katalog
                <strong>{{ $catalog->title }}</strong>
                pada layanan
                <strong>{{ optional($catalog->category)->name ?? '-' }}</strong>.
            </p>
        </div>

        <a href="{{ route('catalogs.index') }}" class="qa-btn">
            <i class="ti ti-arrow-left"></i>
            <span>Kembali ke Katalog</span>
        </a>
    </div>

    <section class="card fade-in-up" style="margin-bottom: 20px;">
        <div class="card-header">
            <div>
                <h2 class="card-title">Informasi Katalog</h2>
                <p class="card-subtitle">Ringkasan katalog yang sedang kamu atur.</p>
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 120px 1fr; gap:16px; align-items:flex-start;">
            <div>
                <img
                    src="{{ $catalog->image_url }}"
                    alt="{{ $catalog->title }}"
                    style="width:120px; height:120px; object-fit:cover; border-radius:16px; border:1px solid #e5e7eb;"
                >
            </div>

            <div style="display:grid; gap:10px;">
                <div>
                    <div style="font-size:.82rem; color:var(--text-muted);">Judul</div>
                    <div style="font-weight:600; color:var(--text-dark);">{{ $catalog->title }}</div>
                </div>

                <div>
                    <div style="font-size:.82rem; color:var(--text-muted);">Layanan</div>
                    <div style="font-weight:600; color:var(--text-dark);">{{ optional($catalog->category)->name ?? '-' }}</div>
                </div>

                <div>
                    <div style="font-size:.82rem; color:var(--text-muted);">Harga</div>
                    <div style="font-weight:600; color:var(--text-dark);">{{ $catalog->formatted_price }}</div>
                </div>

                <div>
                    <div style="font-size:.82rem; color:var(--text-muted);">Lokasi</div>
                    <div style="color:var(--text-dark);">{{ $catalog->location ?: '-' }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="card fade-in-up">
        <div class="card-header">
            <div>
                <h2 class="card-title">Form Spec Katalog</h2>
                <p class="card-subtitle">
                    Isi spesifikasi sesuai kategori layanan. Field bertanda
                    <span style="color:#dc2626; font-weight:700;">*</span>
                    wajib diisi.
                </p>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-bottom:15px;">
                <button type="button" id="btnToggleEdit" class="qa-btn">
                    <i class="ti ti-pencil"></i>
                    <span id="btnToggleText">Edit</span>
                </button>
            </div>
        </div>

        {{-- @if(session('success'))
            <div style="
                margin-bottom: 16px;
                padding: 12px 14px;
                border-radius: 12px;
                background: rgba(16,185,129,.10);
                color: #059669;
                font-size: .9rem;
                font-weight: 600;
            ">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="
                margin-bottom: 16px;
                padding: 14px 16px;
                border-radius: 12px;
                background: rgba(239,68,68,.08);
                border: 1px solid rgba(239,68,68,.16);
                color: #b91c1c;
            ">
                <div style="font-weight:700; margin-bottom:8px;">Ada data yang perlu diperbaiki:</div>
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom:4px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form id="formCatalogSpecs" action="{{ route('catalogs.specs.add', $catalog->hash_id) }}" method="POST">
            @csrf

            @if($specs->isEmpty())
                <div style="
                    padding: 18px;
                    border-radius: 14px;
                    background: #f8fafc;
                    border: 1px solid #e5e7eb;
                    color: var(--text-muted);
                ">
                    Belum ada spec aktif untuk layanan ini. Tambahkan dulu spec pada kategori layanan terkait.
                </div>
            @else
                <div style="display:grid; gap:18px;">
                    @foreach($specs as $spec)
                        @php
                            $oldValue = old('specs.' . $spec->id);
                            $existingValue = optional($existingValues->get($spec->id))->spec_value;
                            $value = $oldValue ?? $existingValue ?? '';
                            $required = (int) $spec->is_required === 1;
                        @endphp

                        <div style="
                            border: 1px solid #e5e7eb;
                            border-radius: 16px;
                            padding: 16px;
                            background: #fff;
                        ">
                            <div style="display:flex; justify-content:space-between; gap:12px; margin-bottom:10px; flex-wrap:wrap;">
                                <div>
                                    <label for="spec_{{ $spec->id }}" style="display:block; font-weight:700; color:var(--text-dark); margin-bottom:4px;">
                                        {{ $spec->spec_label }}
                                        @if($required)
                                            <span style="color:#dc2626;">*</span>
                                        @endif
                                    </label>

                                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                        <span style="
                                            display:inline-flex;
                                            align-items:center;
                                            padding:5px 10px;
                                            border-radius:999px;
                                            background:#f8fafc;
                                            border:1px solid #e5e7eb;
                                            color:#475569;
                                            font-size:.78rem;
                                            font-family:monospace;
                                        ">
                                            {{ $spec->spec_key }}
                                        </span>

                                        <span style="
                                            display:inline-flex;
                                            align-items:center;
                                            padding:5px 10px;
                                            border-radius:999px;
                                            font-size:.78rem;
                                            font-weight:700;
                                            {{ $required
                                                ? 'background:rgba(245,158,11,.12); color:#d97706;'
                                                : 'background:#f3f4f6; color:#6b7280;' }}
                                        ">
                                            {{ $required ? 'Wajib' : 'Opsional' }}
                                        </span>
                                    </div>
                                </div>

                                <div style="
                                    display:inline-flex;
                                    align-items:center;
                                    padding:5px 10px;
                                    border-radius:10px;
                                    background:#f8fafc;
                                    border:1px solid #e5e7eb;
                                    color:#475569;
                                    font-size:.78rem;
                                ">
                                    Urutan: {{ $spec->sort_order }}
                                </div>
                            </div>

                            <textarea
                                id="spec_{{ $spec->id }}"
                                name="specs[{{ $spec->id }}]"
                                rows="3"
                                class="spec-input"
                                placeholder="Masukkan nilai untuk {{ $spec->spec_label }}"
                                @if($required)
                                    required                                    
                                @endif
                                style="
                                    width:100%;
                                    border:1px solid #e5e7eb;
                                    border-radius:12px;
                                    padding:12px 14px;
                                    outline:none;
                                    resize:vertical;
                                    color:var(--text-dark);
                                    background:#fff;
                                "
                                readonly
                            >{{ $value }}</textarea>

                            @error('specs.' . $spec->id)
                                <div style="margin-top:8px; color:#dc2626; font-size:.82rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                    <button type="submit" id="btnSubmitSpecs" class="qa-btn primary" disabled>
                        <i class="ti ti-device-floppy"></i>
                        <span id="btnSubmitTextSpecs">Simpan Detail Spec</span>
                        <span id="btnSpinnerSpecs" class="is-hidden">...</span>
                    </button>
                </div>
            @endif
        </form>
    </section>
    <div id="modalConfirmCancel" class="modal">
        <div class="modal-backdrop"></div>

        <div class="modal-container">
            <div class="modal-dialog" style="max-width: 420px;">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title" style="color:#dc2626;">Batalkan Perubahan?</h3>
                    </div>
                </div>

                <form class="modal-form">
                    <div class="modal-body">
                        <div style="display:flex; gap:12px; align-items:flex-start;">
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
                                <i class="ti ti-alert-circle"></i>
                            </div>
    
                            <p style="font-size:.9rem; color:var(--text-muted); line-height:1.5;">
                                Perubahan yang belum disimpan akan hilang. 
                                Yakin ingin membatalkan?
                            </p>
                        </div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" id="btnCancelNo" class="btn-secondary">
                            Tidak
                        </button>
                        <button type="button" id="btnCancelYes" class="btn-primary-dark">
                            Ya, Batalkan
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

        let isEditMode = false;
        let initialData = {};

        function storeInitialValues() {
            $('.spec-input').each(function() {
                initialData[$(this).attr('id')] = $(this).val();
            });
        }

        function resetToInitial() {
            $('.spec-input').each(function() {
                let id = $(this).attr('id');
                $(this).val(initialData[id]);
            });
        }

        function setReadonly(state) {
            $('.spec-input').prop('readonly', state);

            if (state) {
                $('.spec-input').css('background', '#f9fafb');
            } else {
                $('.spec-input').css('background', '#fff');
            }
        }

        function toggleEditMode(enable) {
            isEditMode = enable;

            setReadonly(!enable);

            $('#btnSubmitSpecs').prop('disabled', !enable);

            if (enable) {
                $('#btnToggleText').text('Batal');
                $('#btnToggleEdit i').attr('class', 'ti ti-x');
            } else {
                $('#btnToggleText').text('Edit');
                $('#btnToggleEdit i').attr('class', 'ti ti-pencil');
            }
        }

        function openModal(modalId) {
            $(modalId).addClass('show');
            $('body').css('overflow', 'hidden');
        }

        function closeModal(modalId) {
            $(modalId).removeClass('show');
            $('body').css('overflow', '');
        }

        function openCancelModal() {
            openModal('#modalConfirmCancel');
        }

        function closeCancelModal() {
            closeModal('#modalConfirmCancel');
        }

        $(document).ready(function () {
            storeInitialValues();
            setReadonly(true);
            
            $('#formCatalogSpecs').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let data = new FormData(this);
                let btn = $('#btnSubmitSpecs');

                // reset error UI dulu
                $('.text-error').remove();

                btn.prop('disabled', true);
                $('#btnSubmitTextSpecs').text('Menyimpan...');
                $('#btnSpinnerSpecs').removeClass('is-hidden');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,

                    success: function(res) {
                        toastr.success(res.message);
                        storeInitialValues();
                        toggleEditMode(false);
                    },

                    error: function(xhr) {
                        let res = xhr.responseJSON;

                        if (xhr.status === 422) {
                            toastr.error(res.message);

                            // 🔥 tampilkan error per field (INI YANG PENTING)
                            if (res.errors) {
                                Object.keys(res.errors).forEach(function(key) {

                                    let specId = key.split('.')[1];
                                    let field = key.replace('.', '_'); 
                                    let input = $('#spec_' + specId);

                                    if (input.length) {
                                        input.after(`
                                            <div class="text-error" style="color:#dc2626; font-size:.8rem; margin-top:6px;">
                                                ${res.errors[key][0]}
                                            </div>
                                        `);
                                    }
                                });
                            }

                        } else {
                            toastr.error(res?.message || 'Terjadi kesalahan');
                        }
                    },

                    complete: function() {
                        btn.prop('disabled', false);
                        $('#btnSubmitTextSpecs').text('Simpan Detail Spec');
                        $('#btnSpinnerSpecs').addClass('is-hidden');
                    }
                });
            });

            $('#btnToggleEdit').on('click', function() {
                if (!isEditMode) {
                    toggleEditMode(true);
                } else {
                    openCancelModal();
                    console.log('ok');
                    
                }
            });

            $('#btnCancelNo').on('click', function() {
                closeCancelModal();
            });

            $('#btnCancelYes').on('click', function() {
                resetToInitial();
                toggleEditMode(false);
                closeCancelModal();
            });

            $('#modalConfirmCancel').on('click', function(e) {
                if ($(e.target).is('#modalConfirmCancel')) {
                    closeCancelModal();
                }
            });
        });
    </script>
@endpush