<div style="display:flex; flex-direction:column; gap:2px;">
    <span style="font-weight:600; color:var(--text-dark);">
        {{ $catalog->title ?? '-' }}
    </span>

    @if(!empty($catalog->description))
        <small style="color:var(--text-muted); font-size:.8rem; line-height:1.4;">
            {{ \Illuminate\Support\Str::limit(strip_tags($catalog->description), 80) }}
        </small>
    @endif
</div>