<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fonctionnalités | MarketSmart Market</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <div class="page-hero">
        <div class="wrap">
            @include('landing.partials.header')
            <div class="section-eyebrow">NOS FONCTIONNALITÉS</div>
            <h1>Tout ce dont vous avez besoin, au même endroit</h1>
            <p>Construite pour la réalité d'un supermarché, pas une liste de fonctionnalités génériques.</p>
        </div>
    </div>

    <section>
        <div class="wrap">
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-box-seam"></i></div>
                    <h4>Gestion de stock</h4>
                    <p>Entrées, sorties, ajustements et alertes automatiques dès qu'un produit passe sous son seuil minimum.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-cash-coin"></i></div>
                    <h4>Caisse intégrée</h4>
                    <p>Encaissement rapide, plusieurs modes de paiement, ouverture et fermeture de caisse avec calcul d'écart.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-clipboard-data"></i></div>
                    <h4>Rapports & analyses</h4>
                    <p>Ventes, stock, péremption et revenus — exportables, sans tableur à construire à la main.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-people"></i></div>
                    <h4>Multi-rôles</h4>
                    <p>Administrateur, gestionnaire de stock, caissier : chacun a son espace et ses permissions propres.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-shield-lock"></i></div>
                    <h4>Sécurité renforcée</h4>
                    <p>Mot de passe et code de vérification à chaque connexion, comptes verrouillés après plusieurs échecs.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="bi bi-phone"></i></div>
                    <h4>Accessible partout</h4>
                    <p>La caisse, le stock et les rapports s'utilisent aussi bien sur téléphone qu'à l'ordinateur.</p>
                </div>
            </div>
                        <div class="mockup-mini" style="margin-top:50px;">
                <div class="browser-card">
                    <div class="browser-bar"><span></span><span></span><span></span></div>
                    <div class="mock-body">
                        <div class="mock-sidebar">
                            <div class="active-icon"><i class="bi bi-speedometer2"></i></div>
                            <i class="bi bi-box-seam"></i>
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <div class="mock-main">
                            <div class="mock-title">Aperçu de l'interface</div>
                            <div class="mock-cards">
                                <div class="mock-card"><div class="m-val">142</div><div class="m-lbl">Produits</div></div>
                                <div class="mock-card"><div class="m-val">34</div><div class="m-lbl">Ventes</div></div>
                                <div class="mock-card"><div class="m-val">6</div><div class="m-lbl">Stock faible</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('landing.partials.footer')

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>