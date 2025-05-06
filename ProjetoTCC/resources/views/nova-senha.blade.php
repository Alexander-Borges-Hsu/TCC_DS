<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Recuperar Senha</h2>

@if ($errors->any())
    <div style="color:red">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('senha.enviar.codigo') }}">
    @csrf
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <button type="submit">Enviar Código</button>
</form>



</body>
</html>