<aside class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
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

    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"># DashBoard</a>
    <a href="{{ route('admin.inventory-manager') }}" class="nav-link {{ request()->routeIs('admin.inventory-manager') ? 'active' : '' }}">□ Inventory Manager</a>
    <a href="{{ route('admin.cashier') }}" class="nav-link {{ request()->routeIs('admin.cashier') ? 'active' : '' }}">... Cashier</a>
    <a href="{{ route('admin.activities') }}" class="nav-link {{ request()->routeIs('admin.activities') ? 'active' : '' }}">▤ Activities Monitoring</a>
    <a href="{{ route('admin.sale-report') }}" class="nav-link {{ request()->routeIs('admin.sale-report') ? 'active' : '' }}">⊞ Sale Report</a>
    <a href="{{ route('admin.inventory-report') }}" class="nav-link {{ request()->routeIs('admin.inventory-report') ? 'active' : '' }}">☰ Inventory Report</a>
    <a href="{{ route('admin.stock-report') }}" class="nav-link {{ request()->routeIs('admin.stock-report') ? 'active' : '' }}">▤ Stock Report</a>
    <a href="{{ route('admin.expiry-report') }}" class="nav-link {{ request()->routeIs('admin.expiry-report') ? 'active' : '' }}">!! Expiry Report</a>
    <a href="{{ route('admin.revenue-report') }}" class="nav-link {{ request()->routeIs('admin.revenue-report') ? 'active' : '' }}">$ Revenue Report</a>
    <a href="{{ route('admin.notifications') }}" class="nav-link {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">◇ Notification</a>
</aside>