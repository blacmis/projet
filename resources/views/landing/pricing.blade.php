<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifs | MarketSmart Market</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <div class="page-hero">
        <div class="wrap">
            @include('landing.partials.header')
            <div class="section-eyebrow">TARIFS</div>
            <h1>Un tarif adapté à la taille de votre supermarché</h1>
            <p>Pas de grille figée : on discute de votre situation pour vous proposer une offre juste.</p>
        </div>
    </div>

    <section>
        <div class="wrap">
            <div class="pricing-card">
                <h3>Devis personnalisé</h3>
                <p>Le tarif dépend du nombre de comptes, du volume de produits et de vos besoins spécifiques.</p>
                <ul>
                    <li><i class="bi bi-check2"></i> Accès pour toute votre équipe (admin, gestionnaire, caissiers)</li>
                    <li><i class="bi bi-check2"></i> Toutes les fonctionnalités incluses, sans palier caché</li>
                    <li><i class="bi bi-check2"></i> Support pour la mise en place de votre espace</li>
                </ul>
                <a href="{{ route('landing.contact.show') }}" class="btn btn-primary" style="justify-content:center;">Demander un devis <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </section>

    @include('landing.partials.footer')

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>