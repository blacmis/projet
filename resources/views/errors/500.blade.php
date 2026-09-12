<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Une erreur est survenue | MarketSmart Market</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #fff3d9 0%, #fff 55%);
            font-family: 'Manrope', sans-serif; color: #1f2937; padding: 20px;
        }
        .card {
            width: 100%; max-width: 460px; background: #fff; border-radius: 18px;
            box-shadow: 0 20px 50px rgba(31,41,55,.1); padding: 44px 36px; text-align: center;
        }
        .icon {
            width: 64px; height: 64px; border-radius: 50%; background: #fff3d9; color: #c47a1a;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 22px; font-size: 1.8rem;
        }
        h1 { font-size: 1.3rem; margin: 0 0 12px; }
        p { color: #6b7280; font-size: 0.94rem; margin: 0 0 26px; line-height: 1.55; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px; padding: 12px 26px; border-radius: 999px;
            background: #f0a500; color: #fff; font-weight: 700; text-decoration: none; font-size: 0.92rem;
        }
        .btn:hover { background: #c47a1a; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon"><i class="bi bi-exclamation-triangle"></i></div>
        <h1>Une erreur est survenue de notre côté</h1>
        <p>Ce n'est pas de votre faute — quelque chose s'est mal passé sur notre plateforme. Réessayez dans quelques instants, ou revenez à l'accueil.</p>
        <a href="{{ route('landing') }}" class="btn"><i class="bi bi-house"></i> Retour à l'accueil</a>
    </div>
</body>
</html>