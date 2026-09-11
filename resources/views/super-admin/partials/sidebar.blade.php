<aside class="sidebar super-admin-sidebar">
    <div class="brand">
        <div class="logo-circle">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2.3 2.3c-.4.4-.1 1.1.4 1.1H17M17 13v6a1 1 0 01-1 1H8a1 1 0 01-1-1v-6"
                      stroke="#1f2937" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="9" cy="20" r="1" fill="#1f2937"/>
                <circle cx="16" cy="20" r="1" fill="#1f2937"/>
            </svg>
        </div>
        <div>
            <div class="brand-name">Market<span>Smart</span></div>
            <div class="brand-sub">Super Admin</div>
        </div>
    </div>

    <a href="{{ route('super-admin.dashboard') }}" class="nav-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}"><i class="bi bi-shop-window me-2"></i> Supermarchés</a>
    <a href="{{ route('super-admin.tenants.create') }}" class="nav-link {{ request()->routeIs('super-admin.tenants.create') ? 'active' : '' }}"><i class="bi bi-plus-circle me-2"></i> Nouveau supermarché</a>
    <a href="{{ route('super-admin.leads.index') }}" class="nav-link {{ request()->routeIs('super-admin.leads.*') ? 'active' : '' }}"><i class="bi bi-envelope me-2"></i> Demandes reçues</a>
        <a href="{{ route('super-admin.feedback.index') }}" class="nav-link {{ request()->routeIs('super-admin.feedback.*') ? 'active' : '' }}"><i class="bi bi-chat-square-text me-2"></i> Réclamations & suggestions</a>
</aside>