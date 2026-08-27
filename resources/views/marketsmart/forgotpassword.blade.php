<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | MarketSmart</title>
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
            font-size: 1.35rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        .subtitle {
            text-align: center;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 24px;
            line-height: 1.4;
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
        .back-link {
            text-align: center;
            margin-top: 18px;
        }
        .back-link a {
            color: #c47a1a;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .back-link a:hover { text-decoration: underline; }
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

        <h2>RESET PASSWORD</h2>
        <p class="subtitle">
            Entrez votre email. Un code OTP à 6 chiffres vous sera envoyé.
        </p>

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
    <label class="form-label" for="password">New Password</label>
    <div class="position-relative">
            <input type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Min. 8 characters"
                required
                minlength="8"
                autocomplete="new-password"
                style="padding-right: 42px;">
            <button type="button"
                    class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3 toggle-password"
                    data-target="password"
                    style="text-decoration:none;color:#666;border:none;background:transparent;z-index:2;"
                    aria-label="Afficher le mot de passe">
                <span class="eye-icon">👁️</span>
            </button>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <div class="position-relative">
            <input type="password"
                class="form-control"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Confirm password"
                required
                minlength="8"
                autocomplete="new-password"
                style="padding-right: 42px;">
            <button type="button"
                    class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3 toggle-password"
                    data-target="password_confirmation"
                    style="text-decoration:none;color:#666;border:none;background:transparent;z-index:2;"
                    aria-label="Afficher le mot de passe">
                <span class="eye-icon">👁️</span>
            </button>
        </div>
    </div>
            <button type="submit" class="btn btn-login">Send OTP</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
    <script>
    document.querySelectorAll('.toggle-password').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.getAttribute('data-target'));
            const icon = this.querySelector('.eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'XX';
                this.setAttribute('aria-label', 'Masquer le mot de passe');
            } else {
                input.type = 'password';
                icon.textContent = '(O)';
                this.setAttribute('aria-label', 'Afficher le mot de passe');
            }
        });
    });
    </script>
</body>
</html>