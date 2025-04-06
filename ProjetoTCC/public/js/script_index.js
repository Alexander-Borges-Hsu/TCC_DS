const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

// Adicionando o evento de clique aos botões de login e registro
registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

document.addEventListener("DOMContentLoaded", function () {
    
    const senha1 = document.getElementsByName('password')[0];
    const senha2 = document.getElementsByName('confirmSenha')[0];
    const botaoEnviar = document.getElementById('registrar');

    function verificarVal() {
        if (senha1.value === senha2.value && senha1.value !== "") {
            botaoEnviar.disabled = false; 
            senha2.style.border = ""; 
            errorMessage.style.display = "none"; 
        } else {
            botaoEnviar.disabled = true; 
            senha2.style.border = "2px solid red"; 
            errorMessage.style.display = "block"; 
        }
    }

    senha1.addEventListener('input', verificarVal);
    senha2.addEventListener('input', verificarVal);
});

const cnpjInput = document.getElementById('cnpj');
const erroCnpj = document.getElementById('erro-cnpj');

// Só permite números e formata o CNPJ ao digitar
cnpjInput.addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for número

    // Aplica a máscara do CNPJ (##.###.###/####-##)
    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');

    e.target.value = value;
});

// Valida CNPJ no submit
function validarCNPJ(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g, '');
    if (cnpj.length !== 14) return false;
    if (/^(\d)\1{13}$/.test(cnpj)) return false;

    let tamanho = cnpj.length - 2
    let numeros = cnpj.substring(0, tamanho);
    let digitos = cnpj.substring(tamanho);
    let soma = 0;
    let pos = tamanho - 7;

    for (let i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) pos = 9;
    }

    let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;

    for (let i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) pos = 9;
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    return resultado == digitos.charAt(1);
}

// Validando o formulário de cadastro de eventos
document.getElementById('form-cadastro').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Limpa erros anteriores
    document.querySelectorAll('.erro').forEach(el => el.textContent = '');

    const form = e.target;
    const data = new FormData(form);
    const token = document.querySelector('input[name="_token"]').value;

    const cnpj = cnpjInput.value;
    if (!validarCNPJ(cnpj)) {
        erroCnpj.textContent = 'CNPJ inválido.';
        return; // Impede o envio se inválido
    }

    try {
        const response = await fetch("/events", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: data
        });

        if (response.ok) {
            const result = await response.json();
            alert(result.message); // ou redireciona
            form.reset();
        } else if (response.status === 422) {
            const result = await response.json();
            const errors = result.errors;
            for (let campo in errors) {
                document.getElementById('erro-' + campo).textContent = errors[campo][0];
            }
        } else {
            alert('Erro inesperado. Tente novamente.', error);
        }

    } catch (error) {
        console.error('Erro:', error);
        alert('Erro de conexão.');
        console.log(error);
    }
});
