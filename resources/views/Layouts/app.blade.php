
@php
    $company = config('app.name', 'XYRA');
    $userName = auth()->user()->name ?? 'User';

    $paths = [
        'home' => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
        'layers' => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
        'tag' => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
        'truck' => '<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
        'chart' => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
        'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'package' => '<path d="M16.5 9.4l-9-5.19"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
        'search' => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>',
        'down' => '<polyline points="6 9 12 15 18 9"/>',
        'up' => '<polyline points="18 15 12 9 6 15"/>',
        'menu' => '<line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>',
    ];

    $ic = fn ($name, $size = 18) =>
        '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.($paths[$name] ?? '').'</svg>';

    $stockOpen = request()->routeIs('stock.*');
    $reportsOpen = request()->routeIs('reports.*');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') · {{ $company }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f4f5fb;
            --card: #ffffff;
            --ink: #1b1b3a;
            --muted: #6b7086;
            --line: #eceef5;

            --brand: #5b3df5;
            --brand-soft: #eeebff;
            --brand-ink: #3b22c9;

            --green: #10b981;
            --green-soft: #e3f8f0;
            --red: #ef4444;
            --red-soft: #fdeaea;
            --amber: #f59e0b;
            --amber-soft: #fff3df;

            --radius: 16px;
            --shadow: 0 1px 2px rgba(27,27,58,.04),
                      0 6px 20px rgba(27,27,58,.04);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }
        button { cursor: pointer; }
        svg { flex-shrink: 0; }
        .hidden { display: none !important; }

        .app { display: flex; min-height: 100vh; }

        .sidebar {
            width: 262px;
            background: #fff;
            border-right: 1px solid var(--line);
            padding: 20px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 16px 20px 28px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 8px 20px;
            border-bottom: 1px solid var(--line);
            margin-bottom: 14px;
        }

        .logo-mark {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: var(--brand);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 22px;
            box-shadow: 0 0 0 3px var(--brand-soft);
            flex-shrink: 0;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--ink);
            text-transform: uppercase;
            overflow-wrap: anywhere;
        }

        .nav a,
        .nav .nav-parent {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 10px;
            border-radius: 10px;
            color: #334155;
            font-weight: 500;
            cursor: pointer;
            margin-bottom: 3px;
            width: 100%;
            text-align: left;
            border: 0;
            background: transparent;
        }

        .nav a:hover,
        .nav .nav-parent:hover,
        .nav a.active,
        .nav .nav-parent.active {
            background: var(--brand-soft);
            color: var(--brand-ink);
        }

        .nav a.active,
        .nav .nav-parent.active { font-weight: 700; }

        .nav .chev { margin-left: auto; color: var(--muted); }

        .sub { margin: 2px 0 8px; padding-left: 12px; }

        .sub a {
            padding: 9px 10px 9px 12px;
            gap: 12px;
            font-size: 13px;
        }

        .sub a::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #cbd5e1;
        }

        .sub a.active::before { background: var(--brand); }

        .topbar {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 18px;
        }

        .company {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 17px;
            text-transform: uppercase;
            min-width: 0;
        }

        .company .logo-mark {
            width: 34px;
            height: 34px;
            font-size: 16px;
            box-shadow: none;
        }

        .search {
            flex: 0 1 320px;
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f5f4fc;
            border-radius: 10px;
            padding: 11px 14px;
            color: var(--muted);
        }

        .search input {
            border: 0;
            background: transparent;
            outline: 0;
            width: 100%;
            min-width: 0;
            color: var(--ink);
        }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--brand-soft);
            color: var(--brand-ink);
            display: grid;
            place-items: center;
            font-weight: 700;
        }

        .icon-btn {
            color: #475569;
            display: grid;
            place-items: center;
            padding: 8px;
            border-radius: 8px;
            border: 0;
            background: transparent;
        }

        .icon-btn:hover {
            background: var(--brand-soft);
            color: var(--brand-ink);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 5px;
        }

        .page-subtitle { color: var(--muted); font-size: 13px; }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 22px 24px;
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .card-head h2 { font-size: 16px; font-weight: 700; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--brand);
            color: #fff;
            padding: 11px 17px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid var(--brand);
            transition: background .15s ease;
        }

        .btn:hover { background: var(--brand-ink); }

        .btn-secondary {
            background: #fff;
            color: #334155;
            border-color: var(--line);
        }

        .btn-secondary:hover {
            background: var(--brand-soft);
            color: var(--brand-ink);
            border-color: #d9d1ff;
        }

        .btn-danger {
            background: var(--red);
            border-color: var(--red);
            color: #fff;
        }

        /* Logout button beside Admin */
        .logout-trigger {
            white-space: nowrap;
            flex-shrink: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group { min-width: 0; margin-bottom: 16px; }
        .form-group.full { grid-column: 1 / -1; }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #334155;
            font-size: 13px;
            font-weight: 600;
        }

        .form-control,
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            background: #fff;
            color: var(--ink);
            outline: none;
        }

        .form-control:focus,
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(91,61,245,.12);
        }

        .form-group textarea { min-height: 100px; resize: vertical; }

        .help-text {
            display: block;
            color: var(--muted);
            font-size: 12px;
            margin-top: 6px;
        }

        .table-wrap { width: 100%; overflow-x: auto; }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .table th {
            background: #f8f8fd;
            color: #6b7086;
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        .table tbody tr:hover { background: #fafaff; }

        .alert {
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: var(--green-soft);
            color: #047857;
            border-color: #a7f3d0;
        }

        .alert-error {
            background: var(--red-soft);
            color: #b91c1c;
            border-color: #fecaca;
        }

        .alert-info {
            background: var(--brand-soft);
            color: var(--brand-ink);
            border-color: #d9d1ff;
        }

        .empty { padding: 24px; text-align: center; color: var(--muted); }

        nav[role="navigation"] { margin-top: 18px; }

        .menu-btn {
            display: none;
            padding: 7px;
            border-radius: 8px;
            color: #475569;
            border: 0;
            background: transparent;
        }

        .sidebar-backdrop { display: none; }

        /* Shared logout confirmation modal */
        .logout-modal {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(20, 18, 45, .48);
            backdrop-filter: blur(4px);
        }

        .logout-dialog {
            width: 100%;
            max-width: 420px;
            padding: 28px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 24px 80px rgba(27,27,58,.24);
            animation: logoutModalIn .16s ease-out;
        }

        .logout-icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            margin-bottom: 18px;
            border-radius: 16px;
            background: var(--brand-soft);
            color: var(--brand);
        }

        .logout-dialog h2 {
            margin-bottom: 9px;
            color: var(--ink);
            font-size: 21px;
            font-weight: 800;
        }

        .logout-dialog p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .logout-dialog-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .logout-dialog-actions button {
            min-width: 105px;
        }

        .logout-cancel {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 9px;
            padding: 11px 16px;
            color: var(--ink);
            font-weight: 700;
        }

        .logout-cancel:hover { background: var(--brand-soft); }

        .logout-confirm {
            background: var(--brand);
            border: 1px solid var(--brand);
            border-radius: 9px;
            padding: 11px 16px;
            color: #fff;
            font-weight: 700;
        }

        .logout-confirm:hover { background: var(--brand-ink); }

        body.modal-open { overflow: hidden; }

        @keyframes logoutModalIn {
            from { opacity: 0; transform: translateY(8px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @media (max-width: 1000px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                z-index: 1001;
                transform: translateX(-100%);
                transition: transform .2s ease;
                box-shadow: var(--shadow);
            }

            .sidebar.mobile-open { transform: translateX(0); }

            .sidebar-backdrop.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1000;
                background: rgba(15,23,42,.35);
            }

            .menu-btn { display: grid; place-items: center; }
            .main { padding: 12px; }
        }

        @media (max-width: 650px) {
            .topbar {
                padding: 12px;
                gap: 10px;
                flex-wrap: wrap;
            }

            .company { font-size: 14px; }

            .search {
                order: 5;
                flex: 1 1 100%;
                margin-left: 0;
            }

            .user { margin-left: auto; }
            .user span { display: none; }

            .logout-trigger {
                padding: 9px 11px;
                font-size: 12px;
            }

            .card { padding: 17px; }
            .page-title { font-size: 21px; }
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .form-group.full { grid-column: auto; }

            .logout-dialog { padding: 23px; }
            .logout-dialog-actions { flex-direction: column-reverse; }
            .logout-dialog-actions button { width: 100%; }
        }

        @stack('styles')
    </style>
</head>

<body>
<div class="app">

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <aside class="sidebar" id="appSidebar">
        <div class="logo">
            <div class="logo-mark">{{ strtoupper(substr($company, 0, 1)) }}</div>
            <span class="logo-text">{{ $company }}</span>
        </div>

        <nav class="nav">
            @can('view dashboard')
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    {!! $ic('home', 20) !!} Dashboard
                </a>
            @endcan

           

            @can('view products')
                <a href="{{ route('products.index') }}"
                   class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                    {!! $ic('package', 20) !!} Products
                </a>
            @endcan

            @can('view suppliers')
                <a href="{{ route('suppliers.index') }}"
                   class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    {!! $ic('truck', 20) !!} Suppliers
                </a>
            @endcan

            @can('view stock')
                <button type="button"
                        class="nav-parent {{ $stockOpen ? 'active' : '' }}"
                        data-toggle="sub-stock"
                        aria-expanded="{{ $stockOpen ? 'true' : 'false' }}">
                    {!! $ic('layers', 20) !!}
                    Stock
                    <span class="chev">{!! $ic($stockOpen ? 'up' : 'down', 16) !!}</span>
                </button>

                <div class="sub {{ $stockOpen ? '' : 'hidden' }}" id="sub-stock">
                    <a href="{{ route('stock.index') }}"
                       class="{{ request()->routeIs('stock.index') ? 'active' : '' }}">
                        Overview
                    </a>

                    @can('stock in')
                        <a href="{{ route('stock.create-in') }}"
                           class="{{ request()->routeIs('stock.create-in', 'stock.store-in') ? 'active' : '' }}">
                            Stock In
                        </a>
                    @endcan

                    @can('stock out')
                        <a href="{{ route('stock.create-out') }}"
                           class="{{ request()->routeIs('stock.create-out', 'stock.store-out') ? 'active' : '' }}">
                            Stock Out
                        </a>
                    @endcan

                    <a href="{{ route('stock.history') }}"
                       class="{{ request()->routeIs('stock.history') ? 'active' : '' }}">
                        History
                    </a>
                </div>
            @endcan

            @can('view reports')
                <button type="button"
                        class="nav-parent {{ $reportsOpen ? 'active' : '' }}"
                        data-toggle="sub-reports"
                        aria-expanded="{{ $reportsOpen ? 'true' : 'false' }}">
                    {!! $ic('chart', 20) !!}
                    Reports
                    <span class="chev">{!! $ic($reportsOpen ? 'up' : 'down', 16) !!}</span>
                </button>

                <div class="sub {{ $reportsOpen ? '' : 'hidden' }}" id="sub-reports">
                    <a href="{{ route('reports.index') }}"
                       class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">Overview</a>
                    <a href="{{ route('reports.stock') }}"
                       class="{{ request()->routeIs('reports.stock') ? 'active' : '' }}">Stock Report</a>
                    <a href="{{ route('reports.transactions') }}"
                       class="{{ request()->routeIs('reports.transactions') ? 'active' : '' }}">Transactions</a>
                    <a href="{{ route('reports.valuation') }}"
                       class="{{ request()->routeIs('reports.valuation') ? 'active' : '' }}">Valuation</a>
                    <a href="{{ route('reports.low-stock') }}"
                       class="{{ request()->routeIs('reports.low-stock') ? 'active' : '' }}">Low Stock</a>
                </div>
            @endcan

            @can('manage users')
                <a href="{{ route('users.index') }}"
                   class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    {!! $ic('users', 20) !!} Users
                </a>
            @endcan
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <button type="button" class="menu-btn" id="sidebarToggle"
                    aria-label="Toggle navigation">
                {!! $ic('menu', 22) !!}
            </button>

            <div class="company">
                <div class="logo-mark">{{ strtoupper(substr($company, 0, 1)) }}</div>
                {{ $company }}
            </div>

            <form class="search" action="{{ route('products.index') }}" method="GET">
                {!! $ic('search', 18) !!}
                <input type="text" name="search"
                       placeholder="Search products..."
                       value="{{ request('search') }}">
            </form>

            <div class="user">
                <div class="avatar">{{ strtoupper(substr($userName, 0, 1)) }}</div>
                <span>{{ $userName }}</span>
            </div>

            {{-- Logout button beside Admin --}}
            <button type="button"
                    class="btn btn-secondary logout-trigger"
                    data-logout-confirm>
                {!! $ic('logout', 16) !!}
                Logout
            </button>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if (session('status'))
            <div class="alert alert-info">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>
</div>

{{-- One shared logout form; submitted only after confirmation --}}
<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

{{-- Custom desktop/mobile logout confirmation --}}
<div class="logout-modal hidden"
     id="logoutModal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="logoutModalTitle"
     aria-describedby="logoutModalDescription">

    <div class="logout-dialog">
        <div class="logout-icon">
            {!! $ic('logout', 25) !!}
        </div>

        <h2 id="logoutModalTitle">Confirm Logout</h2>

        <p id="logoutModalDescription">
            Are you sure you want to log out of your account?
            You will need to sign in again to continue.
        </p>

        <div class="logout-dialog-actions">
            <button type="button" class="logout-cancel" id="cancelLogout">
                Cancel
            </button>

            <button type="button" class="logout-confirm" id="confirmLogout">
                Yes, Logout
            </button>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            const target = document.getElementById(button.dataset.toggle);

            if (!target) return;

            target.classList.toggle('hidden');

            const expanded = !target.classList.contains('hidden');
            button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
    });

    const sidebar = document.getElementById('appSidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    const sidebarToggle = document.getElementById('sidebarToggle');

    function closeSidebar() {
        sidebar.classList.remove('mobile-open');
        backdrop.classList.remove('show');
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
            backdrop.classList.toggle('show');
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeSidebar);
    }

    // Shared custom logout confirmation
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogout = document.getElementById('cancelLogout');
    const confirmLogout = document.getElementById('confirmLogout');
    const logoutForm = document.getElementById('logoutForm');

    let previousFocus = null;

    function openLogoutModal() {
        previousFocus = document.activeElement;
        logoutModal.classList.remove('hidden');
        document.body.classList.add('modal-open');
        cancelLogout.focus();
    }

    function closeLogoutModal() {
        logoutModal.classList.add('hidden');
        document.body.classList.remove('modal-open');

        if (previousFocus) {
            previousFocus.focus();
        }
    }

    document.querySelectorAll('[data-logout-confirm]').forEach(function (button) {
        button.addEventListener('click', openLogoutModal);
    });

    cancelLogout.addEventListener('click', closeLogoutModal);

    logoutModal.addEventListener('click', function (event) {
        if (event.target === logoutModal) {
            closeLogoutModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !logoutModal.classList.contains('hidden')) {
            closeLogoutModal();
        }
    });

    confirmLogout.addEventListener('click', function () {
        confirmLogout.disabled = true;
        confirmLogout.textContent = 'Logging out...';
        logoutForm.submit();
    });
</script>

@yield('scripts')
</body>
</html>
