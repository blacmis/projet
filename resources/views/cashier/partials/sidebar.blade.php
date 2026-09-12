<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('cashier.payment') }}">
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

    <nav class="nav">
        <a href="{{ route('cashier.quick-shop') }}"
           class="nav-link {{ request()->routeIs('cashier.quick-shop') ? 'active' : '' }}">
            <span><i class="bi bi-shop"></i></span> Boutique rapide
        </a>
        <a href="{{ route('cashier.payment') }}"
           class="nav-link {{ request()->routeIs('cashier.payment') ? 'active' : '' }}">
            <span><i class="bi bi-credit-card"></i></span> Paiement
        </a>
        <a href="{{ route('cashier.register.open') }}"class="nav-link {{ request()->routeIs('cashier.register.open') ? 'active' : '' }}">
            <span><i class="bi bi-box-arrow-in-right"></i></span> Ouverture de Caisse</a>
        <a href="{{ route('cashier.register.close') }}"class="nav-link {{ request()->routeIs('cashier.register.close') ? 'active' : '' }}"><span><i class="bi bi-box-arrow-right"></i></span> Fermeture de Caisse</a>
        <a href="{{ route('cashier.receipt') }}"
           class="nav-link {{ request()->routeIs('cashier.receipt') ? 'active' : '' }}">
            <span><i class="bi bi-receipt"></i></span> Reçu
        </a>
        <a href="{{ route('cashier.sales') }}"
           class="nav-link {{ request()->routeIs('cashier.sales*') || request()->routeIs('cashier.sale.*') ? 'active' : '' }}">
            <span><i class="bi bi-clock-history"></i></span> Historique des ventes
        </a>
        <a href="{{ route('cashier.summary') }}"
           class="nav-link {{ request()->routeIs('cashier.summary') ? 'active' : '' }}">
            <span><i class="bi bi-calendar-check"></i></span> Résumé quotidien
        </a>
        <a href="{{ route('cashier.notifications') }}"
           class="nav-link {{ request()->routeIs('cashier.notifications') ? 'active' : '' }}">
            <span><i class="bi bi-bell"></i></span> Notifications
        </a>
    </nav>
</aside>