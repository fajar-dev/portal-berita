<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin {{ \App\Models\Setting::get('site_name', 'NusaKini') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300..800&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@4/es2021/jodit.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jodit@4/es2021/jodit.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --admin-bg: #f5f6f8;
            --admin-surface: #ffffff;
            --admin-surface-hover: #f7f8fa;
            --admin-border: #e5e7ec;
            --admin-border-light: #eef0f4;
            --admin-text: #1a1d26;
            --admin-text-secondary: #5f6577;
            --admin-text-muted: #9298a8;
            --admin-primary: hsl(354, 70%, 48%);
            --admin-primary-soft: hsl(354, 80%, 96%);
            --admin-primary-hover: hsl(354, 70%, 42%);
            --admin-success: #16a34a;
            --admin-success-soft: #f0fdf4;
            --admin-warning: #f59e0b;
            --admin-warning-soft: #fffbeb;
            --admin-danger: #dc2626;
            --admin-danger-soft: #fef2f2;
            --admin-info: #2563eb;
            --admin-info-soft: #eff6ff;
            --admin-sidebar-w: 256px;
            --admin-header-h: 60px;
            --admin-radius: 10px;
            --admin-radius-sm: 7px;
            --admin-radius-xs: 5px;
            --admin-shadow-sm: 0 1px 2px rgba(0,0,0,.04);
            --admin-shadow-md: 0 4px 12px rgba(0,0,0,.05);
            --admin-font: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --admin-font-heading: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            --admin-transition: all .15s ease;
            /* Consistent spacing tokens */
            --sp-xs: 4px;
            --sp-sm: 8px;
            --sp-md: 12px;
            --sp-lg: 16px;
            --sp-xl: 20px;
            --sp-2xl: 24px;
            --sp-3xl: 32px;
            /* Consistent font sizes */
            --fs-xs: .72rem;
            --fs-sm: .8rem;
            --fs-base: .85rem;
            --fs-md: .9rem;
            --fs-lg: .95rem;
            --fs-xl: 1.05rem;
        }

        body { font-family: var(--admin-font); background: var(--admin-bg); color: var(--admin-text); line-height: 1.55; font-size: var(--fs-md); -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }

        /* ── Sidebar ───────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--admin-sidebar-w);
            background: var(--admin-surface);
            border-right: 1px solid var(--admin-border);
            display: flex; flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            height: var(--admin-header-h);
            display: flex; align-items: center;
            padding: 0 var(--sp-xl);
            border-bottom: 1px solid var(--admin-border-light);
        }
        .sidebar-brand-logo {
            font-family: var(--admin-font-heading);
            font-size: 1.25rem; font-weight: 800;
            color: var(--admin-primary);
            letter-spacing: -.3px;
        }
        .sidebar-brand-logo em { font-style: normal; color: var(--admin-text); }
        .sidebar-brand-badge {
            font-size: .58rem; font-weight: 700;
            background: var(--admin-primary-soft); color: var(--admin-primary);
            padding: 2px 8px; border-radius: 20px;
            margin-left: var(--sp-sm); text-transform: uppercase; letter-spacing: .5px;
        }
        .sidebar-nav { flex: 1; overflow-y: auto; padding: var(--sp-md) var(--sp-sm); }
        .sidebar-section-label {
            font-size: .62rem; font-weight: 700;
            color: var(--admin-text-muted); text-transform: uppercase;
            letter-spacing: .8px; padding: var(--sp-lg) var(--sp-md) var(--sp-sm);
        }
        .sidebar-link {
            display: flex; align-items: center; gap: var(--sp-sm);
            padding: 8px var(--sp-md); border-radius: var(--admin-radius-sm);
            font-size: var(--fs-base); font-weight: 500;
            color: var(--admin-text-secondary);
            transition: var(--admin-transition);
            margin-bottom: 1px;
        }
        .sidebar-link:hover { background: var(--admin-surface-hover); color: var(--admin-text); }
        .sidebar-link.active { background: var(--admin-primary-soft); color: var(--admin-primary); font-weight: 600; }
        .sidebar-link svg { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-footer {
            padding: var(--sp-lg) var(--sp-xl);
            border-top: 1px solid var(--admin-border-light);
            display: flex; align-items: center; gap: var(--sp-sm);
        }
        .sidebar-footer-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--admin-primary-soft); color: var(--admin-primary);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: var(--fs-sm);
        }

        /* ── Header ────────────────────────── */
        .topbar {
            position: sticky; top: 0; z-index: 90;
            height: var(--admin-header-h);
            margin-left: var(--admin-sidebar-w);
            background: rgba(245,246,248,.88); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--admin-border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 var(--sp-2xl);
        }
        .topbar-title { font-family: var(--admin-font-heading); font-weight: 700; font-size: var(--fs-xl); }
        .topbar-actions { display: flex; align-items: center; gap: var(--sp-sm); }

        /* ── Main Content ──────────────────── */
        .main { margin-left: var(--admin-sidebar-w); padding: var(--sp-2xl); min-height: calc(100vh - var(--admin-header-h)); }

        /* ── Cards ──────────────────────────── */
        .card {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: var(--admin-radius);
            box-shadow: var(--admin-shadow-sm);
            overflow: hidden;
        }
        .card-header {
            padding: var(--sp-lg) var(--sp-xl);
            border-bottom: 1px solid var(--admin-border-light);
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: var(--sp-md);
            min-height: 56px;
        }
        .card-header-left { display: flex; align-items: center; gap: var(--sp-md); }
        .card-header h2 { font-family: var(--admin-font-heading); font-size: var(--fs-lg); font-weight: 700; margin: 0; white-space: nowrap; }
        .card-body { padding: var(--sp-xl); }
        .card-body--flush { padding: 0; }
        .card-footer {
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;
            padding: var(--sp-md) var(--sp-xl);
            border-top: 1px solid var(--admin-border-light);
            min-height: 52px; gap: var(--sp-md);
        }
        .card-footer-info { font-size: var(--fs-sm); color: var(--admin-text-muted); }
        .card-footer-info strong { font-weight: 600; color: var(--admin-text-secondary); }

        /* ── Stat Grid ─────────────────────── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--sp-lg); margin-bottom: var(--sp-2xl); }
        .stat-card {
            background: var(--admin-surface); border: 1px solid var(--admin-border);
            border-radius: var(--admin-radius); padding: var(--sp-xl);
            display: flex; align-items: flex-start; gap: var(--sp-lg);
            box-shadow: var(--admin-shadow-sm);
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: var(--admin-radius-sm);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .stat-icon svg { width: 20px; height: 20px; }
        .stat-value { font-family: var(--admin-font-heading); font-size: 1.5rem; font-weight: 800; line-height: 1; }
        .stat-label { font-size: var(--fs-sm); color: var(--admin-text-secondary); margin-top: var(--sp-xs); }

        /* ── Table ──────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table.admin-tbl { width: 100%; border-collapse: collapse; }
        table.admin-tbl th {
            text-align: left; padding: var(--sp-md) var(--sp-xl);
            font-size: var(--fs-xs); font-weight: 700;
            color: var(--admin-text-muted); text-transform: uppercase; letter-spacing: .6px;
            background: var(--admin-surface-hover);
            border-bottom: 1px solid var(--admin-border);
            white-space: nowrap;
        }
        table.admin-tbl td {
            padding: var(--sp-md) var(--sp-xl); border-bottom: 1px solid var(--admin-border-light);
            font-size: var(--fs-base); vertical-align: middle;
        }
        table.admin-tbl tbody tr { transition: var(--admin-transition); }
        table.admin-tbl tbody tr:hover td { background: var(--admin-surface-hover); }
        table.admin-tbl tbody tr:last-child td { border-bottom: none; }
        .td-title { font-weight: 600; color: var(--admin-text); }
        .td-sub { font-size: var(--fs-xs); color: var(--admin-text-muted); margin-top: 2px; }
        .td-muted { color: var(--admin-text-muted); font-size: var(--fs-base); }
        .td-secondary { color: var(--admin-text-secondary); font-size: var(--fs-base); }
        .td-actions { text-align: right; white-space: nowrap; }
        .td-actions .btn + .btn,
        .td-actions .btn + form,
        .td-actions form + .btn { margin-left: var(--sp-xs); }
        .td-actions form { display: inline; }
        .td-num { font-family: var(--admin-font-heading); font-weight: 700; font-variant-numeric: tabular-nums; }

        /* ── Badges ─────────────────────────── */
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: var(--fs-xs); font-weight: 600; letter-spacing: .2px;
        }
        .badge-success { background: var(--admin-success-soft); color: var(--admin-success); }
        .badge-warning { background: var(--admin-warning-soft); color: var(--admin-warning); }
        .badge-danger  { background: var(--admin-danger-soft);  color: var(--admin-danger); }
        .badge-info    { background: var(--admin-info-soft);    color: var(--admin-info); }
        .badge-muted   { background: var(--admin-surface-hover); color: var(--admin-text-muted); }

        /* ── Buttons ───────────────────────── */
        .btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 8px 14px; border-radius: var(--admin-radius-sm);
            font-family: var(--admin-font); font-weight: 600; font-size: var(--fs-base);
            border: none; cursor: pointer; transition: var(--admin-transition);
            white-space: nowrap; line-height: 1.3;
        }
        .btn svg { width: 15px; height: 15px; flex-shrink: 0; }
        .btn-primary { background: var(--admin-primary); color: #fff; }
        .btn-primary:hover { background: var(--admin-primary-hover); }
        .btn-outline { background: transparent; border: 1px solid var(--admin-border); color: var(--admin-text-secondary); }
        .btn-outline:hover { background: var(--admin-surface-hover); color: var(--admin-text); border-color: #d0d3da; }
        .btn-ghost { background: transparent; color: var(--admin-text-secondary); }
        .btn-ghost:hover { background: var(--admin-surface-hover); }
        .btn-danger-outline { background: transparent; border: 1px solid rgba(220,38,38,.18); color: var(--admin-danger); }
        .btn-danger-outline:hover { background: var(--admin-danger); color: #fff; border-color: var(--admin-danger); }
        .btn-sm { padding: 6px 11px; font-size: var(--fs-sm); }
        .btn-sm svg { width: 14px; height: 14px; }

        /* ── Search Bar ────────────────────── */
        .search-bar { display: flex; align-items: center; gap: var(--sp-sm); }
        .search-bar-input {
            position: relative;
        }
        .search-bar-input svg {
            position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
            width: 15px; height: 15px; color: var(--admin-text-muted); pointer-events: none;
        }
        .search-bar-input input {
            width: 220px; padding: 7px 12px 7px 34px;
            border: 1px solid var(--admin-border); border-radius: var(--admin-radius-sm);
            background: var(--admin-surface-hover); color: var(--admin-text);
            font-family: var(--admin-font); font-size: var(--fs-sm);
            transition: var(--admin-transition);
        }
        .search-bar-input input:focus {
            outline: none; border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px var(--admin-primary-soft);
            background: var(--admin-surface);
        }
        .search-bar-input input::placeholder { color: var(--admin-text-muted); }

        /* ── Pagination ───────────────────── */
        .pagination-nav { display: flex; align-items: center; gap: var(--sp-xs); }
        .pg-btn {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 32px; height: 32px; padding: 0;
            border-radius: var(--admin-radius-xs); font-size: var(--fs-sm); font-weight: 600;
            border: 1px solid var(--admin-border); color: var(--admin-text-secondary);
            background: transparent; cursor: pointer; transition: var(--admin-transition);
            text-decoration: none;
        }
        .pg-btn:hover { background: var(--admin-surface-hover); border-color: #d0d3da; }
        .pg-btn--active { background: var(--admin-primary); color: #fff; border-color: var(--admin-primary); }
        .pg-btn--active:hover { background: var(--admin-primary-hover); }
        .pg-btn--disabled { opacity: .4; cursor: not-allowed; pointer-events: none; }
        .pg-btn svg { width: 14px; height: 14px; }
        .pg-dots { display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; font-size: var(--fs-sm); color: var(--admin-text-muted); }

        /* ── Forms ──────────────────────────── */
        .form-group { margin-bottom: var(--sp-xl); }
        .form-label { display: block; margin-bottom: 6px; font-weight: 600; font-size: var(--fs-base); color: var(--admin-text); }
        .form-hint { font-size: var(--fs-sm); color: var(--admin-text-muted); margin-top: var(--sp-xs); }
        .form-control {
            width: 100%; padding: 9px 14px;
            border: 1px solid var(--admin-border); border-radius: var(--admin-radius-sm);
            background: var(--admin-surface); color: var(--admin-text);
            font-family: var(--admin-font); font-size: var(--fs-md);
            transition: var(--admin-transition);
        }
        .form-control:focus { outline: none; border-color: var(--admin-primary); box-shadow: 0 0 0 3px var(--admin-primary-soft); }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7185' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
        textarea.form-control { resize: vertical; min-height: 120px; line-height: 1.6; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: var(--sp-lg); }

        /* ── Alert ──────────────────────────── */
        .alert {
            padding: var(--sp-md) var(--sp-lg); border-radius: var(--admin-radius-sm);
            margin-bottom: var(--sp-xl); font-size: var(--fs-base); font-weight: 500;
            display: flex; align-items: center; gap: var(--sp-sm);
        }
        .alert-success { background: var(--admin-success-soft); color: var(--admin-success); border: 1px solid rgba(22,163,74,.12); }
        .alert-error   { background: var(--admin-danger-soft);  color: var(--admin-danger);  border: 1px solid rgba(220,38,38,.12); }

        /* ── Empty State ───────────────────── */
        .empty-state { text-align: center; padding: 48px var(--sp-xl); color: var(--admin-text-muted); font-size: var(--fs-base); }

        /* ── Responsive ────────────────────── */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.35); z-index: 99;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }
        .mobile-toggle {
            display: none; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: var(--admin-radius-sm);
            border: 1px solid var(--admin-border); background: var(--admin-surface);
            cursor: pointer; flex-shrink: 0;
        }
        .mobile-toggle svg { width: 20px; height: 20px; color: var(--admin-text); }

        /* Tablet */
        @media (max-width: 1024px) {
            .search-bar-input input { width: 180px; }
            .topbar-actions .btn span { display: none; }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
                box-shadow: none;
            }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 8px 0 24px rgba(0,0,0,.1);
            }
            .topbar, .main { margin-left: 0; }
            .topbar { padding: 0 var(--sp-lg); }
            .main { padding: var(--sp-lg); }
            .mobile-toggle { display: flex; }
            .stat-grid { grid-template-columns: 1fr 1fr; gap: var(--sp-md); }
            .card-header {
                flex-direction: column; align-items: stretch; gap: var(--sp-sm);
                padding: var(--sp-md) var(--sp-lg);
            }
            .card-header-left { flex-wrap: wrap; gap: var(--sp-sm); }
            .card-header h2 { font-size: var(--fs-md); }
            .card-body { padding: var(--sp-lg); }
            .card-footer {
                flex-direction: column; align-items: flex-start;
                padding: var(--sp-md) var(--sp-lg); gap: var(--sp-sm);
            }
            .search-bar { width: 100%; }
            .search-bar-input { flex: 1; }
            .search-bar-input input { width: 100%; }
            table.admin-tbl th, table.admin-tbl td {
                padding: var(--sp-sm) var(--sp-md);
                font-size: var(--fs-sm);
            }
            .td-actions {
                display: flex; gap: var(--sp-xs);
                justify-content: flex-end;
            }
            .btn-sm { padding: 5px 9px; font-size: var(--fs-xs); }
            .pagination-nav { flex-wrap: wrap; }
            .pg-btn { min-width: 30px; height: 30px; }
            .form-row { grid-template-columns: 1fr; }
        }

        /* Small phones */
        @media (max-width: 480px) {
            .stat-grid { grid-template-columns: 1fr; }
            .topbar-title { font-size: var(--fs-md); }
            .topbar-actions .btn:not(.mobile-toggle) span,
            .topbar-actions .btn:not(.mobile-toggle) { font-size: var(--fs-xs); padding: 5px 8px; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    @include('admin.partials.sidebar')

    <header class="topbar">
        <div style="display:flex;align-items:center;gap:var(--sp-md);">
            <button class="mobile-toggle" onclick="toggleSidebar()" aria-label="Menu">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="topbar-title">@yield('header_title', 'Dashboard')</h1>
        </div>
        <div class="topbar-actions">
            <a href="{{ route('news.home') }}" target="_blank" class="btn btn-outline btn-sm">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat Website</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm">Keluar</button>
            </form>
        </div>
    </header>

    <main class="main">
        @if(session('success'))
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('active');
            document.body.style.overflow = document.querySelector('.sidebar').classList.contains('open') ? 'hidden' : '';
        }
    </script>
    @stack('scripts')
</body>
</html>

