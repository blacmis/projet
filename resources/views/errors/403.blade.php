<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>403 — Accès refusé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="text-center">
        <h1 class="display-4">403</h1>
        <p class="lead">Accès refusé. Vous n'avez pas la permission d'accéder à cette page.</p>
        <a href="{{ route('login') }}" class="btn btn-warning">Retour à la connexion</a>
    </div>
</body>
</html>