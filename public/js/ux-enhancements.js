document.addEventListener('DOMContentLoaded', function () {

    
    // 1) BOUTONS : désactiver + afficher "en cours..." à la soumission
    //    Empêche les double-clics (ex: payer 2 fois)
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (form.dataset.submitting === 'true') {
                return;
            }
            form.dataset.submitting = 'true';

            const submitBtns = form.querySelectorAll('button[type="submit"], button:not([type])');
            submitBtns.forEach(function (btn) {
                btn.dataset.originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.classList.add('is-loading');
                btn.innerHTML = '<span class="btn-spinner"></span> Traitement en cours...';
            });
        });
    });

    
    // 2) RECHERCHE "EN DIRECT" : plus besoin d'appuyer sur Entrée
    const liveSearchNames = ['search', 'q', 'filter'];

    document.querySelectorAll('form').forEach(function (form) {
        if ((form.method || '').toLowerCase() !== 'get') return;

        form.querySelectorAll('input[type="text"], input:not([type])').forEach(function (input) {
            if (!liveSearchNames.includes(input.name)) return;

            let timer = null;
            input.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    form.requestSubmit ? form.requestSubmit() : form.submit();
                }, 450);
            });
        });
    });

    // 3) REDONNER LE FOCUS au champ de recherche après le rechargement
    //    (sinon l'utilisateur doit re-cliquer dessus à chaque pause)
    const params = new URLSearchParams(window.location.search);

    liveSearchNames.forEach(function (name) {
        if (!params.has(name) || !params.get(name)) return;

        const input = document.querySelector('input[name="' + name + '"]');
        if (input) {
            input.focus();
            const len = input.value.length;
            input.setSelectionRange(len, len); // curseur remis à la fin du texte
        }
    });

});