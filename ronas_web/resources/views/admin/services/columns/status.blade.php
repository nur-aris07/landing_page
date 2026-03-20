@php
    $isActive = (int) ($service->is_active ?? 0) === 1;
@endphp

<span style="
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 10px;
    border-radius:999px;
    font-size:.78rem;
    font-weight:700;
    {{ $isActive
        ? 'background:rgba(16,185,129,.12); color:#059669;'
        : 'background:rgba(239,68,68,.10); color:#dc2626;' }}
">
    {{ $isActive ? 'Aktif' : 'Nonaktif' }}
</span>