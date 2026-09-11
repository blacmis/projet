<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avantages | MarketSmart Market</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <div class="page-hero">
        <div class="wrap">
            @include('landing.partials.header')
            <div class="section-eyebrow">UN RÔLE POUR CHAQUE PERSONNE</div>
            <h1>Pas un compte partagé pour tous</h1>
            <p>Chaque membre de l'équipe se connecte avec son propre accès, limité à ce qu'il doit réellement faire.</p>
        </div>
    </div>

    <section class="roles-section">
        <div class="wrap">
            <div class="role-tabs">
                <button type="button" class="role-tab active" data-role="admin">Administrateur</button>
                <button type="button" class="role-tab" data-role="manager">Gestionnaire de stock</button>
                <button type="button" class="role-tab" data-role="cashier">Caissier</button>
            </div>

            <div class="role-panel active" data-role-panel="admin">
                <div>
                    <div class="role-headline">Administrateur</div>
                    <div class="role-benefit">Une vue d'ensemble claire, sans avoir à tout centraliser à la main.</div>
                    <ul>
                        <li><i class="bi bi-check2"></i> Crée et gère les comptes de l'équipe</li>
                        <li><i class="bi bi-check2"></i> Consulte les rapports de ventes et de stock</li>
                        <li><i class="bi bi-check2"></i> Journal complet de toutes les actions</li>
                        <li><i class="bi bi-check2"></i> Paramètres du supermarché</li>
                    </ul>
                </div>
                <div class="role-panel-visual"><i class="bi bi-person-badge"></i></div>
            </div>

            <div class="role-panel" data-role-panel="manager">
                <div>
                    <div class="role-headline">Gestionnaire de stock</div>
                    <div class="role-benefit">Plus jamais surpris par une rupture de stock.</div>
                    <ul>
                        <li><i class="bi bi-check2"></i> Entrées et sorties de stock</li>
                        <li><i class="bi bi-check2"></i> Alertes automatiques sur stock faible</li>
                        <li><i class="bi bi-check2"></i> Suivi des produits périmés</li>
                        <li><i class="bi bi-check2"></i> Fournisseurs et catégories</li>
                    </ul>
                </div>
                <div class="role-panel-visual"><i class="bi bi-box-seam"></i></div>
            </div>

            <div class="role-panel" data-role-panel="cashier">
                <div>
                    <div class="role-headline">Caissier</div>
                    <div class="role-benefit">Zéro erreur de caisse, grâce à une interface tactile et ultra-rapide.</div>
                    <ul>
                        <li><i class="bi bi-check2"></i> Encaissement rapide, plusieurs modes de paiement</li>
                        <li><i class="bi bi-check2"></i> Ouverture/fermeture de caisse avec calcul d'écart</li>
                        <li><i class="bi bi-check2"></i> Reçus et historique des ventes</li>
                        <li><i class="bi bi-check2"></i> Résumé quotidien de son activité</li>
                    </ul>
                </div>
                <div class="role-panel-visual"><i class="bi bi-cash-coin"></i></div>
            </div>
        </div>
    </section>

    @include('landing.partials.footer')

    <script src="{{ asset('js/landing.js') }}"></script>
    <script>
        document.querySelectorAll('.role-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                var role = this.getAttribute('data-role');
                document.querySelectorAll('.role-tab').forEach(function (t) { t.classList.remove('active'); });
                document.querySelectorAll('.role-panel').forEach(function (p) { p.classList.remove('active'); });
                this.classList.add('active');
                document.querySelector('[data-role-panel="' + role + '"]').classList.add('active');
            });
        });
    </script>
</body>
</html>