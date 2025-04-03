document.addEventListener('DOMContentLoaded', function() {

    // Gestion du formulaire de connexion
    const formConnexion = document.getElementById('formConnexion');
    
    if (formConnexion) {
        // Vérification et suppression d'éventuels écouteurs d'événements existants
        const clonedForm = formConnexion.cloneNode(true);
        formConnexion.parentNode.replaceChild(clonedForm, formConnexion);
        
        // Ajout d'un nouvel écouteur d'événements
        clonedForm.addEventListener('submit', function(e) {
            // Ne pas utiliser preventDefault() ici pour permettre la soumission normale du formulaire
            
            // Désactiver le bouton pour éviter la double soumission
            const btnConnexion = document.getElementById('btnConnexion');
            if (btnConnexion) {
                btnConnexion.disabled = true;
                btnConnexion.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Connexion en cours...';
            }
            
            // Laisser le formulaire se soumettre normalement
            return true;
        });
    }
    
    // Animation de la boîte de connexion
    setTimeout(() => {
        const box = document.querySelector('.box');
        if (box) {
            box.style.opacity = '1';
            box.style.transform = 'translateY(0)';
        }
    }, 200);
    
    // PARALLAXE POUR L'IMAGE DU SLOGAN
    const slogan = document.querySelector('.slogan');
    if (slogan) {
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            const sloganPosition = slogan.offsetTop;
            const offset = scrollPosition - sloganPosition;
            
            if (offset > -500 && offset < 300) {
                const translateY = offset * 0.2;
                const sloganImg = slogan.querySelector('img');
                if (sloganImg) {
                    sloganImg.style.transform = `translateY(${translateY}px)`;
                }
            }
        });
    }
});