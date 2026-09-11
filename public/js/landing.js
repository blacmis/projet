document.addEventListener('DOMContentLoaded', function () {
    var navToggle = document.getElementById('navToggle');
    var navLinks = document.getElementById('navLinks');

    if (!navToggle || !navLinks) return;

    navToggle.addEventListener('click', function () {
        var isOpen = navLinks.classList.toggle('open');
        navToggle.setAttribute('aria-expanded', isOpen);
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 960) {
            navLinks.classList.remove('open');
            navToggle.setAttribute('aria-expanded', 'false');
        }
    });
});