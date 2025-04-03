document.addEventListener('DOMContentLoaded', function() {
     
    const socialIcons = document.querySelectorAll('.footer-social a');
    socialIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
});