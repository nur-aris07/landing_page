@php
    $value = $setting->value;

    if ($setting->type === 'boolean') {
        $display = in_array((string) $value, ['1', 'true', 'yes', 'on']) ? 'True' : 'False';
    } elseif ($setting->type === 'json') {
        $display = \Illuminate\Support\Str::limit((string) $value, 80);
    } elseif ($setting->type === 'textarea') {
        $display = \Illuminate\Support\Str::limit(strip_tags((string) $value), 80);
    } else {
        $display = \Illuminate\Support\Str::limit((string) $value, 80);
    }
@endphp

@if($setting->type === 'image' && !empty($setting->value))
    <div style="display:flex; align-items:center; gap:10px;">
        <img
            src="{{ asset($setting->value) }}"
            alt="{{ $setting->label }}"
            style="width:40px; height:40px; object-fit:cover; border-radius:10px; border:1px solid #e5e7eb;"
            onerror="this.style.display='none';"
        >
        <span style="color:var(--text-muted); font-size:.85rem;">
            {{ \Illuminate\Support\Str::limit($setting->value, 50) }}
        </span>
    </div>
@else
    <span style="color:var(--text-muted); font-size:.86rem;">
        {{ $display !== '' ? $display : '-' }}
    </span>
@endif