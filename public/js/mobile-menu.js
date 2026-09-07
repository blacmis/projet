/* =========================================================
   MARKETSMART - MENU MOBILE (hamburger)
   Fait fonctionner le bouton .mobile-menu-toggle et le fond
   sombre .mobile-menu-backdrop déjà présents dans les 3 layouts
   (admin, manager, cashier). Ne touche à aucune autre logique.
   ========================================================= */
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.querySelector('[data-mobile-menu-toggle]');
        var backdrop = document.querySelector('[data-mobile-menu-backdrop]');
        var body = document.body;

        if (!toggle) return;

        function closeMenu() {
            body.classList.remove('mobile-menu-open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        function openMenu() {
            body.classList.add('mobile-menu-open');
            toggle.setAttribute('aria-expanded', 'true');
        }

        toggle.addEventListener('click', function () {
            if (body.classList.contains('mobile-menu-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        if (backdrop) {
            backdrop.addEventListener('click', closeMenu);
        }

        document.querySelectorAll('.admin-sidebar a, .sidebar a').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMenu();
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 992) closeMenu();
        });
    });
})();