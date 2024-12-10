document.addEventListener('DOMContentLoaded', () => {
    const themeToggleBtn = document.getElementById('theme-toggle-btn');
    const icon = document.getElementById('icon');
    const body = document.body;
    const themeDivs = document.querySelectorAll('.theme-div'); // Sélectionne tous les divs avec la classe "theme-div"
    const customElement = document.getElementById('custom-element');
    const logoutBtn = document.querySelector('input[value="Se déconnecter"]');
    const deleteBtns = document.querySelectorAll('input[value="Supprimer"]');
    const formContainer = document.querySelector('form'); // Sélectionne le formulaire directement

    // Appliquez l'état de thème stocké, si disponible
    if (localStorage.getItem('theme') === 'dark') {
        // Passer en mode sombre
        body.classList.remove('bg-info-subtle', 'text-light-mode');
        body.classList.add('bg-dark', 'text-dark-mode');
        
        // Changer la classe de fond du div
        if (customElement) {
            customElement.classList.remove('bg-white');
            customElement.classList.add('bg-danger');
        }
        
        if (formContainer) {
            formContainer.classList.remove('bg-white');
            formContainer.classList.add('bg-danger');
        }

        // Changer la classe de fond des divs
        themeDivs.forEach(div => {
            div.classList.remove('bg-white');
            div.classList.add('bg-danger');
        });

        // Modifier le bouton "Se déconnecter"
        if (logoutBtn) {
            logoutBtn.classList.remove('btn-dark');
            logoutBtn.classList.add('btn-danger');
        }

        // Modifier le bouton "Supprimer"
        deleteBtns.forEach(btn => {
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-dark');
        });

        // Changer l'icône
        icon.textContent = '☀️';

    } else {
         // Revenir en mode clair
         body.classList.remove('bg-dark', 'text-dark-mode');
         body.classList.add('bg-info-subtle', 'text-light-mode');

         // Remettre la classe de fond du div à blanc
         if (customElement) {
             customElement.classList.remove('bg-danger');
             customElement.classList.add('bg-white');
         }

         if (formContainer) {
             formContainer.classList.remove('bg-danger');
             formContainer.classList.add('bg-white');
         }

         // Remettre la classe de fond des divs à blanc
         themeDivs.forEach(div => {
             div.classList.remove('bg-danger');
             div.classList.add('bg-white');
         });

         // Modifier le bouton "Se déconnecter"
         if (logoutBtn) {
             logoutBtn.classList.remove('btn-danger');
             logoutBtn.classList.add('btn-dark');
         }

         // Modifier le bouton "Supprimer"
         deleteBtns.forEach(btn => {
             btn.classList.remove('btn-dark');
             btn.classList.add('btn-danger');
         });

         // Changer l'icône
         icon.textContent = '🌙';

         // Enregistrer le mode clair dans le stockage local
         localStorage.setItem('theme', 'light');
    }

    themeToggleBtn.addEventListener('click', () => {
        if (body.classList.contains('bg-info-subtle')) {
            // Passer en mode sombre
            body.classList.remove('bg-info-subtle', 'text-light-mode');
            body.classList.add('bg-dark', 'text-dark-mode');
            
            // Changer la classe de fond du div
            if (customElement) {
                customElement.classList.remove('bg-white');
                customElement.classList.add('bg-danger');
            }
            
            if (formContainer) {
                formContainer.classList.remove('bg-white');
                formContainer.classList.add('bg-danger');
            }

            // Changer la classe de fond des divs
            themeDivs.forEach(div => {
                div.classList.remove('bg-white');
                div.classList.add('bg-danger');
            });

            // Modifier le bouton "Se déconnecter"
            if (logoutBtn) {
                logoutBtn.classList.remove('btn-dark');
                logoutBtn.classList.add('btn-danger');
            }

            // Modifier le bouton "Supprimer"
            deleteBtns.forEach(btn => {
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-dark');
            });

            // Changer l'icône
            icon.textContent = '☀️';

            // Enregistrer le mode sombre dans le stockage local
            localStorage.setItem('theme', 'dark');
        } else {
            // Revenir en mode clair
            body.classList.remove('bg-dark', 'text-dark-mode');
            body.classList.add('bg-info-subtle', 'text-light-mode');

            // Remettre la classe de fond du div à blanc
            if (customElement) {
                customElement.classList.remove('bg-danger');
                customElement.classList.add('bg-white');
            }

            if (formContainer) {
                formContainer.classList.remove('bg-danger');
                formContainer.classList.add('bg-white');
            }

            // Remettre la classe de fond des divs à blanc
            themeDivs.forEach(div => {
                div.classList.remove('bg-danger');
                div.classList.add('bg-white');
            });

            // Modifier le bouton "Se déconnecter"
            if (logoutBtn) {
                logoutBtn.classList.remove('btn-danger');
                logoutBtn.classList.add('btn-dark');
            }

            // Modifier le bouton "Supprimer"
            deleteBtns.forEach(btn => {
                btn.classList.remove('btn-dark');
                btn.classList.add('btn-danger');
            });

            // Changer l'icône
            icon.textContent = '🌙';

            // Enregistrer le mode clair dans le stockage local
            localStorage.setItem('theme', 'light');
        }
    });
});
