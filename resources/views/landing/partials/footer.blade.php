<footer>
    <div class="wrap">
        <div class="footer-grid">
            <div class="footer-col">
                <h5>MarketSmart Market</h5>
                <p>La solution tout-en-un pour gérer votre supermarché : stock, caisse, équipe et rapports, dans un espace entièrement privé.</p>
                <div class="social-row">
                    <a href="https://wa.me/237687092956" target="_blank" rel="noopener" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    {{-- ⚠️ Lien Facebook en attente : remplace le # par l'URL de ta page --}}
                    <a href="#" target="_blank" rel="noopener" title="Facebook"><i class="bi bi-facebook"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h5>Liens rapides</h5>
                <ul>
                    <li><a href="{{ route('landing') }}">Accueil</a></li>
                    <li><a href="{{ route('landing.features') }}">Fonctionnalités</a></li>
                    <li><a href="{{ route('landing.advantages') }}">Avantages</a></li>
                    <li><a href="{{ route('landing.pricing') }}">Tarifs</a></li>
                    <li><a href="{{ route('landing.contact.show') }}">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Contact</h5>
                {{-- ⚠️ Email en attente --}}
                                <div class="footer-contact-item"><i class="bi bi-envelope"></i> <a href="mailto:kuekamjeams@gmail.com">kuekamjeams@gmail.com</a></div>
                <div class="footer-contact-item"><i class="bi bi-whatsapp"></i> <a href="https://wa.me/237687092956">+237 687 09 29 56</a></div>
            </div>

            <div class="footer-col">
                <h5>Légal</h5>
                <ul>
                    <li><span style="color:#8b929c;">Conditions d'utilisation</span></li>
                    <li><span style="color:#8b929c;">Politique de confidentialité</span></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="f-brand">
                <div class="logo-circle" style="width:28px;height:28px;">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;">
                        <path d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2.3 2.3c-.4.4-.1 1.1.4 1.1H17M17 13v6a1 1 0 01-1 1H8a1 1 0 01-1-1v-6"
                              stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                MarketSmart Market
            </div>
            <small>© {{ date('Y') }} MarketSmart Market. Tous droits réservés.</small>
        </div>
    </div>
</footer>