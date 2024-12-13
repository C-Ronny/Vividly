document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('section, .discover');
    
    function checkScroll() {
        sections.forEach(section => {
            const sectionTop = section.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (sectionTop < windowHeight * 0.75) {
                section.classList.add('visible');
            }
        });
    }
    
    // Check sections on load
    checkScroll();
    
    // Check sections on scroll
    window.addEventListener('scroll', checkScroll);
});
