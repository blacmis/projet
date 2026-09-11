<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer mon espace | MarketSmart Market</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
        <link rel="stylesheet" href="{{ asset('css/ux-enhancements.css') }}">
</head>
<body>

    <div class="page-hero">
        <div class="wrap">
            @include('landing.partials.header')
            <div class="section-eyebrow">CRÉER MON ESPACE</div>
            <h1>Votre supermarché sur MarketSmart Market</h1>
            <p>Créez votre espace en quelques minutes. Votre accès sera activé après une courte validation de notre part.</p>
        </div>
    </div>

    <section>
        <div class="wrap">
            <div class="contact-block">
                <div class="contact-points">
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-1-circle"></i></div>
                        <div><h4>Vous créez votre espace</h4><p>Remplissez ce formulaire avec les informations de votre supermarché.</p></div>
                    </div>
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-2-circle"></i></div>
                        <div><h4>Nous validons votre demande</h4><p>Un rapide échange pour confirmer votre inscription et activer votre accès.</p></div>
                    </div>
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-3-circle"></i></div>
                        <div><h4>Vous vous connectez</h4><p>Une fois validé, connectez-vous avec l'email et le mot de passe choisis ici.</p></div>
                    </div>
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-question-circle"></i></div>
                        <div><h4>Une question avant de vous lancer ?</h4><p><a href="{{ route('landing.contact.show') }}">Contactez-nous</a> plutôt, ou écrivez sur <a href="https://wa.me/237687092956" target="_blank" rel="noopener">WhatsApp</a>.</p></div>
                    </div>
                </div>

                <div class="contact-form">
                    @if(session('success'))
                        <div class="alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert-errors">
                            @foreach($errors->all() as $e)
                                <div>{{ $e }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('landing.register') }}">
                        @csrf
                        <div class="form-row">
                            <label for="market_name">Nom du supermarché</label>
                            <input type="text" id="market_name" name="market_name" value="{{ old('market_name') }}" placeholder="Ex: Supermarché Herique" required>
                        </div>
                        <div class="form-row">
                            <label for="sector">Secteur d'activité</label>
                            <input type="text" id="sector" name="sector" value="{{ old('sector') }}" placeholder="Alimentaire, Téléphonie, ...">
                        </div>
                        <div class="form-row">
                            <label for="owner_name">Votre nom</label>
                            <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" placeholder="Votre nom complet" required>
                        </div>
                        <div class="form-row">
                            <label for="owner_email">Votre email</label>
                            <input type="email" id="owner_email" name="owner_email" value="{{ old('owner_email') }}" placeholder="votre@email.com" required>
                        </div>
                        <div class="form-row">
                            <label for="owner_phone">Votre téléphone</label>
                            <input type="text" id="owner_phone" name="owner_phone" value="{{ old('owner_phone') }}" placeholder="+237 6X XX XX XX">
                        </div>
                        <div class="form-row">
                            <label for="password">Mot de passe</label>
                            <input type="password" id="password" name="password" placeholder="Au moins 6 caractères" required minlength="6">
                        </div>
                        <div class="form-row">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Retapez le mot de passe" required minlength="6">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Créer mon espace <i class="bi bi-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('landing.partials.footer')

    <script src="{{ asset('js/landing.js') }}"></script>
        <script src="{{ asset('js/ux-enhancements.js') }}"></script>
</body>
</html>