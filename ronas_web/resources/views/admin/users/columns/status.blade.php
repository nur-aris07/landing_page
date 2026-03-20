@php
    $isActive = (int) ($user->is_active ?? 0) === 1;
@endphp

<span class="badge {{ $isActive ? 'badge-status-active' : 'badge-status-inactive' }}">
    {{ $isActive ? 'Aktif' : 'Nonaktif' }}
</span>