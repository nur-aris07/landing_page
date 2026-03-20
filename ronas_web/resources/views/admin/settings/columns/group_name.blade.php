<span style="
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 10px;
    border-radius:999px;
    background:#f8fafc;
    border:1px solid #e5e7eb;
    color:#475569;
    font-size:.8rem;
    font-weight:600;
">
    {{ ucfirst(str_replace('_', ' ', $setting->group_name ?? 'general')) }}
</span>