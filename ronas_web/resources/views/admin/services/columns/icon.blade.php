@if(!empty($service->icon))
    <div style="display:flex; align-items:center; gap:10px;">
        <span style="
            width:36px;
            height:36px;
            border-radius:10px;
            background:#f8fafc;
            border:1px solid #e5e7eb;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color:#334155;
            flex-shrink:0;
        ">
            <i class="{{ $service->icon }}"></i>
        </span>

        <span style="font-size:.82rem; color:#475569; font-family:monospace;">
            {{ $service->icon }}
        </span>
    </div>
@else
    <span style="color:var(--text-muted);">-</span>
@endif