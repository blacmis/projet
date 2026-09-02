<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification OTP — MarketSmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f0e8;
            font-family: system-ui, sans-serif;
        }
        .otp-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
        }
        .btn-otp {
            background: #c47a1a;
            color: #fff;
            border: none;
            width: 100%;
            padding: .7rem;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-otp:hover { background: #a36212; color: #fff; }
        .brand { color: #c47a1a; font-weight: 700; }
    </style>
</head>
<body>
<div class="otp-card">
    <div class="text-center mb-3">
        <div class="brand fs-4">MarketSmart</div>
        <small class="text-muted">Vérification en 2 étapes</small>
    </div>

    <p class="text-center text-muted small">
        Un code a été envoyé à<br>
        <strong>{{ $email }}</strong>
    </p>

    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    {{-- Affiché seulement en mode démo --}}
    @if(session('dev_otp'))
        <div class="alert alert-warning py-2">
            Code démo : <strong>{{ session('dev_otp') }}</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('login.otp.verify') }}">
        @csrf
        <label class="form-label">Code OTP (6 chiffres)</label>
        <input type="text"
               name="otp"
               class="form-control form-control-lg text-center"
               maxlength="6"
               pattern="[0-9]{6}"
               inputmode="numeric"
               autocomplete="one-time-code"
               required
               autofocus>
        <button type="submit" class="btn btn-otp mt-3">Vérifier</button>
    </form>

    <form method="POST" action="{{ route('login.otp.resend') }}" class="mt-2 text-center">
        @csrf
        <button type="submit" class="btn btn-link btn-sm">Renvoyer le code</button>
    </form>

    <div class="text-center mt-2">
        <a href="{{ route('login') }}" class="small text-muted">← Retour au login</a>
    </div>
</div>
</body>
</html>