<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Admin Panel – Dashboard pengelolaan produk dan layanan [COMPANY]." />
  <title>Admin Dashboard – [COMPANY]</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

  <style>
    /* ===== CSS VARIABLES ===== */
    :root {
      --primary: #0A0A0A;
      --accent: #E8B84B;
      --accent-dark: #c99a2e;
      --surface: #F5F5F0;
      --text-dark: #1A1A1A;
      --text-muted: #6B6B6B;
      --white: #FFFFFF;
      --card-bg: #FFFFFF;
      --border: #E0E0DC;
      --sidebar-bg: #0A0A0A;
      --sidebar-text: rgba(245,245,240,0.85);
      --sidebar-muted: rgba(245,245,240,0.35);
      --sidebar-active-bg: rgba(232,184,75,0.12);
      --sidebar-width: 260px;
      --sidebar-collapsed: 72px;
      --topbar-h: 64px;
      --radius: 12px;
      --radius-lg: 20px;
      --shadow-sm: 0 2px 8px rgba(0,0,0,.06);
      --shadow-md: 0 8px 30px rgba(0,0,0,.10);
      --transition: 0.3s cubic-bezier(.4,0,.2,1);
      --cat-otomotif: #3B82F6;
      --cat-alat-berat: #F59E0B;
      --cat-properti: #10B981;
      --cat-travel: #8B5CF6;
    }

    /* ===== RESET & BASE ===== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { height: 100%; }
    body {
      height: 100%;
      overflow: hidden;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: var(--text-dark);
      background: var(--surface);
      -webkit-font-smoothing: antialiased;
    }

    /* Scrollbar */
    #main::-webkit-scrollbar,
    #sidebar::-webkit-scrollbar { width: 6px; }
    #main::-webkit-scrollbar-track,
    #sidebar::-webkit-scrollbar-track { background: transparent; }
    #main::-webkit-scrollbar-thumb,
    #sidebar::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 50px; }
    #main { scrollbar-width: thin; scrollbar-color: var(--accent) transparent; }
    #sidebar { scrollbar-width: thin; scrollbar-color: var(--accent) transparent; }

    /* ===== APP GRID ===== */
    #app {
      display: grid;
      grid-template-columns: var(--sidebar-width) 1fr;
      grid-template-rows: var(--topbar-h) 1fr;
      height: 100vh;
      transition: grid-template-columns var(--transition);
    }
    #app.collapsed { grid-template-columns: var(--sidebar-collapsed) 1fr; }

    /* ===== SIDEBAR ===== */
    #sidebar {
      grid-row: 1 / -1;
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      transition: width var(--transition);
      overflow: hidden;
      z-index: 200;
      position: relative;
      background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' xmlns='http://www.w3.org/2000/svg'%3E%3Cline x1='0' y1='20' x2='20' y2='0' stroke='rgba(255,255,255,0.03)' stroke-width='1'/%3E%3C/svg%3E");
    }
    #app:not(.collapsed) #sidebar { overflow-y: auto; }
    .collapsed #sidebar { overflow: hidden; }

    /* Sidebar Header */
    .sidebar-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 16px;
      height: var(--topbar-h);
      min-height: var(--topbar-h);
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .sidebar-logo {
      font-family: 'Bebas Neue', cursive;
      font-size: 22px;
      color: var(--accent);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      transition: opacity 0.2s;
      letter-spacing: 1px;
    }
    .collapsed .sidebar-logo { opacity: 0; width: 0; }
    .sidebar-toggle {
      background: none; border: none; color: var(--sidebar-text);
      cursor: pointer; font-size: 20px; padding: 6px; border-radius: 6px;
      transition: background var(--transition);
      flex-shrink: 0;
    }
    .sidebar-toggle:hover { background: rgba(255,255,255,0.08); }
    .sidebar-toggle:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

    /* Sidebar Nav */
    .sidebar-nav { flex: 1; padding: 12px 10px; display: flex; flex-direction: column; gap: 4px; }

    /* Group Label */
    .nav-group-label {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--sidebar-muted);
      padding: 16px 16px 6px;
      transition: opacity 0.2s;
    }
    .collapsed .nav-group-label { opacity: 0; height: 0; padding: 0; overflow: hidden; }

    /* Menu Item */
    .nav-item {
      position: relative;
      display: flex;
      align-items: center;
      gap: 12px;
      height: 44px;
      padding: 0 16px;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      transition: background var(--transition);
      color: var(--sidebar-text);
      font-size: 14px;
      font-weight: 500;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
    }
    .nav-item:hover { background: rgba(255,255,255,0.05); }
    .nav-item:hover .nav-icon,
    .nav-item:hover .nav-label { color: rgba(245,245,240,1); }
    .nav-item:focus-visible { outline: 2px solid var(--accent); outline-offset: -2px; }

    .nav-icon { font-size: 20px; color: var(--sidebar-muted); flex-shrink: 0; transition: color var(--transition); width: 20px; text-align: center; }
    .nav-label {
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
      transition: opacity 0.2s, width 0.2s;
      flex: 1;
    }
    .collapsed .nav-label { opacity: 0; width: 0; overflow: hidden; }

    /* Active State */
    .nav-item.active {
      background: var(--sidebar-active-bg);
      border-left: 3px solid var(--accent);
    }
    .nav-item.active .nav-icon,
    .nav-item.active .nav-label { color: var(--accent); }

    /* Dropdown Arrow */
    .nav-arrow {
      font-size: 14px; color: var(--sidebar-muted);
      transition: transform var(--transition), opacity 0.2s;
      flex-shrink: 0;
    }
    .nav-item.open .nav-arrow { transform: rotate(90deg); }
    .collapsed .nav-arrow { opacity: 0; width: 0; }

    /* Subnav */
    .subnav {
      max-height: 0; overflow: hidden;
      transition: max-height 0.35s ease;
    }
    .subnav.open { max-height: 300px; }
    .collapsed .subnav { max-height: 0 !important; }

    .subnav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 0 16px 0 44px; height: 38px;
      font-size: 13px; color: var(--sidebar-text);
      cursor: pointer; border-radius: 8px;
      transition: background var(--transition);
      text-decoration: none;
    }
    .subnav-item:hover { background: rgba(255,255,255,0.05); }
    .subnav-item:focus-visible { outline: 2px solid var(--accent); outline-offset: -2px; }
    .cat-dot {
      width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    }

    /* Tooltips (collapsed) */
    .collapsed .nav-item .tooltip,
    .collapsed .subnav-item .tooltip { display: none; }
    .tooltip {
      display: none;
      position: absolute;
      left: calc(var(--sidebar-collapsed) + 8px);
      top: 50%; transform: translateY(-50%);
      background: #1a1a1a; color: #fff;
      border-radius: 6px; padding: 4px 10px;
      font-size: 12px; white-space: nowrap;
      pointer-events: none; opacity: 0;
      transition: opacity 0.15s;
      z-index: 1000;
    }
    .collapsed .nav-item { position: relative; }
    .collapsed .nav-item .tooltip { display: block; }
    .collapsed .nav-item:hover .tooltip { opacity: 1; }

    /* Sidebar Footer */
    .sidebar-footer {
      display: flex; align-items: center; gap: 12px;
      padding: 14px 16px; border-top: 1px solid rgba(255,255,255,0.06);
      min-height: 64px;
    }
    .sidebar-footer-avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: var(--accent); color: var(--primary);
      display: flex; align-items: center; justify-content: center;
      font-weight: 600; font-size: 14px; flex-shrink: 0;
    }
    .sidebar-footer-info { flex: 1; overflow: hidden; transition: opacity 0.2s; }
    .collapsed .sidebar-footer-info { opacity: 0; width: 0; overflow: hidden; }
    .sidebar-footer-name { font-size: 14px; font-weight: 600; color: var(--sidebar-text); white-space: nowrap; }
    .sidebar-footer-role { font-size: 12px; color: var(--sidebar-muted); white-space: nowrap; }
    .sidebar-footer-logout {
      background: none; border: none; color: var(--sidebar-muted);
      font-size: 20px; cursor: pointer; padding: 6px; border-radius: 6px;
      transition: background var(--transition), color var(--transition);
      flex-shrink: 0;
    }
    .sidebar-footer-logout:hover { background: rgba(255,255,255,0.08); color: var(--sidebar-text); }
    .sidebar-footer-logout:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
    .collapsed .sidebar-footer { justify-content: center; }
    .collapsed .sidebar-footer-logout { display: none; }
    /* Show logout centered when collapsed */
    .collapsed .sidebar-footer { flex-direction: column; gap: 8px; }

    /* ===== MOBILE OVERLAY ===== */
    .sidebar-overlay {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.5); z-index: 199;
      opacity: 0; pointer-events: none;
      transition: opacity var(--transition);
    }

    /* ===== TOPBAR ===== */
    #topbar {
      grid-column: 2;
      position: sticky; top: 0; z-index: 100;
      background: var(--white);
      border-bottom: 1px solid var(--border);
      height: var(--topbar-h);
      padding: 0 24px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .topbar-left { display: flex; align-items: center; gap: 12px; }
    .topbar-hamburger {
      display: none;
      background: none; border: none; font-size: 22px;
      color: var(--text-dark); cursor: pointer; padding: 6px; border-radius: 6px;
    }
    .topbar-hamburger:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
    .topbar-breadcrumb { font-weight: 600; font-size: 16px; color: var(--text-dark); }

    .topbar-right { display: flex; align-items: center; gap: 16px; }

    /* Search */
    .topbar-search {
      position: relative; display: flex; align-items: center;
    }
    .topbar-search-input {
      border: 1px solid var(--border); border-radius: 8px;
      height: 38px; padding: 0 14px 0 36px; width: 220px;
      font-family: 'DM Sans', sans-serif; font-size: 13px;
      background: var(--surface); color: var(--text-dark);
      transition: border-color var(--transition), width var(--transition);
      outline: none;
    }
    .topbar-search-input::placeholder { color: var(--text-muted); }
    .topbar-search-input:focus { border-color: var(--accent); }
    .topbar-search-icon {
      position: absolute; left: 10px; font-size: 16px; color: var(--text-muted);
      pointer-events: none;
    }
    .topbar-search-btn {
      display: none;
      background: none; border: 1px solid var(--border); border-radius: 8px;
      width: 38px; height: 38px; font-size: 18px; color: var(--text-muted);
      cursor: pointer; align-items: center; justify-content: center;
    }
    .topbar-search-btn:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

    /* Notification */
    .topbar-notif {
      position: relative;
      background: none; border: none; font-size: 20px;
      color: var(--text-dark); cursor: pointer; padding: 6px; border-radius: 8px;
      transition: background var(--transition);
    }
    .topbar-notif:hover { background: var(--surface); }
    .topbar-notif:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
    .topbar-notif-badge {
      position: absolute; top: 2px; right: 2px;
      background: var(--accent); color: var(--primary);
      font-size: 10px; font-weight: 700;
      width: 18px; height: 18px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      line-height: 1;
    }

    /* Avatar */
    .topbar-avatar-wrap { position: relative; }
    .topbar-avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: var(--accent); color: var(--primary);
      display: flex; align-items: center; justify-content: center;
      font-weight: 600; font-size: 14px;
      cursor: pointer; border: none;
      transition: box-shadow var(--transition);
    }
    .topbar-avatar:hover { box-shadow: 0 0 0 3px rgba(232,184,75,0.3); }
    .topbar-avatar:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

    /* Avatar Dropdown */
    .avatar-dropdown {
      position: absolute; top: calc(100% + 8px); right: 0;
      background: var(--white); border-radius: var(--radius);
      box-shadow: var(--shadow-md); min-width: 160px;
      padding: 6px; opacity: 0; visibility: hidden;
      transform: translateY(-8px);
      transition: opacity 0.2s, visibility 0.2s, transform 0.2s;
      z-index: 200;
    }
    .avatar-dropdown.open { opacity: 1; visibility: visible; transform: translateY(0); }
    .avatar-dropdown-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 14px; border-radius: 8px;
      font-size: 14px; color: var(--text-dark);
      cursor: pointer; text-decoration: none;
      transition: background var(--transition);
      border: none; background: none; width: 100%; text-align: left;
      font-family: 'DM Sans', sans-serif;
    }
    .avatar-dropdown-item:hover { background: var(--surface); }
    .avatar-dropdown-item:focus-visible { outline: 2px solid var(--accent); outline-offset: -2px; }
    .avatar-dropdown-item i { font-size: 18px; color: var(--text-muted); }

    /* ===== MAIN CONTENT ===== */
    #main {
      grid-column: 2;
      overflow-y: auto;
      background: var(--surface);
      padding: 28px;
      display: flex; flex-direction: column; gap: 28px;
    }

    /* Page Header */
    .page-header {
      display: flex; align-items: flex-start; justify-content: space-between;
      flex-wrap: wrap; gap: 8px;
    }
    .page-title { font-family: 'Bebas Neue', cursive; font-size: 36px; color: var(--text-dark); line-height: 1; letter-spacing: 1px; }
    .page-subtitle { font-size: 15px; color: var(--text-muted); margin-top: 4px; }
    .page-date { font-size: 14px; color: var(--text-muted); white-space: nowrap; padding-top: 6px; }

    /* ===== STATS CARDS ===== */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }
    .stat-card {
      background: var(--card-bg); border-radius: var(--radius);
      padding: 22px; box-shadow: var(--shadow-sm);
      position: relative; overflow: hidden;
    }
    .stat-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .stat-card-label { font-size: 14px; color: var(--text-muted); font-weight: 500; }
    .stat-card-icon {
      width: 40px; height: 40px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px; flex-shrink: 0;
    }
    .stat-card-value {
      font-family: 'Bebas Neue', cursive;
      font-size: 32px; color: var(--text-dark);
      line-height: 1; letter-spacing: 0.5px;
    }
    .stat-card-trend {
      display: flex; align-items: center; gap: 4px;
      font-size: 13px; margin-top: 8px;
    }
    .stat-card-trend i { font-size: 16px; }
    .trend-green { color: #16a34a; }
    .trend-muted { color: var(--text-muted); font-size: 12px; }

    /* ===== CHARTS ROW ===== */
    .charts-row {
      display: grid;
      grid-template-columns: 60fr 40fr;
      gap: 20px;
    }

    .card {
      background: var(--card-bg); border-radius: var(--radius);
      padding: 24px; box-shadow: var(--shadow-sm);
    }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .card-title { font-family: 'Bebas Neue', cursive; font-size: 22px; color: var(--text-dark); letter-spacing: 0.5px; }
    .card-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

    /* Bar Chart */
    .bar-chart { display: flex; flex-direction: column; gap: 16px; }
    .bar-row { display: flex; align-items: center; gap: 12px; }
    .bar-label { width: 100px; font-size: 14px; font-weight: 500; color: var(--text-dark); flex-shrink: 0; }
    .bar-track { flex: 1; background: var(--border); height: 10px; border-radius: 50px; overflow: hidden; }
    .bar-fill { height: 100%; border-radius: 50px; width: 0; transition: width 1.2s ease; }
    .bar-pct { width: 48px; font-size: 13px; font-weight: 600; color: var(--text-muted); text-align: right; flex-shrink: 0; }

    /* Donut Chart */
    .donut-wrap { display: flex; flex-direction: column; align-items: center; }
    .donut-svg-wrap { position: relative; width: 200px; height: 200px; }
    .donut-svg-wrap svg { width: 200px; height: 200px; transform: rotate(-90deg); }
    .donut-center {
      position: absolute; inset: 0;
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      transform: rotate(0deg);
    }
    .donut-center-num { font-family: 'Bebas Neue', cursive; font-size: 36px; color: var(--text-dark); line-height: 1; }
    .donut-center-label { font-size: 13px; color: var(--text-muted); }

    .donut-legend {
      display: flex; flex-wrap: wrap; gap: 14px 24px;
      margin-top: 20px; justify-content: center;
    }
    .donut-legend-item { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--text-dark); }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .legend-count { font-weight: 600; color: var(--text-muted); margin-left: 2px; }

    /* ===== BOTTOM ROW ===== */
    .bottom-row {
      display: grid;
      grid-template-columns: 55fr 45fr;
      gap: 20px;
    }

    /* Table */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
      font-size: 12px; text-transform: uppercase; color: var(--text-muted);
      font-weight: 600; letter-spacing: 0.5px;
      padding: 10px 16px; text-align: left;
      border-bottom: 2px solid var(--border);
    }
    tbody td { padding: 12px 16px; font-size: 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
    tbody tr:hover { background: rgba(0,0,0,0.02); }
    .td-product { font-weight: 500; color: var(--text-dark); }

    .badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 10px; border-radius: 50px;
      font-size: 12px; font-weight: 600;
    }
    .badge-otomotif { background: rgba(59,130,246,0.1); color: var(--cat-otomotif); }
    .badge-alat-berat { background: rgba(245,158,11,0.1); color: var(--cat-alat-berat); }
    .badge-properti { background: rgba(16,185,129,0.1); color: var(--cat-properti); }
    .badge-travel { background: rgba(139,92,246,0.1); color: var(--cat-travel); }
    .badge-aktif { background: rgba(22,163,74,0.1); color: #16a34a; }
    .badge-draft { background: rgba(245,158,11,0.1); color: #d97706; }

    .card-header-link {
      font-size: 14px; font-weight: 600; color: var(--accent);
      text-decoration: none; white-space: nowrap;
      transition: color var(--transition);
    }
    .card-header-link:hover { color: var(--accent-dark); }
    .card-header-link:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

    /* Quick Actions */
    .quick-actions { display: flex; flex-direction: column; gap: 10px; }
    .qa-btn {
      display: flex; align-items: center; gap: 10px;
      height: 46px; padding: 0 18px;
      border-radius: 10px; border: 1px solid var(--border);
      font-size: 14px; font-weight: 500;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer; transition: all var(--transition);
      background: var(--white); color: var(--text-dark);
      text-decoration: none;
    }
    .qa-btn i { font-size: 18px; }
    .qa-btn:hover { border-color: var(--accent); color: var(--accent); }
    .qa-btn:focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
    .qa-btn.primary {
      background: var(--accent); color: var(--primary);
      border-color: var(--accent); font-weight: 600;
    }
    .qa-btn.primary:hover { background: var(--accent-dark); border-color: var(--accent-dark); }

    .tips-box {
      background: rgba(232,184,75,0.08);
      border: 1px solid rgba(232,184,75,0.2);
      border-radius: 10px; padding: 14px;
      font-size: 13px; color: var(--text-dark);
      display: flex; align-items: flex-start; gap: 10px;
      margin-top: 6px;
    }
    .tips-box i { color: var(--accent); font-size: 20px; flex-shrink: 0; margin-top: 1px; }

    /* ===== ANIMATIONS ===== */
    .fade-in-up {
      opacity: 0; transform: translateY(20px);
      transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .fade-in-up.visible { opacity: 1; transform: translateY(0); }

    /* ===== RESPONSIVE ===== */

    /* Tablet: 768–1023 */
    @media (max-width: 1023px) {
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .charts-row { grid-template-columns: 1fr 1fr; }
      .bottom-row { grid-template-columns: 1fr; }
    }

    /* Mobile: <768 */
    @media (max-width: 767px) {
      #app { grid-template-columns: 1fr; }
      #app.collapsed { grid-template-columns: 1fr; }

      #sidebar {
        position: fixed; top: 0; left: 0;
        width: var(--sidebar-width); height: 100%;
        transform: translateX(-100%);
        transition: transform var(--transition);
        z-index: 200;
        overflow-y: auto;
      }
      #app.sidebar-open #sidebar { transform: translateX(0); }

      .sidebar-overlay { display: block; }
      #app.sidebar-open .sidebar-overlay { opacity: 1; pointer-events: auto; }

      #topbar { grid-column: 1; }
      #main { grid-column: 1; padding: 16px; }

      .topbar-hamburger { display: flex; align-items: center; justify-content: center; }

      .topbar-search-input { display: none; }
      .topbar-search-icon { display: none; }
      .topbar-search-btn { display: flex; }

      .stats-grid { grid-template-columns: 1fr; }
      .charts-row { grid-template-columns: 1fr; }
      .bottom-row { grid-template-columns: 1fr; }

      .page-header { flex-direction: column; }
      .page-title { font-size: 28px; }

      /* Hide desktop toggle, show close */
      .sidebar-toggle-desktop { display: none; }
      .sidebar-toggle-mobile { display: block !important; }
    }

    @media (min-width: 768px) {
      .sidebar-toggle-mobile { display: none !important; }
    }

    /* Tablet auto-collapse */
    @media (min-width: 768px) and (max-width: 1023px) {
      /* auto-collapsed handled via JS */
    }
  </style>
</head>

<body>
  <div id="app">

    <!-- SIDEBAR -->
    <aside id="sidebar" role="navigation" aria-label="Navigasi utama">
      <div class="sidebar-header">
        <span class="sidebar-logo">[COMPANY]</span>
        <button class="sidebar-toggle sidebar-toggle-desktop" id="sidebarToggle" aria-expanded="true" aria-label="Toggle sidebar">
          <i class="ti ti-layout-sidebar-left-collapse"></i>
        </button>
        <button class="sidebar-toggle sidebar-toggle-mobile" id="sidebarClose" aria-label="Tutup sidebar">
          <i class="ti ti-x"></i>
        </button>
      </div>

      <nav class="sidebar-nav">
        <!-- GROUP: (no label) -->
        <a href="#" class="nav-item active" data-page="dashboard">
          <i class="ti ti-home nav-icon"></i>
          <span class="nav-label">Dashboard</span>
          <span class="tooltip">Dashboard</span>
        </a>

        <!-- GROUP: PRODUK -->
        <div class="nav-group-label">PRODUK</div>
        <a href="#" class="nav-item" data-page="semua-produk">
          <i class="ti ti-box nav-icon"></i>
          <span class="nav-label">Semua Produk</span>
          <span class="tooltip">Semua Produk</span>
        </a>
        <a href="#" class="nav-item" data-page="tambah-produk">
          <i class="ti ti-circle-plus nav-icon"></i>
          <span class="nav-label">Tambah Produk</span>
          <span class="tooltip">Tambah Produk</span>
        </a>
        <button class="nav-item" id="katalogToggle" aria-expanded="false">
          <i class="ti ti-layout-grid nav-icon"></i>
          <span class="nav-label">Katalog</span>
          <i class="ti ti-chevron-right nav-arrow"></i>
          <span class="tooltip">Katalog</span>
        </button>
        <div class="subnav" id="katalogSubnav">
          <a href="#" class="subnav-item"><span class="cat-dot" style="background:var(--cat-otomotif)"></span> Otomotif</a>
          <a href="#" class="subnav-item"><span class="cat-dot" style="background:var(--cat-alat-berat)"></span> Alat Berat</a>
          <a href="#" class="subnav-item"><span class="cat-dot" style="background:var(--cat-properti)"></span> Properti</a>
          <a href="#" class="subnav-item"><span class="cat-dot" style="background:var(--cat-travel)"></span> Travel</a>
        </div>

        <!-- GROUP: KONTEN -->
        <div class="nav-group-label">KONTEN</div>
        <a href="#" class="nav-item" data-page="banner">
          <i class="ti ti-photo nav-icon"></i>
          <span class="nav-label">Banner / Hero</span>
          <span class="tooltip">Banner / Hero</span>
        </a>
        <a href="#" class="nav-item" data-page="testimoni">
          <i class="ti ti-message-circle-2 nav-icon"></i>
          <span class="nav-label">Testimoni</span>
          <span class="tooltip">Testimoni</span>
        </a>
        <a href="#" class="nav-item" data-page="halaman">
          <i class="ti ti-file-text nav-icon"></i>
          <span class="nav-label">Halaman</span>
          <span class="tooltip">Halaman</span>
        </a>

        <!-- GROUP: LAPORAN -->
        <div class="nav-group-label">LAPORAN</div>
        <a href="#" class="nav-item" data-page="statistik">
          <i class="ti ti-chart-bar nav-icon"></i>
          <span class="nav-label">Statistik</span>
          <span class="tooltip">Statistik</span>
        </a>
        <a href="#" class="nav-item" data-page="leads">
          <i class="ti ti-users nav-icon"></i>
          <span class="nav-label">Leads Masuk</span>
          <span class="tooltip">Leads Masuk</span>
        </a>
        <a href="#" class="nav-item" data-page="whatsapp">
          <i class="ti ti-brand-whatsapp nav-icon"></i>
          <span class="nav-label">Klik WhatsApp</span>
          <span class="tooltip">Klik WhatsApp</span>
        </a>

        <!-- GROUP: PENGATURAN -->
        <div class="nav-group-label">PENGATURAN</div>
        <a href="#" class="nav-item" data-page="profil">
          <i class="ti ti-building-store nav-icon"></i>
          <span class="nav-label">Profil Perusahaan</span>
          <span class="tooltip">Profil Perusahaan</span>
        </a>
        <a href="#" class="nav-item" data-page="admin-users">
          <i class="ti ti-user-cog nav-icon"></i>
          <span class="nav-label">Admin &amp; Pengguna</span>
          <span class="tooltip">Admin & Pengguna</span>
        </a>
        <a href="#" class="nav-item" data-page="integrasi">
          <i class="ti ti-plug nav-icon"></i>
          <span class="nav-label">Integrasi</span>
          <span class="tooltip">Integrasi</span>
        </a>
      </nav>

      <div class="sidebar-footer">
        <div class="sidebar-footer-avatar">AD</div>
        <div class="sidebar-footer-info">
          <div class="sidebar-footer-name">Admin</div>
          <div class="sidebar-footer-role">Super Admin</div>
        </div>
        <button class="sidebar-footer-logout" aria-label="Keluar">
          <i class="ti ti-logout"></i>
        </button>
      </div>
    </aside>

    <!-- MOBILE OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- TOPBAR -->
    <header id="topbar">
      <div class="topbar-left">
        <button class="topbar-hamburger" id="hamburgerBtn" aria-expanded="false" aria-label="Buka menu">
          <i class="ti ti-menu-2"></i>
        </button>
        <span class="topbar-breadcrumb">Dashboard</span>
      </div>
      <div class="topbar-right">
        <div class="topbar-search">
          <i class="ti ti-search topbar-search-icon"></i>
          <input type="text" class="topbar-search-input" placeholder="Cari produk, menu..." id="searchInput" />
          <button class="topbar-search-btn" id="mobileSearchBtn" aria-label="Cari"><i class="ti ti-search"></i></button>
        </div>
        <button class="topbar-notif" aria-label="Notifikasi">
          <i class="ti ti-bell"></i>
          <span class="topbar-notif-badge">3</span>
        </button>
        <div class="topbar-avatar-wrap">
          <button class="topbar-avatar" id="avatarBtn" aria-expanded="false" aria-label="Menu akun">AD</button>
          <div class="avatar-dropdown" id="avatarDropdown">
            <button class="avatar-dropdown-item"><i class="ti ti-user"></i> Profil Saya</button>
            <button class="avatar-dropdown-item"><i class="ti ti-settings"></i> Pengaturan</button>
            <button class="avatar-dropdown-item"><i class="ti ti-logout"></i> Keluar</button>
          </div>
        </div>
      </div>
    </header>

    <!-- MAIN CONTENT -->
    <main id="main" role="main">

      <!-- 1. Page Header -->
      <div class="page-header fade-in-up">
        <div>
          <h1 class="page-title">Dashboard</h1>
          <p class="page-subtitle">Selamat datang kembali, Admin 👋</p>
        </div>
        <div class="page-date" id="currentDate"></div>
      </div>

      <!-- 2. Stats Cards -->
      <div class="stats-grid" id="statsGrid">
        <div class="stat-card fade-in-up">
          <div class="stat-card-top">
            <span class="stat-card-label">Total Produk</span>
            <div class="stat-card-icon" style="background:rgba(59,130,246,0.08);color:var(--cat-otomotif)"><i class="ti ti-box"></i></div>
          </div>
          <div class="stat-card-value" data-count="128">0</div>
          <div class="stat-card-trend trend-green"><i class="ti ti-trending-up"></i> +12 produk bulan ini</div>
        </div>
        <div class="stat-card fade-in-up">
          <div class="stat-card-top">
            <span class="stat-card-label">Kategori Aktif</span>
            <div class="stat-card-icon" style="background:rgba(232,184,75,0.08);color:var(--accent)"><i class="ti ti-layout-grid"></i></div>
          </div>
          <div class="stat-card-value" data-count="4">0</div>
          <div class="stat-card-trend trend-muted">Otomotif · Alat Berat · Properti · Travel</div>
        </div>
        <div class="stat-card fade-in-up">
          <div class="stat-card-top">
            <span class="stat-card-label">Leads Masuk</span>
            <div class="stat-card-icon" style="background:rgba(16,185,129,0.08);color:var(--cat-properti)"><i class="ti ti-users"></i></div>
          </div>
          <div class="stat-card-value" data-count="47">0</div>
          <div class="stat-card-trend trend-green"><i class="ti ti-trending-up"></i> +8 leads minggu ini</div>
        </div>
        <div class="stat-card fade-in-up">
          <div class="stat-card-top">
            <span class="stat-card-label">Klik WhatsApp</span>
            <div class="stat-card-icon" style="background:rgba(37,211,102,0.08);color:#25D366"><i class="ti ti-brand-whatsapp"></i></div>
          </div>
          <div class="stat-card-value" data-count="312">0</div>
          <div class="stat-card-trend trend-green"><i class="ti ti-trending-up"></i> +23 klik hari ini</div>
        </div>
      </div>

      <!-- 3. Charts Row -->
      <div class="charts-row">
        <!-- Left: Bar Chart -->
        <div class="card fade-in-up">
          <div class="card-header">
            <div>
              <div class="card-title">Trafik Klik per Kategori</div>
              <div class="card-subtitle">30 hari terakhir</div>
            </div>
          </div>
          <div class="bar-chart" id="barChart">
            <div class="bar-row">
              <span class="bar-label">Otomotif</span>
              <div class="bar-track"><div class="bar-fill" data-width="78" style="background:var(--cat-otomotif)"></div></div>
              <span class="bar-pct">78%</span>
            </div>
            <div class="bar-row">
              <span class="bar-label">Alat Berat</span>
              <div class="bar-track"><div class="bar-fill" data-width="55" style="background:var(--cat-alat-berat)"></div></div>
              <span class="bar-pct">55%</span>
            </div>
            <div class="bar-row">
              <span class="bar-label">Properti</span>
              <div class="bar-track"><div class="bar-fill" data-width="42" style="background:var(--cat-properti)"></div></div>
              <span class="bar-pct">42%</span>
            </div>
            <div class="bar-row">
              <span class="bar-label">Travel</span>
              <div class="bar-track"><div class="bar-fill" data-width="31" style="background:var(--cat-travel)"></div></div>
              <span class="bar-pct">31%</span>
            </div>
          </div>
        </div>

        <!-- Right: Donut Chart -->
        <div class="card fade-in-up">
          <div class="card-header">
            <div>
              <div class="card-title">Distribusi Produk</div>
              <div class="card-subtitle">Total 128 produk</div>
            </div>
          </div>
          <div class="donut-wrap" id="donutChart">
            <div class="donut-svg-wrap">
              <svg viewBox="0 0 200 200">
                <!-- Otomotif 35% -->
                <circle cx="100" cy="100" r="70" fill="none" stroke="var(--cat-otomotif)" stroke-width="28"
                  stroke-dasharray="439.82" stroke-dashoffset="439.82" stroke-linecap="round"
                  class="donut-segment" data-percent="35" data-order="0" />
                <!-- Alat Berat 25% -->
                <circle cx="100" cy="100" r="70" fill="none" stroke="var(--cat-alat-berat)" stroke-width="28"
                  stroke-dasharray="439.82" stroke-dashoffset="439.82" stroke-linecap="round"
                  class="donut-segment" data-percent="25" data-order="1" />
                <!-- Properti 22% -->
                <circle cx="100" cy="100" r="70" fill="none" stroke="var(--cat-properti)" stroke-width="28"
                  stroke-dasharray="439.82" stroke-dashoffset="439.82" stroke-linecap="round"
                  class="donut-segment" data-percent="22" data-order="2" />
                <!-- Travel 18% -->
                <circle cx="100" cy="100" r="70" fill="none" stroke="var(--cat-travel)" stroke-width="28"
                  stroke-dasharray="439.82" stroke-dashoffset="439.82" stroke-linecap="round"
                  class="donut-segment" data-percent="18" data-order="3" />
              </svg>
              <div class="donut-center">
                <span class="donut-center-num">128</span>
                <span class="donut-center-label">Produk</span>
              </div>
            </div>
            <div class="donut-legend">
              <div class="donut-legend-item"><span class="legend-dot" style="background:var(--cat-otomotif)"></span> Otomotif <span class="legend-count">45</span></div>
              <div class="donut-legend-item"><span class="legend-dot" style="background:var(--cat-alat-berat)"></span> Alat Berat <span class="legend-count">32</span></div>
              <div class="donut-legend-item"><span class="legend-dot" style="background:var(--cat-properti)"></span> Properti <span class="legend-count">28</span></div>
              <div class="donut-legend-item"><span class="legend-dot" style="background:var(--cat-travel)"></span> Travel <span class="legend-count">23</span></div>
            </div>
          </div>
        </div>
      </div>

      <!-- 4. Bottom Row -->
      <div class="bottom-row">
        <!-- Left: Product Table -->
        <div class="card fade-in-up">
          <div class="card-header">
            <div>
              <div class="card-title">Produk Terbaru</div>
            </div>
            <a href="#" class="card-header-link">Lihat Semua →</a>
          </div>
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="td-product">Toyota Fortuner 2024</td>
                  <td><span class="badge badge-otomotif">Otomotif</span></td>
                  <td><span class="badge badge-aktif">Aktif</span></td>
                  <td>12 Mar 2026</td>
                </tr>
                <tr>
                  <td class="td-product">Excavator Komatsu PC200</td>
                  <td><span class="badge badge-alat-berat">Alat Berat</span></td>
                  <td><span class="badge badge-aktif">Aktif</span></td>
                  <td>10 Mar 2026</td>
                </tr>
                <tr>
                  <td class="td-product">Rumah Cluster Type 45</td>
                  <td><span class="badge badge-properti">Properti</span></td>
                  <td><span class="badge badge-aktif">Aktif</span></td>
                  <td>8 Mar 2026</td>
                </tr>
                <tr>
                  <td class="td-product">Paket Wisata Bali 5H4M</td>
                  <td><span class="badge badge-travel">Travel</span></td>
                  <td><span class="badge badge-draft">Draft</span></td>
                  <td>7 Mar 2026</td>
                </tr>
                <tr>
                  <td class="td-product">Honda CR-V Turbo</td>
                  <td><span class="badge badge-otomotif">Otomotif</span></td>
                  <td><span class="badge badge-aktif">Aktif</span></td>
                  <td>5 Mar 2026</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Right: Quick Actions -->
        <div class="card fade-in-up">
          <div class="card-header">
            <div><div class="card-title">Aksi Cepat</div></div>
          </div>
          <div class="quick-actions">
            <button class="qa-btn primary"><i class="ti ti-circle-plus"></i> Tambah Produk Baru</button>
            <button class="qa-btn"><i class="ti ti-layout-grid"></i> Kelola Katalog</button>
            <button class="qa-btn"><i class="ti ti-users"></i> Lihat Leads</button>
            <button class="qa-btn"><i class="ti ti-chart-bar"></i> Buka Laporan</button>
          </div>
          <div class="tips-box">
            <i class="ti ti-bulb"></i>
            <span>Tambahkan produk baru secara rutin untuk meningkatkan visibilitas katalog Anda.</span>
          </div>
        </div>
      </div>

    </main>
  </div>

  <script>
    'use strict';

    /* ============================================
       1. SIDEBAR
    ============================================ */
    function initSidebar() {
      var app = document.getElementById('app');
      var sidebar = document.getElementById('sidebar');
      var toggleBtn = document.getElementById('sidebarToggle');
      var closeBtn = document.getElementById('sidebarClose');
      var hamburgerBtn = document.getElementById('hamburgerBtn');
      var overlay = document.getElementById('sidebarOverlay');
      var toggleIcon = toggleBtn.querySelector('i');

      // Desktop toggle
      toggleBtn.addEventListener('click', function() {
        app.classList.toggle('collapsed');
        var isCollapsed = app.classList.contains('collapsed');
        toggleBtn.setAttribute('aria-expanded', !isCollapsed);
        toggleIcon.className = isCollapsed
          ? 'ti ti-layout-sidebar-left-expand'
          : 'ti ti-layout-sidebar-left-collapse';
      });

      // Mobile open
      hamburgerBtn.addEventListener('click', function() {
        app.classList.add('sidebar-open');
        hamburgerBtn.setAttribute('aria-expanded', 'true');
      });

      // Mobile close
      function closeMobileSidebar() {
        app.classList.remove('sidebar-open');
        hamburgerBtn.setAttribute('aria-expanded', 'false');
      }
      closeBtn.addEventListener('click', closeMobileSidebar);
      overlay.addEventListener('click', closeMobileSidebar);

      // Katalog accordion
      var katalogToggle = document.getElementById('katalogToggle');
      var katalogSubnav = document.getElementById('katalogSubnav');

      katalogToggle.addEventListener('click', function() {
        var isOpen = katalogSubnav.classList.toggle('open');
        katalogToggle.classList.toggle('open', isOpen);
        katalogToggle.setAttribute('aria-expanded', isOpen);
      });

      // Active state
      var navItems = document.querySelectorAll('.nav-item[data-page], .subnav-item');
      navItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          document.querySelectorAll('.nav-item.active').forEach(function(a) { a.classList.remove('active'); });
          if (item.classList.contains('subnav-item')) {
            // no active for sub-items visual
          } else {
            item.classList.add('active');
          }
        });
      });

      // Auto-collapse on tablet
      if (window.innerWidth >= 768 && window.innerWidth < 1024) {
        app.classList.add('collapsed');
        toggleIcon.className = 'ti ti-layout-sidebar-left-expand';
        toggleBtn.setAttribute('aria-expanded', 'false');
      }
    }

    /* ============================================
       2. TOPBAR
    ============================================ */
    function initTopbar() {
      var avatarBtn = document.getElementById('avatarBtn');
      var dropdown = document.getElementById('avatarDropdown');

      avatarBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        var isOpen = dropdown.classList.toggle('open');
        avatarBtn.setAttribute('aria-expanded', isOpen);
      });

      document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target) && e.target !== avatarBtn) {
          dropdown.classList.remove('open');
          avatarBtn.setAttribute('aria-expanded', 'false');
        }
      });

      // Escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          dropdown.classList.remove('open');
          avatarBtn.setAttribute('aria-expanded', 'false');
          // Also close mobile sidebar
          var app = document.getElementById('app');
          app.classList.remove('sidebar-open');
          document.getElementById('hamburgerBtn').setAttribute('aria-expanded', 'false');
        }
      });

      // Mobile search toggle (optional expansion)
      var mobileSearchBtn = document.getElementById('mobileSearchBtn');
      var searchInput = document.getElementById('searchInput');
      if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', function() {
          if (window.innerWidth < 768) {
            searchInput.style.display = searchInput.style.display === 'block' ? 'none' : 'block';
            if (searchInput.style.display === 'block') {
              searchInput.style.width = '160px';
              searchInput.focus();
            }
          }
        });
      }
    }

    /* ============================================
       3. SCROLL REVEAL
    ============================================ */
    function initScrollReveal() {
      var els = document.querySelectorAll('.fade-in-up');
      if (!els.length) return;

      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            // Stagger children
            var parent = entry.target.parentElement;
            var siblings = parent ? Array.from(parent.children).filter(function(c) {
              return c.classList.contains('fade-in-up');
            }) : [];
            var idx = siblings.indexOf(entry.target);
            entry.target.style.transitionDelay = (idx * 80) + 'ms';
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, root: document.getElementById('main') });

      els.forEach(function(el) { observer.observe(el); });
    }

    /* ============================================
       4. COUNTERS
    ============================================ */
    function initCounters() {
      var counters = document.querySelectorAll('[data-count]');
      if (!counters.length) return;

      function easeOutQuad(t) { return t * (2 - t); }

      function animateCounter(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        var duration = 1800;
        var start = performance.now();

        function tick(now) {
          var elapsed = now - start;
          var progress = Math.min(elapsed / duration, 1);
          var value = Math.round(easeOutQuad(progress) * target);
          el.textContent = value;
          if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
      }

      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            var els = entry.target.querySelectorAll('[data-count]');
            els.forEach(animateCounter);
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, root: document.getElementById('main') });

      var grid = document.getElementById('statsGrid');
      if (grid) observer.observe(grid);
    }

    /* ============================================
       5. CHARTS
    ============================================ */
    function initCharts() {
      // Bar chart fill animation
      var barChart = document.getElementById('barChart');
      if (barChart) {
        var barObserver = new IntersectionObserver(function(entries) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              var fills = entry.target.querySelectorAll('.bar-fill');
              fills.forEach(function(fill) {
                var w = fill.getAttribute('data-width');
                fill.style.width = w + '%';
              });
              barObserver.unobserve(entry.target);
            }
          });
        }, { threshold: 0.12, root: document.getElementById('main') });
        barObserver.observe(barChart);
      }

      // Donut chart animation
      var donut = document.getElementById('donutChart');
      if (donut) {
        var segments = donut.querySelectorAll('.donut-segment');
        var circumference = 439.82;
        var percentages = [];
        segments.forEach(function(seg) {
          percentages.push(parseFloat(seg.getAttribute('data-percent')));
        });

        var donutObserver = new IntersectionObserver(function(entries) {
          entries.forEach(function(entry) {
            if (entry.isIntersecting) {
              var offset = 0;
              segments.forEach(function(seg, i) {
                var pct = percentages[i];
                var dash = (pct / 100) * circumference;
                var gap = circumference - dash;
                // Set dasharray and offset for segment positioning
                seg.style.transition = 'stroke-dashoffset 1.5s ease ' + (i * 0.15) + 's, stroke-dasharray 1.5s ease ' + (i * 0.15) + 's';
                seg.setAttribute('stroke-dasharray', dash + ' ' + gap);
                seg.setAttribute('stroke-dashoffset', -offset);
                offset += dash;
              });
              donutObserver.unobserve(entry.target);
            }
          });
        }, { threshold: 0.12, root: document.getElementById('main') });
        donutObserver.observe(donut);
      }
    }

    /* ============================================
       6. DATE
    ============================================ */
    function initDate() {
      var dateEl = document.getElementById('currentDate');
      if (dateEl) {
        var now = new Date();
        dateEl.textContent = now.toLocaleDateString('id-ID', {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
      }
    }

    /* ============================================
       INIT ALL
    ============================================ */
    document.addEventListener('DOMContentLoaded', function() {
      initSidebar();
      initTopbar();
      initDate();
      initScrollReveal();
      initCounters();
      initCharts();
    });
  </script>
</body>
</html>
