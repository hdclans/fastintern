document.addEventListener('DOMContentLoaded', function() {
    // ANIMATION DES FEATURES
    const features = document.querySelectorAll('.feature1, .feature2, .feature3');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                
                const featureClass = entry.target.className;
                let colorBlockClass = '';
                
                if (featureClass.includes('feature1')) colorBlockClass = '.color-block1';
                else if (featureClass.includes('feature2')) colorBlockClass = '.color-block2';
                else if (featureClass.includes('feature3')) colorBlockClass = '.color-block3';
                
                if (colorBlockClass) {
                    const colorBlock = document.querySelector(colorBlockClass);
                    if (colorBlock) {
                        colorBlock.style.opacity = '1';
                        colorBlock.style.transform = 'translateX(-50%) translateY(-50%)';
                    }
                }
            }
        });
    }, {
        threshold: 0.2,
        rootMargin: '0px 0px -100px 0px'
    });

    features.forEach(feature => {
        feature.style.opacity = '0';
        feature.style.transform = 'translateY(50px)';
        feature.style.transition = 'opacity 0.7s ease, transform 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
        observer.observe(feature);
    });
    
    const colorBlocks = document.querySelectorAll('.color-block1, .color-block2, .color-block3');
    colorBlocks.forEach(block => {
        block.style.opacity = '0';
        block.style.transition = 'opacity 1s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
    });    
});