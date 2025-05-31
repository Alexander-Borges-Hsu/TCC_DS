// Chart.js é carregado via CDN no layout principal

/**
 * Inicializa o gráfico gauge que mostra o percentual da meta
 * @param {string} canvasId - ID do elemento canvas
 * @param {number} percentual - Percentual da meta (0-100)
 * @param {string} corStatus - Cor do status (hexadecimal)
 */
function inicializarGraficoGauge(canvasId, percentual, corStatus) {
    console.log("Inicializando gráfico gauge com:", { canvasId, percentual, corStatus });
    
    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        console.error(`Canvas com ID ${canvasId} não encontrado`);
        return;
    }
    
    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = Math.min(centerX, centerY) * 0.8;
    
    // Limpar o canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Desenhar o arco de fundo (cinza claro)
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, Math.PI, 2 * Math.PI, false);
    ctx.lineWidth = 16;
    ctx.strokeStyle = '#e5e7eb';
    ctx.stroke();
    
    // Definir as zonas de cores
    const zonas = [
        { limite: 40, cor: '#22c55e' },  // Verde (Excelente)
        { limite: 70, cor: '#84cc16' },  // Verde-amarelado (Bom)
        { limite: 90, cor: '#f59e0b' },  // Amarelo (Regular)
        { limite: 100, cor: '#ef4444' }  // Vermelho (Ruim)
    ];
    
    // Desenhar as zonas coloridas
    let startAngle = Math.PI;
    zonas.forEach((zona) => {
        const endAngle = Math.PI + (zona.limite / 100) * Math.PI;
        
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, startAngle, endAngle, false);
        ctx.lineWidth = 16;
        ctx.strokeStyle = zona.cor + '90'; // Adiciona transparência
        ctx.stroke();
        
        startAngle = endAngle;
    });
    
    // O percentual já vem limitado a 100% do controller, mas garantimos novamente aqui
    const needleAngle = Math.PI + (percentual / 100) * Math.PI;
    
    // Desenhar o ponteiro
    ctx.save();
    ctx.translate(centerX, centerY);
    ctx.rotate(needleAngle);
    
    // Linha do ponteiro
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.lineTo(radius * 0.8, 0);
    ctx.lineWidth = 3;
    ctx.strokeStyle = '#1f2937';
    ctx.stroke();
    
    // Círculo central
    ctx.beginPath();
    ctx.arc(0, 0, 8, 0, 2 * Math.PI);
    ctx.fillStyle = '#1f2937';
    ctx.fill();
    
    ctx.restore();
    
    // Desenhar o texto do percentual
    ctx.font = 'bold 32px "Inter", sans-serif';
    ctx.fillStyle = corStatus;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(percentual + '%', centerX, centerY + radius * 0.5);
    
    // Desenhar as marcações de percentual
    const marcacoes = [0, 25, 50, 75, 100];
    marcacoes.forEach(marca => {
        const marcaAngle = Math.PI + (marca / 100) * Math.PI;
        const x1 = centerX + (radius - 25) * Math.cos(marcaAngle);
        const y1 = centerY + (radius - 25) * Math.sin(marcaAngle);
        const x2 = centerX + (radius + 5) * Math.cos(marcaAngle);
        const y2 = centerY + (radius + 5) * Math.sin(marcaAngle);
        
        // Linha da marcação
        ctx.beginPath();
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, y2);
        ctx.lineWidth = 2;
        ctx.strokeStyle = '#9ca3af';
        ctx.stroke();
        
        // Texto da marcação
        const textX = centerX + (radius + 25) * Math.cos(marcaAngle);
        const textY = centerY + (radius + 25) * Math.sin(marcaAngle);
        ctx.font = '12px "Inter", sans-serif';
        ctx.fillStyle = '#4b5563';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(marca + '%', textX, textY);
    });
}

// Inicializar os gráficos quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM carregado, inicializando gráficos...");
    
    // Verificar se temos os dados necessários
    if (window.dadosGrafico) {
        console.log("Dados do gráfico disponíveis:", window.dadosGrafico);
        
        // Inicializar o gráfico gauge
        if (document.getElementById('grafico-gauge')) {
            inicializarGraficoGauge('grafico-gauge', window.dadosGrafico.percentualMeta, window.dadosGrafico.statusCor);
        } else {
            console.error("Elemento canvas 'grafico-gauge' não encontrado");
        }
    } else {
        console.error("Dados do gráfico não disponíveis");
    }

    // Adicionar efeitos de animação para elementos ao scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.cartao-relatorio, .impact-card, .metric-card, .tip-card');
        
        elements.forEach(element => {
            const position = element.getBoundingClientRect();
            
            // Se o elemento estiver visível na tela
            if(position.top < window.innerHeight - 100 && position.bottom >= 0) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    // Configurar elementos para animação
    document.querySelectorAll('.cartao-relatorio, .impact-card, .metric-card, .tip-card').forEach(element => {
        if (!element.classList.contains('slide-in-left') && 
            !element.classList.contains('slide-in-right') && 
            !element.classList.contains('slide-in-up') && 
            !element.classList.contains('fade-in')) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            element.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        }
    });
    
    // Executar uma vez ao carregar
    setTimeout(animateOnScroll, 100);
    
    // Adicionar ao evento de scroll
    window.addEventListener('scroll', animateOnScroll);
});
