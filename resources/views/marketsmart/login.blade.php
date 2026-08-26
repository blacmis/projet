<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | MarketSmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .logo-wrap {
            text-align: center;
            margin-bottom: 24px;
        }
        .logo-wrap img {
            max-width: 220px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .login-card h2 {
            text-align: center;
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 14px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #c47a1a;
            box-shadow: 0 0 0 0.2rem rgba(196, 122, 26, 0.2);
        }
        .btn-login {
            width: 100%;
            background: #c47a1a;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            margin-top: 8px;
        }
        .btn-login:hover {
            background: #a86515;
            color: #fff;
        }
        .forgot-link {
            text-align: center;
            margin-top: 18px;
        }
        .forgot-link a {
            color: #c47a1a;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .forgot-link a:hover { text-decoration: underline; }
        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo-wrap">
            <img src="{{ asset('image/marketlogo.png') }}" alt="MarketSmart">
        </div>

        <h2>SIGN IN</h2>

        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif
        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger py-2">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       placeholder="Enter email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email">
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       placeholder="Enter password"
                       required
                       autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-login">Login</button>
        </form>

        <div class="forgot-link">
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>
    </div>
</body>
</html>