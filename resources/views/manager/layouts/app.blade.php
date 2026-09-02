<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MarketSmart Manager')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/manager.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ux-enhancements.css') }}">
</head>
<body>
<div class="d-flex">
    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('manager.dashboard') }}">
                <div class="logo-circle">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2.3 2.3c-.4.4-.1 1.1.4 1.1H17M17 13v6a1 1 0 01-1 1H8a1 1 0 01-1-1v-6"
                              stroke="#c47a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="9" cy="20" r="1" fill="#c47a1a"/>
                        <circle cx="16" cy="20" r="1" fill="#c47a1a"/>
                    </svg>
                </div>
                <div>
                    <div class="brand-name">Market<span>Smart</span></div>
                    <div class="brand-sub">Market</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('manager.dashboard') }}" class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">▤ Dashboard</a>
            <a href="{{ route('manager.products.index') }}" class="nav-link {{ request()->routeIs('manager.products*') ? 'active' : '' }}">🛒 Products</a>
            <a href="{{ route('manager.stock-inflow.index') }}" class="nav-link {{ request()->routeIs('manager.stock-inflow.*')?'active':'' }}">□ Stock Inflow</a>
            <a href="{{ route('manager.stock-outflow.index') }}" class="nav-link {{ request()->routeIs('manager.stock-outflow.*')?'active':'' }}"><> Stock Outflow</a>
            <a href="{{ route('manager.stock-adjustment.index') }}" class="nav-link {{ request()->routeIs('manager.stock-adjustment.*')?'active':'' }}"> <..>Stock Adjustment</a>
            <a href="{{ route('manager.expired.index') }}" class="nav-link {{ request()->routeIs('manager.expired.*') || request()->routeIs('manager.expired.*') ?'active':'' }}">!! Expired & Damage Goods</a>
            <a href="{{ route('manager.reports.inventory') }}" class="nav-link {{ request()->routeIs('manager.reports.inventory')?'active':'' }}">◇ Inventory Report</a>
            <a href="{{ route('manager.suppliers.index') }}" class="nav-link {{ request()->routeIs('manager.suppliers.*')?'active':'' }}">o Suppliers</a>
            <a href="{{ route('manager.reports.low-stock') }}" class="nav-link {{ request()->routeIs('manager.reports.low-stock')?'active':'' }}">▤ Low Stock Report</a>
            <a href="{{ route('manager.categories.index') }}" class="nav-link {{ request()->routeIs('manager.categories*') ? 'active' : '' }}"> ⊞Categories</a>
            <a href="{{ route('manager.units.index') }}" class="nav-link {{ request()->routeIs('manager.units.*')?'active':'' }}">☰ Unit</a>
        </nav>
    </aside>

    {{-- MAIN --}}
    <div class="main-content flex-grow-1">
        <header class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom bg-white px-4 py-3"
                style="margin:-25px -30px 25px;padding-left:30px!important;padding-right:30px!important;">
            <div>
                <h5 class="mb-0">@yield('page_title', 'Dashboard')</h5>
            </div>

            <div class="dropdown">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2"
                        type="button"
                        id="managerUserMenu"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="border-radius:999px;padding:6px 14px;border:1px solid #e9ecef;">
                    <span style="width:32px;height:32px;border-radius:50%;background:#fff3cd;display:inline-flex;align-items:center;justify-content:center;">👤</span>
                    <span class="text-start">
                        <strong style="font-size:13px;display:block;line-height:1.2;">Inventory Manager</strong>
                        <small class="text-muted" style="font-size:11px;">Account</small>
                    </span>
                    <span style="font-size:10px;color:#6c757d;">▼</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="managerUserMenu">
                    <li>
                        <a class="dropdown-item" href="{{ route('manager.profile') }}">👤 Mon profil</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                🚪 Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script src="{{ asset('js/ux-enhancements.js') }}"></script>
</body>
</html>