document.addEventListener('DOMContentLoaded', function () {


    // 1) BOUTONS : désactiver + afficher "en cours..." à la soumission
    //    Empêche les double-clics (ex: payer 2 fois)
    //    + Message clair si le serveur ne répond pas après 15 secondes
        document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (form.dataset.submitting === 'true') {
                return;
            }
            form.dataset.submitting = 'true';

            // Si plusieurs boutons du même formulaire portent chacun un nom/valeur
            // différent (ex: plusieurs choix possibles), on préserve la valeur de
            // celui qui a été cliqué AVANT de le désactiver — sinon certains
            // navigateurs l'excluent silencieusement de l'envoi.
            var submitter = event.submitter;
            if (submitter && submitter.name) {
                var preserved = document.createElement('input');
                preserved.type = 'hidden';
                preserved.name = submitter.name;
                preserved.value = submitter.value;
                form.appendChild(preserved);
            }

            const submitBtns = form.querySelectorAll('button[type="submit"], button:not([type])');
            submitBtns.forEach(function (btn) {
                btn.dataset.originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.classList.add('is-loading');
                btn.innerHTML = '<span class="btn-spinner"></span> Traitement en cours...';
            });

            setTimeout(function () {
                if (form.dataset.submitting !== 'true') {
                    return;
                }

                form.dataset.submitting = 'false';

                submitBtns.forEach(function (btn) {
                    btn.disabled = false;
                    btn.classList.remove('is-loading');
                    if (btn.dataset.originalHtml) {
                        btn.innerHTML = btn.dataset.originalHtml;
                    }
                });

                let warning = form.querySelector('.ux-network-warning');
                if (!warning) {
                    warning = document.createElement('div');
                    warning.className = 'ux-network-warning';
                    form.prepend(warning);
                }
                warning.textContent = 'La connexion semble lente ou interrompue. Vérifiez votre réseau et réessayez.';
            }, 15000);
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


    // 4) AFFICHER / MASQUER LES MOTS DE PASSE
    //    Ajoute automatiquement une icône œil à TOUT champ type="password"
    //    trouvé sur la page, sans avoir à modifier chaque formulaire.
    document.querySelectorAll('input[type="password"]').forEach(function (input) {
        if (input.dataset.uxPasswordToggle === 'true') return;

        const wrap = document.createElement('div');
        wrap.className = 'ux-password-wrap';
        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'ux-password-toggle';
        btn.setAttribute('aria-label', 'Afficher le mot de passe');
        btn.innerHTML = '<i class="bi bi-eye"></i>';

        btn.addEventListener('click', function () {
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = '<i class="bi bi-eye-slash"></i>';
                btn.setAttribute('aria-label', 'Masquer le mot de passe');
            } else {
                input.type = 'password';
                btn.innerHTML = '<i class="bi bi-eye"></i>';
                btn.setAttribute('aria-label', 'Afficher le mot de passe');
            }
        });

        wrap.appendChild(btn);
        input.dataset.uxPasswordToggle = 'true';
    });

});