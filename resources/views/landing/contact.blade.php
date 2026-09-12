<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | MarketSmart Market</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <div class="page-hero">
        <div class="wrap">
            @include('landing.partials.header')
            <div class="section-eyebrow">CONTACTEZ-NOUS</div>
            <h1>Parlons de votre supermarché</h1>
            <p>Laissez vos coordonnées : nous revenons vers vous pour comprendre vos besoins et mettre en place votre espace.</p>
        </div>
    </div>

    <section>
        <div class="wrap">
         <div class="contact-block">
                <div class="contact-points">
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-1-circle"></i></div>
                        <div><h4>Vous nous contactez</h4><p>Décrivez votre supermarché et vos besoins via le formulaire.</p></div>
                    </div>
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-2-circle"></i></div>
                        <div><h4>On configure votre espace</h4><p>Votre supermarché reçoit un espace vide, propre à vous, prêt à être rempli.</p></div>
                    </div>
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-3-circle"></i></div>
                        <div><h4>Vous démarrez</h4><p>Créez vos comptes équipe, vos produits, et gérez votre activité au quotidien.</p></div>
                    </div>
                    <div class="contact-point">
                        <div class="cp-icon"><i class="bi bi-whatsapp"></i></div>
                        <div><h4>Une question rapide ?</h4><p>Écrivez-nous directement au <a href="https://wa.me/237687092956" target="_blank" rel="noopener">+237 687 09 29 56</a> sur WhatsApp.</p></div>
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

                    <form method="POST" action="{{ route('landing.contact') }}">
                        @csrf
                        <div class="form-row">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Votre nom" required>
                        </div>
                        <div class="form-row">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" required>
                        </div>
                        <div class="form-row">
                            <label for="phone">Téléphone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+237 6X XX XX XX">
                        </div>
                        <div class="form-row">
                            <label for="market_name">Nom du supermarché</label>
                            <input type="text" id="market_name" name="market_name" value="{{ old('market_name') }}">
                        </div>
                        <div class="form-row">
                            <label for="message">Votre besoin</label>
                            <textarea id="message" name="message" placeholder="Dites-nous en plus sur votre projet...">{{ old('message') }}</textarea>
                        </div>
                            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Envoyer ma demande <i class="bi bi-send"></i></button>
                    </form>
                </div>
            </div>   
        </div>
    </section>

    @include('landing.partials.footer')

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>