<!--
/*
 * Verdecalc
 * Copyright (C) 2025 Equipe Verdecalc
 *
 * Este programa é software livre; você pode redistribuí-lo e/ou
 * modificá-lo sob os termos da Licença Pública Geral GNU conforme
 * publicada pela Free Software Foundation; na versão 2 da licença,
 * ou (a seu critério) qualquer versão posterior.
 *
 * Este programa é distribuído na esperança de que seja útil,
 * mas SEM NENHUMA GARANTIA; sem mesmo a garantia implícita de
 * COMERCIALIZAÇÃO ou ADEQUAÇÃO A UM DETERMINADO FIM. Veja a
 * Licença Pública Geral GNU para mais detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa; se não, veja <https://www.gnu.org/licenses/>.
 */
 !-->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="\imagens\imagem.png">
        <title>VerdeCalc</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
        <link rel="manifest" href="{{asset('manifest/manifest.json')}}">
    </head>
    <body>
    <div class="container" id="container">
        <div class="formulario-container registro">
            <form action="/events" method="POST" id="form-cadastro" onsubmit="mostrarTelaCarregando()">
                
                @csrf
                <h1>Crie sua conta</h1>
                <input type="text" placeholder="Nome" id="nome" name="nome" required>
                <input type="email" placeholder="Email" id="email" name="email" required>
                <span id="erro-email" class="erro"></span>
                <input type="password" placeholder="senha" id="password" name="password" required>
                <span class="erro" id="erro-password"></span>
                <input type="password" placeholder="Confirme sua senha" id="confirmSenha" name="confirmSenha" required>
                <span id="errorMessage" class="text-danger" style="display: none;">As senhas devem ser iguais!</span>
                <input type="text" placeholder="CNPJ" id="cnpj" name="cnpj" required minlength="18" maxlength="18">
                <span id="erro-cnpj" class="erro"></span>
                <button value="Registrar" id="registrar" class="registrarBT">Registrar</button>
                <input type="button" value="GERAR CNPJ"  onclick="gerarCNPJ()" 
                class="btn-cnpj"/>
            </form>
        </div>
        <div class="formulario-container logar">
            <form action="" method="POST" id="form-login" onsubmit="mostrarTelaCarregando()">
                {{-- CSRF necessario para o POST --}}
                @csrf
                <h1>Entre com a sua conta</h1>
                <input type="email" placeholder="Email" name="email" required>
                <span class="erro" id="erro-Log-email"></span>
                <input type="password" placeholder="senha" name="password" required>
                <span class="erro" id="erro-Log-password"></span>
                <a href="/navegar/nova-senha">Esqueceu a senha?</a>
                <button style="margin-left: 10px;">Entrar</button>
            </form>
        </div>
    <div class="container-alternativo">
        <div class="alternativo">
            <div class="painel-alternativo painel-esquerdo">
                <h1>Bem vindo de volta!</h1>
                <p>Entre no nosso site e descubra o quanto de Carbono sua empresa emite na atmosfera.</p>
                <button class="hidden" id="login">Entrar</button>
            </div>
            <div class="painel-alternativo painel-direito">
                <h1>Bem vindo!</h1>
                <p>Se registre no nosso site e descubra o quanto de Carbono sua empresa emite na atmosfera.</p>
                <button class="hidden" id="register">Registrar</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/script_index.js') }}"></script>

    <script>
        function gerarCNPJ() {
            function gerarDigitos() {
                let n = 9;
                let cnpj = [];
                for (let i = 0; i < 8; i++) {
                    cnpj.push(Math.floor(Math.random() * 10));
                }
                // Adiciona os 4 dígitos fixos (da raiz do CNPJ - geralmente para empresas fictícias, usa-se 0001)
                cnpj.push(0, 0, 0, 1);

                // Calcula o primeiro dígito verificador
                let pesos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
                let soma1 = cnpj.reduce((soma, valor, i) => soma + valor * pesos1[i], 0);
                let resto1 = soma1 % 11;
                let digito1 = resto1 < 2 ? 0 : 11 - resto1;
                cnpj.push(digito1);

                // Calcula o segundo dígito verificador
                let pesos2 = [6].concat(pesos1);
                let soma2 = cnpj.reduce((soma, valor, i) => soma + valor * pesos2[i], 0);
                let resto2 = soma2 % 11;
                let digito2 = resto2 < 2 ? 0 : 11 - resto2;
                cnpj.push(digito2);

                return cnpj;
            }

            function formatarCNPJ(cnpjArray) {
                return `${cnpjArray.slice(0, 2).join('')}.${cnpjArray.slice(2, 5).join('')}.${cnpjArray.slice(5, 8).join('')}/${cnpjArray.slice(8, 12).join('')}-${cnpjArray.slice(12).join('')}`;
            }

            let cnpj = gerarDigitos();
            let cnpjFormatado = formatarCNPJ(cnpj);
            alert("CNPJ gerado: " + cnpjFormatado);
        }
    </script>
        @include('layouts.carregamento')
    </body>
</html>
