<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MarketSmart Cashier')</title>
    <link rel="stylesheet" href="{{ asset('css/cashier.css') }}">
   
</head>
<body>
<div class="app">
    @include('cashier.partials.sidebar')
    <main class="main">
        @include('cashier.partials.header')

        <section class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </section>
    </main>
</div>

<script src="{{ asset('js/cashier.js') }}"></script>
@stack('scripts')
</body>
</html>
