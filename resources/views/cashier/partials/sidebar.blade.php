<aside class="sidebar">
    <div class="brand">
        <div class="brand-mark">M</div>
        <div>
            <div class="sidebar-logo">
                <img src="" alt="">
            </div>
        </div>
    </div>

    <nav class="nav">
   <a class="nav-link {{ request()->routeIs('cashier.quick-shop') ? 'active' : '' }}" href="{{ route('cashier.quick-shop') }}">
            <span class="nav-icon">⊞</span> Quick Shop
        </a>

        <a class="nav-link {{ request()->routeIs('cashier.payment') ? 'active' : '' }}" href="{{ route('cashier.payment') }}">
            <span class="nav-icon">▣</span> Payment
        </a>

 <a class="nav-link {{ request()->routeIs('cashier.receipt') ? 'active' : '' }}" href="{{ route('cashier.receipt') }}">
            <span class="nav-icon">▧</span> Receipt
        </a>
        <a class="nav-link {{ request()->routeIs('cashier.sales*') ? 'active' : '' }}" href="{{ route('cashier.sales') }}">
            <span class="nav-icon">▤</span> Sales History
        </a>

       

        <a class="nav-link {{ request()->routeIs('cashier.summary') ? 'active' : '' }}" href="{{ route('cashier.summary') }}">
            <span class="nav-icon">▥</span> Daily Summary
        </a>

        <a class="nav-link {{ request()->routeIs('cashier.notifications*') ? 'active' : '' }}" href="{{ route('cashier.notifications') }}">
            <span class="nav-icon">♢</span> Notifications
        </a>
        
        <a class="nav-link {{ request()->routeIs('cashier.profile*') ? 'active' : '' }}" href="{{ route('cashier.profile') }}">
            <span class="nav-icon">◉</span> Profile
        </a>


     
    </nav>

    <div class="sidebar-footer">
        <div class="user-mini">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'CA', 0, 2)) }}</div>
            <div>
                <strong>{{ auth()->user()->name ?? 'Cashier' }}</strong>
                <small>Point of Sale</small>
            </div>
        </div>
    </div>
</aside>
