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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VerdeCalc</title>
    <link rel="icon" href="/imagens/imagem.png">
    <link rel="stylesheet" href="/css/verificarCodigo.css">
</head>
<body>
    <div class="container">
    <div class="form-box">
    
<h2>Verificar Código</h2>

@if ($errors->any())
    <div style="color: red;">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('senha.verificar.codigo') }}" onsubmit="mostrarTelaCarregando()">
    {{-- CSRF necessário para o POST --}}
    @csrf

    <input type="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="Seu e-mail" required>

    <input type="text" name="codigo" placeholder="Código recebido" required>

    <input type="password" name="nova_senha" placeholder="Nova senha" required>
    <input type="password" name="nova_senha_confirmation" placeholder="Confirmar nova senha" required>

    <button type="submit">Redefinir Senha</button>
</form>
</div>
</div>
@include('layouts.carregamento') {{-- Tela de carregamento --}}

</body>
</html>