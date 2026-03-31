<aside id="sidebar" role="navigation" aria-label="Navigasi utama">
    <div class="sidebar-header">
        <span class="sidebar-logo">PUTRA RONAS</span>
        <button class="sidebar-toggle sidebar-toggle-desktop" id="sidebarToggle" aria-expanded="true" aria-label="Toggle sidebar">
            <i class="ti ti-layout-sidebar-left-collapse"></i>
        </button>
        <button class="sidebar-toggle sidebar-toggle-mobile" id="sidebarClose" aria-label="Tutup sidebar">
            <i class="ti ti-x"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <!-- GROUP: (no label) -->
        <a href="/dashboard" class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}" data-page="dashboard">
            <i class="ti ti-home nav-icon"></i>
            <span class="nav-label">Dashboard</span>
            <span class="tooltip">Dashboard</span>
        </a>

        <!-- GROUP: PRODUK -->
        <div class="nav-group-label">PRODUK</div>
        <a href="/services" class="nav-item {{ request()->is('services*') ? 'active' : '' }}" data-page="semua-produk">
            <i class="ti ti-box nav-icon"></i>
            <span class="nav-label">Master Produk</span>
            <span class="tooltip">Master Produk</span>
        </a>
        <a href="/catalogs" class="nav-item {{ request()->is('catalogs*') ? 'active' : '' }}" data-page="katalog">
            <i class="ti ti-layout-grid nav-icon"></i>
            <span class="nav-label">Katalog</span>
            <span class="tooltip">Katalog</span>
        </a>

        <!-- GROUP: KONTEN -->
        <div class="nav-group-label">KONTEN</div>
        <a href="/testimoni" class="nav-item {{ request()->is('testimoni*') ? 'active' : '' }}" data-page="testimoni">
            <i class="ti ti-message-circle-2 nav-icon"></i>
            <span class="nav-label">Testimoni</span>
            <span class="tooltip">Testimoni</span>
        </a>

        <!-- GROUP: PENGATURAN -->
        <div class="nav-group-label">SISTEM</div>
        <a href="/users" class="nav-item {{ request()->is('users*') ? 'active' : '' }}" data-page="admin-users">
            <i class="ti ti-user-cog nav-icon"></i>
            <span class="nav-label">Users</span>
            <span class="tooltip">Users</span>
        </a>
        <a href="/settings" class="nav-item {{ request()->is('settings*') ? 'active' : '' }}" data-page="settings">
            <i class="ti ti-settings nav-icon"></i>
            <span class="nav-label">Settings</span>
            <span class="tooltip">Settings</span>
        </a>
        <a href="#" class="nav-item" data-page="statistik">
            <i class="ti ti-chart-bar nav-icon"></i>
            <span class="nav-label">Statistik</span>
            <span class="tooltip">Statistik</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-footer-avatar">AD</div>
        <div class="sidebar-footer-info">
            <div class="sidebar-footer-name">Admin</div>
            <div class="sidebar-footer-role">Super Admin</div>
        </div>
        <a href="/logout" class="sidebar-footer-logout" aria-label="Keluar">
            <i class="ti ti-logout"></i>
        </a>
    </div>
</aside>