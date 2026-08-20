<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MarketSmart - Manager')</title>
    <!-- Bootstrap 5 CSS (via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Notre CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('css/manager.css') }}">
    @stack('styles') {{-- Pour ajouter du CSS spécifique à une page plus tard --}}
</head>
<body>
    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="sidebar">
    {{-- Logo --}}
    <div class="sidebar-logo">
        <h4>
            <i class="bi bi-cart4"></i> Market<span style="color:#ffd700">Smart</span>
        </h4>
        <small>MARKET</small>
    </div>
    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <a href="{{ route('manager.dashboard') }}"
           class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>DashBoard</span>
        </a>
        {{-- Liens temporaires (on les activera page par page) --}}
        <a href="{{ route('manager.products.index') }}" 
        class="nav-link {{ request()->routeIs('manager.produts') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Products</span>
        </a>
        <a href="{{ route('manager.stock-inflow.index') }}"
         class="nav-link {{ request()->routeIs('manager.stock-inflow.*')?'active':'' }}">
            <i class="bi bi-box-arrow-in-down"></i>
            <span>Stock Inflow</span>
        </a>
        <a href="{{ route('manager.stock-outflow.index') }}" 
         class="nav-link {{ request()->routeIs('manager.stock-outflow.*')?'active':'' }}">
            <i class="bi bi-box-arrow-up"></i>
            <span>Stock Outflow</span>
        </a>
        <a href="{{ route('manager.stock-adjustment.index') }}" 
         class="nav-link {{ request()->routeIs('manager.stock-adjustment.*')?'active':'' }}">
            <i class="bi bi-arrow-left-right"></i>
            <span>Stock Adjustment</span>
        </a>
        <a href="{{ route('manager.expired.index') }}"
         class="nav-link {{ request()->routeIs('manager.expired.*') || request()->routeIs('manager.expired.*') ?'active':'' }}">
            <i class="bi bi-exclamation-triangle"></i>
            <span>Expired & Damage Goods</span>
        </a>
        <a href="{{ route('manager.reports.inventory') }}"
         class="nav-link {{ request()->routeIs('manager.reports.inventory')?'active':'' }}">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Inventory Report</span>
        </a>
        <a href="{{ route('manager.reports.low-stock') }}"
         class="nav-link {{ request()->routeIs('manager.reports.low-stock')?'active':'' }}">
            <i class="bi bi-exclamation-circle"></i>
            <span>Low Stock Report</span>
        </a>
        <a href="{{ route('manager.suppliers.index') }}"
         class="nav-link {{ request()->routeIs('manager.suppliers.*')?'active':'' }}">
            <i class="bi bi-truck"></i>
            <span>Suppliers</span>
        </a>
        <a href="{{ route('manager.categories.index') }}"
         class="nav-link {{ request()->routeIs('manager.categories.*')?'active':'' }}">
            <i class="bi bi-tags"></i>
            <span>Categories</span>
        </a>
        <a href="{{ route('manager.units.index') }}"
         class="nav-link {{ request()->routeIs('manager.units.*')?'active':'' }}">
            <i class="bi bi-rulers"></i>
            <span>Unit</span>
        </a>
    </nav>
    {{-- Bas de la sidebar --}}
    <div class="sidebar-footer">
        <a href="{{ route('manager.profile') }}"
         class="nav-link {{ request()->routeIs('manager.profile')?'active':'' }}">
            <i class="bi bi-person-circle"></i>
            <span>My Profile</span>
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>
    {{-- ===================== CONTENU PRINCIPAL ===================== --}}
    <main class="main-content">
    {{-- Header haut de page --}}
    <div class="d-flex justify-content-between align-items-center mb-4 px-3 pt-3">
        <div></div> {{-- espace à gauche --}}
        <div class="d-flex align-items-center gap-3">
            {{-- Bouton Profile --}}
            <a href="{{ route('manager.profile') }}" class="d-flex align-items-center text-decoration-none text-dark">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                     style="width: 38px; height: 38px;">
                    <i class="bi bi-person-fill" style="font-size: 1.2rem;"></i>
                </div>
                <div class="d-none d-md-block">
                    <div class="fw-semibold" style="font-size: 0.9rem;">Inventory Manager</div>
                    <small class="text-muted">My Profile</small>
                </div>
            </a>
        </div>
    </div>
    @yield('content')
</main>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') {{-- Pour ajouter du JS spécifique à une page plus tard --}}
</body>
</html>