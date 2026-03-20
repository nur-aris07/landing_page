@php
    $type = strtolower($setting->type ?? 'text');

    $styles = match($type) {
        'text' => 'background:rgba(59,130,246,.10); color:#2563eb;',
        'textarea' => 'background:rgba(139,92,246,.10); color:#7c3aed;',
        'number' => 'background:rgba(245,158,11,.12); color:#d97706;',
        'boolean' => 'background:rgba(16,185,129,.12); color:#059669;',
        'json' => 'background:rgba(99,102,241,.12); color:#4f46e5;',
        'image' => 'background:rgba(236,72,153,.12); color:#db2777;',
        'url' => 'background:rgba(14,165,233,.12); color:#0284c7;',
        'email' => 'background:rgba(107,114,128,.12); color:#4b5563;',
        default => 'background:#f3f4f6; color:#374151;',
    };
@endphp

<span style="
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 10px;
    border-radius:999px;
    font-size:.78rem;
    font-weight:700;
    {{ $styles }}
">
    {{ ucfirst($setting->type) }}
</span>