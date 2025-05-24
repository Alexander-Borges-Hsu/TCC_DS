<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VerdeCalc</title>
    <link rel="icon" href="/imagens/imagem.png">
    <link rel="stylesheet" href="/css/novaSenha.css">
</head>
<body>
<div class="container">
    <h2>Verificar Email</h2>

    @if ($errors->any())
        <div class="error">Email não cadastrado.</div>
    @endif

    <form method="POST" action="{{ route('senha.enviar.codigo') }}" onsubmit="mostrarTelaCarregando()">
        {{-- CSRF necessário para o POST --}}
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Verificar</button>
    </form>
    <a href="/" class="back-link">Voltar</a>

    @include('layouts.carregamento') {{-- Tela de carregamento --}}
</div>
</body>
</html>
