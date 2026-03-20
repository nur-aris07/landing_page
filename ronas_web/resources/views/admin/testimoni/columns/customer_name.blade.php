<div style="display:flex; align-items:center; gap:12px;">
    @if(!empty($testimoni->image))
        <img
            src="{{ asset($testimoni->image) }}"
            alt="{{ $testimoni->customer_name }}"
            style="width:42px; height:42px; border-radius:50%; object-fit:cover; border:1px solid #e5e7eb; flex-shrink:0;"
        >
    @else
        <div style="
            width:42px;
            height:42px;
            border-radius:50%;
            background:#f3f4f6;
            color:#6b7280;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:.9rem;
            flex-shrink:0;
        ">
            {{ strtoupper(substr($testimoni->customer_name ?? 'U', 0, 1)) }}
        </div>
    @endif

    <div style="display:flex; flex-direction:column; gap:2px;">
        <span style="font-weight:600; color:var(--text-dark);">
            {{ $testimoni->customer_name ?? '-' }}
        </span>

        @if($testimoni->customer_title || $testimoni->customer_city)
            <small style="color:var(--text-muted); font-size:.8rem;">
                {{ $testimoni->customer_title ?? '-' }}
                @if($testimoni->customer_title && $testimoni->customer_city)
                    •
                @endif
                {{ $testimoni->customer_city ?? '' }}
            </small>
        @endif
    </div>
</div>