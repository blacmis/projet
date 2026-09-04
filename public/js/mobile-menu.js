document.addEventListener('DOMContentLoaded', function () {

    const menuButton = document.querySelector('[data-mobile-menu-toggle]');
    const backdrop = document.querySelector('[data-mobile-menu-backdrop]');

    const sidebar =
        document.querySelector('.admin-sidebar') ||
        document.querySelector('.app .sidebar') ||
        document.querySelector('.sidebar');

    if (!menuButton || !backdrop || !sidebar) {
        return;
    }

    function openMenu() {
        sidebar.classList.add('mobile-menu-open');
        backdrop.classList.add('mobile-menu-open');

        document.body.classList.add('mobile-menu-active');

        menuButton.setAttribute('aria-expanded', 'true');
        menuButton.setAttribute('aria-label', 'Fermer le menu');
    }

    function closeMenu() {
        sidebar.classList.remove('mobile-menu-open');
        backdrop.classList.remove('mobile-menu-open');

        document.body.classList.remove('mobile-menu-active');

        menuButton.setAttribute('aria-expanded', 'false');
        menuButton.setAttribute('aria-label', 'Ouvrir le menu');
    }

    menuButton.addEventListener('click', function () {

        if (sidebar.classList.contains('mobile-menu-open')) {
            closeMenu();
        } else {
            openMenu();
        }

    });

    backdrop.addEventListener('click', closeMenu);


    /*
     * Ferme automatiquement le menu lorsqu'un utilisateur
     * choisit une fonctionnalité.
     */
    sidebar.querySelectorAll('a.nav-link').forEach(function (link) {

        link.addEventListener('click', function () {

            if (window.innerWidth < 992) {
                closeMenu();
            }

        });

    });


    /*
     * Fermer avec la touche ESC.
     */
    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeMenu();
        }

    });


    /*
     * Si l'utilisateur tourne son téléphone ou agrandit
     * la fenêtre vers la version desktop, le menu se réinitialise.
     */
    window.addEventListener('resize', function () {

        if (window.innerWidth >= 992) {
            closeMenu();
        }

    });

});