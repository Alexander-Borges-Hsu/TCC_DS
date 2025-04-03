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
            <form action="/events" method="POST">
                @csrf
                <h1>Crie sua conta</h1>
                <input type="text" placeholder="Nome" id="nome" name="nome">
                <input type="email" placeholder="Email" id="email" name="email">
                <input type="password" placeholder="Senha" id="senha" name="senha">
                <input type="password" placeholder="Confirme sua senha" id="confirmSenha" name="confirmSenha">
                <input type="text" placeholder="CNPJ" id="cnpj" name="cnpj">
                <input type="submit" value="Registrar" id="registrar">
                
            </form>
        </div>
        <div class="formulario-container logar">
            <form>
                <h1>Entre com a sua conta</h1>
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Senha">
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
