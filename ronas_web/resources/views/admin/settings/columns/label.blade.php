<div style="display:flex; flex-direction:column; gap:2px;">
    <span style="font-weight:600; color:var(--text-dark);">
        {{ $setting->label ?? '-' }}
    </span>

    @if(!empty($setting->description))
        <small style="color:var(--text-muted); font-size:.78rem;">
            {{ \Illuminate\Support\Str::limit($setting->description, 70) }}
        </small>
    @endif
</div>