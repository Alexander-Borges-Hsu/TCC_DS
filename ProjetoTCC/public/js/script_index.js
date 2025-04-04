const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

document.addEventListener("DOMContentLoaded", function () {
    
    const senha1 = document.getElementsByName('senha')[0];
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