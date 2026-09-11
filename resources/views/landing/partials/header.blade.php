<header class="site-header wrap">
    <a href="{{ route('landing') }}" class="brand">
        <div class="logo-circle">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2.3 2.3c-.4.4-.1 1.1.4 1.1H17M17 13v6a1 1 0 01-1 1H8a1 1 0 01-1-1v-6"
                      stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="9" cy="20" r="1" fill="#fff"/>
                <circle cx="16" cy="20" r="1" fill="#fff"/>
            </svg>
        </div>
        <div>
            <div class="brand-name">Market<span>Smart</span></div>
            <div class="brand-sub">MARKET</div>
        </div>
    </a>
    <nav class="site-nav">
        <button type="button" class="nav-toggle" id="navToggle" aria-label="Ouvrir le menu" aria-expanded="false">
            <i class="bi bi-list"></i>
        </button>
        <div class="nav-links" id="navLinks">
            <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('landing.features') }}" class="{{ request()->routeIs('landing.features') ? 'active' : '' }}">Fonctionnalités</a>
            <a href="{{ route('landing.advantages') }}" class="{{ request()->routeIs('landing.advantages') ? 'active' : '' }}">Avantages</a>
            <a href="{{ route('landing.pricing') }}" class="{{ request()->routeIs('landing.pricing') ? 'active' : '' }}">Tarifs</a>
            <a href="{{ route('landing.contact.show') }}" class="{{ request()->routeIs('landing.contact.show') ? 'active' : '' }}">Contact</a>
            <a href="{{ route('login') }}" class="btn btn-login nav-login-mobile">
            <i class="bi bi-box-arrow-in-right"></i> Se connecter</a>
        </div>
        <a href="{{ route('login') }}" class="btn btn-login header-login-desktop">Se connecter</a>
    </nav>
</header>