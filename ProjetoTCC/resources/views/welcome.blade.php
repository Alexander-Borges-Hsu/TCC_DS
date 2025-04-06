<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- Colocar Icon --}}
        <title>VerdeCalc</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link rel="stylesheet" href="/css/Style.css">
    </head>
    <body>
    <div class="container" id="container">
        <div class="formulario-container registro">
            <form action="/events" method="POST" id="form-cadastro">
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
            </form>
        </div>
        <div class="formulario-container logar">
            <form action="" method="POST" id="form-login">
                @csrf
                <h1>Entre com a sua conta</h1>
                <input type="email" placeholder="Email" name="email" required>
                <span class="erro" id="erro-Log-email"></span>
                <input type="password" placeholder="senha" name="password" required>
                <span class="erro" id="erro-Log-password"></span>
                <a href="#">Esqueceu a senha?</a>
                <button style="margin-left: 10px;">Entrar</button>
            </form>
        </div>
    <div class="container-alternativo">
        <div class="alternativo">
            <div class="painel-alternativo painel-esquerdo">
                <h1>Bem vindo de volta!</h1>
                <p>Entre no nosso site e descubra o quanto de Carbono você emite na atmosfera.</p>
                <button class="hidden" id="login">Entrar</button>
            </div>
            <div class="painel-alternativo painel-direito">
                <h1>Bem vindo!</h1>
                <p>Se registre no nosso site e descubra o quanto de Carbono você emite na atmosfera.</p>
                <button class="hidden" id="register">Registrar</button>
            </div>
        </div>
    </div>


    <script src="js/script_index.js"></script>
    </body>
</html>
