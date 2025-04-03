/**
 * JavaScript pour la gestion des offres
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Gestion du formulaire d'ajout/modification
    const formContainer = document.getElementById('offreForm');
    const formTitle = document.getElementById('formTitle');
    const idInput = document.getElementById('id_offre');
    const titreInput = document.getElementById('titre');
    const descriptionInput = document.getElementById('description');
    const remunerationInput = document.getElementById('remuneration');
    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');
    const nomEntrepriseInput = document.getElementById('nom_entreprise');
    const emailContactInput = document.getElementById('email_contact');
    const telephoneContactInput = document.getElementById('telephone_contact');
    const adresseInput = document.getElementById('adresse');
    
    // Animation lors du défilement
    window.addEventListener('scroll', function() {
        const scrollY = window.scrollY;
        
        // Ajout d'une classe pour l'effet de scroll sur les cartes d'offres
        const offreCards = document.querySelectorAll('.offre-card');
        offreCards.forEach(card => {
            const cardTop = card.getBoundingClientRect().top;
            if (cardTop < window.innerHeight - 100) {
                card.classList.add('visible');
            }
        });
        
        // Animation du header (si présent)
        const header = document.querySelector('header');
        if (header) {
            if (scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });
    
    // Fonction pour afficher/masquer le formulaire
    window.toggleForm = function() {
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
            // Animation d'apparition
            formContainer.style.opacity = '0';
            formContainer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                formContainer.style.opacity = '1';
                formContainer.style.transform = 'translateY(0)';
            }, 10);
        } else {
            // Animation de disparition
            formContainer.style.opacity = '0';
            formContainer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                formContainer.style.display = 'none';
            }, 300);
        }
    };
    
    // Fonction pour éditer une offre
    window.editOffre = function(id, titre, description, remuneration, dateDebut, dateFin, nomEntreprise, emailContact, telephoneContact, adresse) {
        // Mettre à jour le titre du formulaire
        formTitle.textContent = 'Modifier une offre';
        
        // Remplir le formulaire avec les données de l'offre
        idInput.value = id;
        titreInput.value = titre;
        descriptionInput.value = description;
        remunerationInput.value = remuneration;
        
        // Formatage des dates pour l'input type date
        if (dateDebut) {
            const debutDate = new Date(dateDebut);
            const formattedDebutDate = debutDate.toISOString().split('T')[0];
            dateDebutInput.value = formattedDebutDate;
        }
        
        if (dateFin) {
            const finDate = new Date(dateFin);
            const formattedFinDate = finDate.toISOString().split('T')[0];
            dateFinInput.value = formattedFinDate;
        }
        
        // Remplir les informations de l'entreprise
        nomEntrepriseInput.value = nomEntreprise || '';
        
        if (emailContact) emailContactInput.value = emailContact;
        if (telephoneContact) telephoneContactInput.value = telephoneContact;
        if (adresse) adresseInput.value = adresse;
        
        // Afficher le formulaire
        toggleForm();
        
        // Scroll jusqu'au formulaire
        formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };
    
    // Fonction pour supprimer une offre avec confirmation
    window.deleteOffre = function(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')) {
            window.location.href = `/?uri=admin_offre_delete&id=${id}`;
        }
    };
    
    // Validation du formulaire
    const offreForm = document.querySelector('#offreForm form');
    if (offreForm) {
        offreForm.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = offreForm.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    
                    // Ajouter un message d'erreur s'il n'existe pas déjà
                    let errorMsg = field.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message';
                        errorMsg.textContent = 'Ce champ est requis';
                        errorMsg.style.color = '#ff6b6b';
                        errorMsg.style.fontSize = '12px';
                        errorMsg.style.marginTop = '5px';
                        field.parentNode.appendChild(errorMsg);
                    }
                } else {
                    field.classList.remove('error');
                    const errorMsg = field.parentNode.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
            
            // Vérification des dates
            if (dateDebutInput.value && dateFinInput.value) {
                const debut = new Date(dateDebutInput.value);
                const fin = new Date(dateFinInput.value);
                
                if (debut > fin) {
                    isValid = false;
                    dateFinInput.classList.add('error');
                    
                    let errorMsg = dateFinInput.parentNode.querySelector('.error-message');
                    if (!errorMsg) {
                        errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message';
                        errorMsg.textContent = 'La date de fin doit être postérieure à la date de début';
                        errorMsg.style.color = '#ff6b6b';
                        errorMsg.style.fontSize = '12px';
                        errorMsg.style.marginTop = '5px';
                        dateFinInput.parentNode.appendChild(errorMsg);
                    }
                }
            }
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll vers le premier champ en erreur
                const firstError = offreForm.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
        
        // Suppression des messages d'erreur lors de la saisie
        offreForm.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', function() {
                if (field.classList.contains('error')) {
                    field.classList.remove('error');
                    const errorMsg = field.parentNode.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            });
        });
    }
    
    // Gestion de la pagination
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Ajouter un effet de loading
            document.body.classList.add('loading');
            
            // On laisse la navigation se faire normalement
            setTimeout(() => {
                document.body.classList.remove('loading');
            }, 1000);
        });
    });
    
    // Effets visuels sur les cartes d'offres
    const offreCards = document.querySelectorAll('.offre-card');
    offreCards.forEach((card, index) => {
        // Ajouter un délai progressif pour l'animation d'apparition
        setTimeout(() => {
            card.classList.add('visible');
        }, 100 * index);
        
        // Effet de survol en 3D
        card.addEventListener('mousemove', function(e) {
            const cardRect = card.getBoundingClientRect();
            const cardCenterX = cardRect.left + cardRect.width / 2;
            const cardCenterY = cardRect.top + cardRect.height / 2;
            const mouseX = e.clientX - cardCenterX;
            const mouseY = e.clientY - cardCenterY;
            
            const rotateY = mouseX / 20;
            const rotateX = -mouseY / 20;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });
        
        // Réinitialisation de l'effet au départ de la souris
        card.addEventListener('mouseleave', function() {
            card.style.transform = '';
        });
    });
    
    // Style pour les champs actifs du formulaire
    const formInputs = document.querySelectorAll('input, textarea, select');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentNode.classList.remove('focused');
        });
    });
    
    // Animation d'apparition progressive des éléments
    const animElements = document.querySelectorAll('.actions-header, .search-container, .table-container, .offres-grid, .offre-detail');
    animElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 100 * index);
    });
});

// Style de loading pour la page
document.addEventListener('DOMContentLoaded', function() {
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        body.loading {
            position: relative;
        }
        
        body.loading:after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        body.loading:before {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #4ECDC4;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 10000;
        }
        
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        .offre-card {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        
        .offre-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .form-group.focused label {
            color: #4ECDC4;
        }
        
        .form-group.focused input,
        .form-group.focused textarea,
        .form-group.focused select {
            border-color: #4ECDC4;
            box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
        }
        
        .error {
            border-color: #ff6b6b !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2) !important;
        }
    `;
    document.head.appendChild(styleElement);
});