function formatCurrency(input) {
    let value = input.value.replace(/\D/g, "");
    value = (value / 100).toFixed(2);
    input.value = value.toString().replace(".", ",");
}

document.addEventListener("DOMContentLoaded", function () {
    const moneyInput = document.getElementById("moneyInput");

    moneyInput.addEventListener("input", function () {
        formatCurrency(moneyInput);
    });
});

/*O código acima foi feito para permitir que somente valores monetários sejam inseridos no form1, em consumo de energia*/
// O código a baixo valida o formulario caso as senhas forem iguais
document.addEventListener("DOMContentLoaded", function () {
    // Inputs
    const senha1 = document.getElementsByName('newsenha')[0];
    const senha2 = document.getElementsByName('newsenhaC')[0];
    const botaoEnviar = document.getElementById('botaoenviar');

    // Função que compara as senhas e habilita/desabilita o botão
    function verificarVal() {
        if (senha1.value === senha2.value && senha1.value !== "") {
            botaoEnviar.disabled = false; // Habilita o botão se as senhas forem iguais e não vazias
            senha2.style.border = ""; // Remove a borda vermelha
            errorMessage.style.display = "none"; // Esconde a mensagem de erro
        } else {
            botaoEnviar.disabled = true; // Desabilita o botão se forem diferentes ou vazias
            senha2.style.border = "2px solid red"; // Adiciona borda vermelha
            errorMessage.style.display = "block"; // Mostra a mensagem de erro
        }
    }

    // Adicionando evento para verificar sempre que o usuário digitar algo
    senha1.addEventListener('input', verificarVal);
    senha2.addEventListener('input', verificarVal);
});


//---------------------------
//Codigo do Davi, Form 2 e Form 3 (Botões, Mudança de Cor);
//---------------------------

// Função para lidar com os transportes individuais (Carro, Moto, Ambos)

function configurarTransportesIndividuais() {
    // Seleciona os botões carro, moto e ambos
    const carroBtn = document.getElementById('carro-btn');
    const motoBtn = document.getElementById('moto-btn');
    const ambosBtn = document.getElementById('ambos-btn');

    /*Verifica se os botões existem na pagina
    Pensei em colocar caso fosse carregado em outra pagina*/

    if (!carroBtn || !motoBtn || !ambosBtn) {
        return;
        // O return interrompe a função se não houver os botões
    }

    //Variavel que vai armazenar o tipo de veiculo   
    let veiculoSelecionado = "";

    //Função para mudar as cores e a logica dos botões
    function atualizarSelecao(veiculo) {
        carroBtn.classList.remove('ativo');
        motoBtn.classList.remove('ativo');
        ambosBtn.classList.remove('ativo');

        //Coloca a classe "ativo" quando clicar no botão
        if (veiculo === 'Carro') {
            veiculoSelecionado = 'Carro';
            carroBtn.classList.add('ativo');
        } else if (veiculo === 'Moto') {
            veiculoSelecionado = 'Moto';
            motoBtn.classList.add('ativo');
        } else if (veiculo === 'Ambos') {
            veiculoSelecionado = 'Ambos';
            ambosBtn.classList.add('ativo');
        }
    }

    // Eventos de clique para cada botão
    carroBtn.addEventListener('click', function () {
        atualizarSelecao('Carro');
    });

    motoBtn.addEventListener('click', function () {
        atualizarSelecao('Moto');
    });

    ambosBtn.addEventListener('click', function () {
        atualizarSelecao('Ambos');
    });

    // Prevenir envio de formulário sem preenchimento

}

// Função para lidar com os transportes públicos (Ônibus, Ambos, Transportes Ferroviários)

function configurarTransportesPublicos() {
    const onibusBtn = document.getElementById('onibus-btn');
    const transFerroBtn = document.getElementById('transFerro-btn');
    const metroBtn = document.getElementById('metro-btn');

    if (!onibusBtn || !transFerroBtn || !metroBtn) {
        // Se não houver os botões da segunda página, sai da função
        return;
    }

    let transporteSelecionado = "";

    function atualizarSelecao(veiculoSelecionado) {
        onibusBtn.classList.remove('ativo');
        transFerroBtn.classList.remove('ativo');
        metroBtn.classList.remove('ativo');

        if (veiculoSelecionado === 'Ônibus') {
            transporteSelecionado = 'Ônibus';
            onibusBtn.classList.add('ativo');
        } else if (veiculoSelecionado === 'Ambos') {
            transporteSelecionado = 'Ambos';
            transFerroBtn.classList.add('ativo');
        } else if (veiculoSelecionado === 'Transportes Ferroviários') {
            transporteSelecionado = 'Transportes Ferroviários';
            metroBtn.classList.add('ativo');
        }
    }

    // Eventos de clique para cada botão
    onibusBtn.addEventListener('click', function () {
        atualizarSelecao('Ônibus');
    });

    transFerroBtn.addEventListener('click', function () {
        atualizarSelecao('Ambos');
    });

    metroBtn.addEventListener('click', function () {
        atualizarSelecao('Transportes Ferroviários');
    });


}

// Chama a função, dependendo de qual for a pagina ser preenchida
document.addEventListener('DOMContentLoaded', function () {
    configurarTransportesIndividuais();
    //Chama a função dos transportes individuais
    configurarTransportesPublicos();
    //Chama a função dos transportes publicos
});

//--------------------------
/* O Código acima foi feito pelo Davi*/
//--------------------------






document.getElementById("integerInput").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, ''); // Remove qualquer caractere não numérico
});

/*O código acima foi feito para somente válidar numeros inteiros na página form1 em gás natural e em maços de cigarro*/

