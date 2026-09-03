<header class="topbar">
    <div class="page-title">
        <h1>@yield('page-title', 'Paiement')</h1>
        <p>@yield('page-subtitle', 'Portail de caisse MarketSmart')</p>
    </div>
    <div class="top-actions">
        <a href="{{ route('cashier.notifications') }}" class="icon-btn notification-dot" title="Notifications">🔔</a>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center"
                    style="width:32px;height:32px;font-size:14px;">
                    C
                </span>
                <span class="d-none d-md-inline">Cashier</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="{{ route('cashier.profile') }}">
                        👤 Mon profil
                    </a>
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
    </div>
</header>