<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir un supermarché | MarketSmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ux-enhancements.css') }}">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff8f0 0%, #f5f5f5 100%);
            font-family: system-ui, -apple-system, sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,.08);
            padding: 40px 36px;
            margin: 20px;
        }
        .logo-wrap { text-align: center; margin-bottom: 24px; }
        .logo-wrap img { max-width: 220px; height: auto; display: block; margin: 0 auto; }
        .login-card h2 {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        .login-card p {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 24px;
        }
        .tenant-choice-btn {
            width: 100%;
            background: #fff;
            border: 1px solid #ddd;
            color: #1a1a1a;
            font-weight: 600;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 12px;
            text-align: left;
            transition: border-color .15s ease, background .15s ease;
        }
        .tenant-choice-btn:hover {
            border-color: #c47a1a;
            background: #fff8f0;
        }
        .tenant-choice-btn .role-badge {
            display: block;
            font-size: 0.78rem;
            font-weight: 500;
            color: #c47a1a;
            margin-top: 2px;
        }
        .alert { border-radius: 8px; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-wrap">
            <img src="{{ asset('image/marketlogo.png') }}" alt="MarketSmart">
        </div>

        <h2>Choisissez votre supermarché</h2>
        <p>{{ $email }} est associé à plusieurs supermarchés.</p>

        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger py-2">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.choose-tenant.submit') }}">
            @csrf
            @foreach($accounts as $account)
                <button type="submit" name="user_id" value="{{ $account->id }}" class="tenant-choice-btn">
                    {{ $account->tenant->name ?? 'Super Admin' }}
                    <span class="role-badge">{{ ucfirst($account->role) }}</span>
                </button>
            @endforeach
        </form>
    </div>
    <script src="{{ asset('js/ux-enhancements.js') }}"></script>
</body>
</html>