<div style="display:flex; flex-direction:column; gap:2px;">
    <span style="font-weight:600; color:var(--text-dark);">
        {{ $catalog->formatted_price }}
    </span>

    @if(!is_null($catalog->price) && !empty($catalog->price_label))
        <small style="color:var(--text-muted); font-size:.8rem;">
            {{ $catalog->price_label }}
        </small>
    @endif
</div>