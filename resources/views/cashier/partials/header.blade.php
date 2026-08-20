<header class="topbar">
    <div class="page-title">
        <h1>@yield('page_title')</h1>
        <p>MarketSmart Cashier Portal</p>
    </div>

    <div class="top-actions">
        <a href="{{ route('cashier.notifications') }}" class="icon-btn notification-dot">♢</a>
        <div class="user-mini">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'CA', 0, 2)) }}</div>
            <div>
                <strong>{{ auth()->user()->name ?? 'Cashier' }}</strong>
                <small>Active</small>
            </div>
        </div>
    </div>
</header>
