// JavaScript para a calculadora de emissão de CO₂

document.addEventListener('DOMContentLoaded', function() {
    // Validação de formulário
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validar distância
            const distancia = document.getElementById('distancia');
            if (distancia && (isNaN(distancia.value) || distancia.value <= 0)) {
                isValid = false;
                highlightError(distancia, 'Por favor, informe uma distância válida maior que zero.');
            }
            
            // Validar consumo de combustível
            const consumoCombustivel = document.getElementById('consumo_combustivel');
            if (consumoCombustivel && (isNaN(consumoCombustivel.value) || consumoCombustivel.value <= 0)) {
                isValid = false;
                highlightError(consumoCombustivel, 'Por favor, informe um consumo de combustível válido maior que zero.');
            }
            
            // Validar tipo de combustível
            const tipoCombustivel = document.getElementById('tipo_combustivel');
            if (tipoCombustivel && !tipoCombustivel.value) {
                isValid = false;
                highlightError(tipoCombustivel, 'Por favor, selecione um tipo de combustível.');
            }
            
            // Validar consumo de energia (opcional)
            const consumoEnergia = document.getElementById('consumo_energia');
            if (consumoEnergia && consumoEnergia.value && (isNaN(consumoEnergia.value) || consumoEnergia.value < 0)) {
                isValid = false;
                highlightError(consumoEnergia, 'Por favor, informe um consumo de energia válido (ou deixe em branco).');
            }
            
            // Validar produção (opcional)
            const producao = document.getElementById('producao');
            if (producao && producao.value && (isNaN(producao.value) || producao.value < 0)) {
                isValid = false;
                highlightError(producao, 'Por favor, informe um número de unidades produzidas válido (ou deixe em branco).');
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    }
    
    // Função para destacar campos com erro
    function highlightError(element, message) {
        element.classList.add('is-invalid');
        
        // Criar mensagem de erro se não existir
        let errorDiv = element.nextElementSibling;
        if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            element.parentNode.insertBefore(errorDiv, element.nextSibling);
        }
        
        errorDiv.textContent = message;
    }
    
    // Remover destaque de erro quando o usuário corrigir o campo
    const formInputs = document.querySelectorAll('.form-control, .form-select');
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = this.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                errorDiv.textContent = '';
            }
        });
    });
});
