<div style="display:flex; align-items:center; gap:12px;">
    @if(!empty($service->image))
        <img
            src="{{ asset($service->image) }}"
            alt="{{ $service->name }}"
            style="width:44px; height:44px; border-radius:12px; object-fit:cover; border:1px solid #e5e7eb; flex-shrink:0;"
        >
    @else
        <div style="
            width:44px;
            height:44px;
            border-radius:12px;
            background:#f8fafc;
            border:1px solid #e5e7eb;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#64748b;
            font-weight:700;
            flex-shrink:0;
        ">
            {{ strtoupper(substr($service->name ?? 'S', 0, 1)) }}
        </div>
    @endif

    <div style="display:flex; flex-direction:column; gap:2px;">
        <span style="font-weight:600; color:var(--text-dark);">
            {{ $service->name ?? '-' }}
        </span>
        <small style="color:var(--text-muted); font-size:.8rem;">
            ID: {{ $service->id }}
        </small>
    </div>
</div>