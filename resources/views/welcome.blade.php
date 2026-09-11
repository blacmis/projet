<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketSmart Market — Simplifiez la gestion de votre supermarché</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <div class="hero-section">
        <div class="hero-glow"></div>
        <div class="wrap">
            @include('landing.partials.header')

            <div class="hero">
                <div class="hero-copy">
                    <div class="eyebrow"><i class="bi bi-stars"></i> La solution tout-en-un pour votre supermarché</div>
                    <h1>Simplifiez la gestion de votre supermarché, <span class="accent">du rayon à la caisse</span></h1>
                    <p class="lede">
                        Stock, ventes, caisses et équipe dans un seul système. Chaque supermarché dispose de son
                        propre espace, entièrement privé : vos données ne sont jamais mélangées avec celles
                        d'un autre commerce.
                    </p>
                    <div class="actions">
                        <a href="{{ route('landing.register.show') }}" class="btn btn-primary">Demander un accès <i class="bi bi-arrow-right"></i></a>                        
                        <a href="{{ route('landing.features') }}" class="btn btn-ghost"><i class="bi bi-play-circle"></i> Voir ce qu'elle fait</a>
                    </div>
                    <ul class="trust-list">
                        <li><i class="bi bi-check-circle-fill"></i> Connexion sécurisée par code</li>
                        <li><i class="bi bi-check-circle-fill"></i> Utilisable sur mobile</li>
                        <li><i class="bi bi-check-circle-fill"></i> Journal d'audit complet</li>
                    </ul>
                </div>

                <div class="mockup-wrap">
                    <div class="browser-card">
                        <div class="browser-bar"><span></span><span></span><span></span></div>
                        <div class="mock-body">
                            <div class="mock-sidebar">
                                <div class="active-icon"><i class="bi bi-speedometer2"></i></div>
                                <i class="bi bi-box-seam"></i>
                                <i class="bi bi-cart-check"></i>
                                <i class="bi bi-people"></i>
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="mock-main">
                                <div class="mock-title">Tableau de bord</div>
                                <div class="mock-cards">
                                    <div class="mock-card"><div class="m-val">142</div><div class="m-lbl">Produits</div></div>
                                    <div class="mock-card"><div class="m-val">34</div><div class="m-lbl">Ventes / jour</div></div>
                                    <div class="mock-card"><div class="m-val">6</div><div class="m-lbl">Stock faible</div></div>
                                </div>
                                <div class="mock-bars">
                                    <i style="height:40%"></i><i style="height:65%"></i><i style="height:50%"></i>
                                    <i style="height:80%"></i><i style="height:60%"></i><i style="height:90%"></i><i style="height:70%"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="float-card f1">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Caisse équilibrée<small>Écart 0 FCFA</small></span>
                    </div>
                    <div class="float-card f2">
                        <i class="bi bi-bell-fill"></i>
                        <span>Alerte stock<small>Envoyée automatiquement</small></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="wrap">
            <div class="isolation-card">
                <div>
                    <h2>Un espace privé pour chaque supermarché</h2>
                    <p>Que vous gériez une épicerie ou une boutique de téléphonie, votre espace vous appartient : vos produits, vos ventes et votre équipe ne sont jamais visibles par un autre supermarché de la plateforme.</p>
                </div>
                <div class="stall-row">
                    <div class="stall"><div class="s-dot"><i class="bi bi-shop"></i></div>Supermarché A<span>Son propre stock</span></div>
                    <div class="stall"><div class="s-dot"><i class="bi bi-shop"></i></div>Supermarché B<span>Sa propre équipe</span></div>
                    <div class="stall"><div class="s-dot"><i class="bi bi-shop"></i></div>Supermarché C<span>Ses propres ventes</span></div>
                </div>
            </div>

            <div class="quick-links">
                <a href="{{ route('landing.features') }}" class="quick-link">
                    <div class="ql-icon"><i class="bi bi-grid-1x2"></i></div>
                    <div><h4>Fonctionnalités</h4><p>Tout ce que la plateforme fait au quotidien</p></div>
                </a>
                <a href="{{ route('landing.advantages') }}" class="quick-link">
                    <div class="ql-icon"><i class="bi bi-people"></i></div>
                    <div><h4>Avantages par rôle</h4><p>Un espace pour chaque membre de l'équipe</p></div>
                </a>
                <a href="{{ route('landing.contact.show') }}" class="quick-link">
                    <div class="ql-icon"><i class="bi bi-envelope"></i></div>
                    <div><h4>Nous contacter</h4><p>Demandez votre accès en quelques minutes</p></div>
                </a>
            </div>
        </div>
    </section>

    @include('landing.partials.footer')

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>