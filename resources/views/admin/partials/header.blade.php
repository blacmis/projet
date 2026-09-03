<header class="admin-header">
    <div class="welcome">Welcome back, admin</div>

    <div style="display:flex;align-items:center;gap:14px;">
        <form method="GET" action="{{ route('admin.search') }}" class="search-box">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="search anything">
            <button type="submit" style="border:none;background:transparent;cursor:pointer;">🔍</button>
        </form>

        <a href="{{ route('admin.notifications') }}" style="font-size:1.25rem;text-decoration:none;">🔔</a>

        <div class="dropdown">
            <button class="btn btn-light btn-sm d-flex align-items-center gap-2"
                    type="button"
                    id="adminUserMenu"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    style="border-radius:999px;padding:6px 12px;border:1px solid #e9ecef;">
                <span style="width:32px;height:32px;border-radius:50%;background:#fff3cd;display:inline-flex;align-items:center;justify-content:center;">👤</span>
                <strong style="font-size:13px;">Admin</strong>
                <span style="font-size:10px;color:#6c757d;">▼</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="adminUserMenu">
                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">👤 Mon profil</a></li>
                <li><hr class="dropdown-divider"></li>
                    <li><form method="POST" action="{{ route('logout') }}">
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