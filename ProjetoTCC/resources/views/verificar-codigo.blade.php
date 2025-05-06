<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Verificar Código</h2>

@if ($errors->any())
    <div style="color:red">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('senha.verificar.codigo') }}">
    @csrf

    <input type="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="Seu e-mail" required>

    <input type="text" name="codigo" placeholder="Código recebido" required>

    <input type="password" name="nova_senha" placeholder="Nova senha" required>
    <input type="password" name="nova_senha_confirmation" placeholder="Confirmar nova senha" required>

    <button type="submit">Redefinir Senha</button>
</form>



</body>
</html>