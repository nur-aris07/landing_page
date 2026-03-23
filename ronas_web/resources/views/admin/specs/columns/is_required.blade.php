@php
    $required = (int) ($spec->is_required ?? 0) === 1;
@endphp

<span style="
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 10px;
    border-radius:999px;
    font-size:.78rem;
    font-weight:700;
    {{ $required
        ? 'background:rgba(245,158,11,.12); color:#d97706;'
        : 'background:#f3f4f6; color:#6b7280;' }}
">
    {{ $required ? 'Wajib' : 'Opsional' }}
</span>