@php
    $role = strtolower($user->role ?? 'user');

    $class = match ($role) {
        'super admin' => 'badge-role-super',
        'admin' => 'badge-role-admin',
        default => 'badge-role-user',
    };
@endphp

<span class="badge {{ $class }}">
    {{ $user->role ?? 'User' }}
</span>