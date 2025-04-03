document.addEventListener('DOMContentLoaded', function() {
    // HEADER STICKY
    const header = document.querySelector('header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // ANIMATIONS
    const logo = document.querySelector('.logo');
    logo.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
    });
    
    logo.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
        
    // PARALLAXE
    const slogan = document.querySelector('.slogan');
    if (slogan) {
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            const sloganPosition = slogan.offsetTop;
            const offset = scrollPosition - sloganPosition;
            
            if (offset > -500 && offset < 300) {
                const translateY = offset * 0.2;
                slogan.querySelector('img').style.transform = `translateY(${translateY}px)`;
            }
        });
    }
});