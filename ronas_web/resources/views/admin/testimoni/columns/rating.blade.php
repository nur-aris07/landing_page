@php
    $rating = (int) ($testimoni->rating ?? 0);
@endphp

<div style="display:flex; align-items:center; gap:8px;">
    <div style="display:flex; align-items:center; gap:2px; color:#f59e0b;">
        @for($i = 1; $i <= 5; $i++)
            <i class="ti ti-star-filled" style="font-size:16px; opacity:{{ $i <= $rating ? '1' : '.25' }};"></i>
        @endfor
    </div>

    <span style="font-size:.82rem; font-weight:600; color:var(--text-dark);">
        {{ $rating > 0 ? $rating . '/5' : '-' }}
    </span>
</div>