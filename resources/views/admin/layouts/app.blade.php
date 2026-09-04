<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | MarketSmart')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ux-enhancements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>

    {{-- Bouton menu mobile --}}
    <button
        type="button"
        class="mobile-menu-toggle"
        aria-label="Ouvrir le menu"
        aria-expanded="false"
        data-mobile-menu-toggle
    >
        <span></span>
        <span></span>
        <span></span>
    </button>

    {{-- Fond sombre derrière le menu --}}
    <div class="mobile-menu-backdrop" data-mobile-menu-backdrop></div>

    @include('admin.partials.sidebar')

    <div class="admin-main">
        @include('admin.partials.header')

        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script src="{{ asset('js/ux-enhancements.js') }}"></script>
    <script src="{{ asset('js/mobile-menu.js') }}"></script>
</body>
</html>