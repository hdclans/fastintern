document.addEventListener('DOMContentLoaded', function() {
    console.log('Profil JS chargé');
    
    // HEADER STICKY
    const header = document.querySelector('header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // MENU MOBILE
    const mobileMenuToggle = document.createElement('div');
    mobileMenuToggle.className = 'mobile-menu-toggle';
    mobileMenuToggle.innerHTML = '<span></span><span></span><span></span>';
    
    const navContainer = document.querySelector('.nav-container');
    
    // Vérifier si le toggle existe déjà
    if (!document.querySelector('.mobile-menu-toggle')) {
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            
            if (navContainer.style.display === 'none' || navContainer.style.display === '') {
                navContainer.style.display = 'flex';
                navContainer.style.opacity = '0';
                navContainer.style.transform = 'translateY(-20px)';
                navContainer.style.flexDirection = 'column';
                
                setTimeout(() => {
                    navContainer.style.opacity = '1';
                    navContainer.style.transform = 'translateY(0)';
                }, 10);
            } else {
                navContainer.style.opacity = '0';
                navContainer.style.transform = 'translateY(-20px)';
                
                setTimeout(() => {
                    navContainer.style.display = 'none';
                }, 300);
            }
        });
    }

    // RESPONSIVE
    const mediaQuery = window.matchMedia('(max-width: 768px)');
    function handleScreenChange(e) {
        if (e.matches) {
            // Si on est en mode mobile et qu'il n'y a pas déjà un toggle
            if (!document.querySelector('.mobile-menu-toggle')) {
                header.insertBefore(mobileMenuToggle, navContainer);
            }
            navContainer.classList.add('mobile-nav');
            navContainer.style.display = 'none';
            
            navContainer.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        } else {
            // Si on est en mode desktop et qu'il y a un toggle
            if (document.querySelector('.mobile-menu-toggle')) {
                document.querySelector('.mobile-menu-toggle').remove();
            }
            navContainer.classList.remove('mobile-nav');
            navContainer.style.display = 'flex';
            navContainer.style.opacity = '1';
            navContainer.style.transform = 'translateY(0)';
        }
    }

    mediaQuery.addEventListener('change', handleScreenChange);
    handleScreenChange(mediaQuery);

    // NAVIGATION ACTIVE - Marquer le lien actuel
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('nav a, .profile-container a');
    
    navLinks.forEach(link => {
        // Marquer le lien de la page active
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });
    
    // ANIMATIONS
    const logo = document.querySelector('.logo');
    if (logo) {
        logo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        logo.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
    
    // Animation des boutons dans la page profil
    const actionButtons = document.querySelectorAll('.profil-actions a');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    
    // ANIMATION DE LA CARTE PROFIL
    const profilBox = document.querySelector('.profil-box');
    if (profilBox) {
        profilBox.style.opacity = '0';
        profilBox.style.transform = 'translateY(20px)';
        profilBox.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        
        // Déclencher l'animation après un court délai
        setTimeout(() => {
            profilBox.style.opacity = '1';
            profilBox.style.transform = 'translateY(0)';
        }, 100);
    }
});