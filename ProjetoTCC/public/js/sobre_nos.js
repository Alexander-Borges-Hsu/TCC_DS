// Funções JavaScript para a página Sobre Nós
document.addEventListener('DOMContentLoaded', function() {
    // Scroll suave para links de âncora
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Animação para os itens de estatísticas
    const statItems = document.querySelectorAll('.stat-item');
    
    if (statItems.length > 0) {
        window.addEventListener('scroll', function() {
            statItems.forEach(item => {
                const itemPosition = item.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (itemPosition < screenPosition) {
                    item.classList.add('animated');
                }
            });
        });
    }
});
