<header class="super-admin-header">
    <div class="welcome">Espace Super Admin</div>

    <div class="header-actions">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary">🚪 Déconnexion</button>
        </form>
    </div>
</header>