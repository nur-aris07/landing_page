<header id="topbar">
    <div class="topbar-left">
        <button class="topbar-hamburger" id="hamburgerBtn" aria-expanded="false" aria-label="Buka menu">
            <i class="ti ti-menu-2"></i>
        </button>
        <span class="topbar-breadcrumb">@yield('title', 'Dashboard')</span>
    </div>
    <div class="topbar-right">
        <div class="topbar-avatar-wrap">
            <button class="topbar-avatar" id="avatarBtn" aria-expanded="false" aria-label="Menu akun">AD</button>
            <div class="avatar-dropdown" id="avatarDropdown">
                <a href="/logout" class="avatar-dropdown-item"><i class="ti ti-logout"></i> Keluar</a href="/logout">
            </div>
        </div>
    </div>
</header>