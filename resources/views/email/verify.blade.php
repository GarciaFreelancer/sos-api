<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Óla {{ $name }},
    <br>
    Obrigado por criar uma conta conosco. Não esqueça de completar seu cadastro!
    <br>
    Por favor, clique no link abaixo ou copie-o na barra de endereços do seu navegador para confirmar seu e-mail:
    <br>

    <a href="{{ url('user/verify', [$verification_code, $email])}}">Confirmar meu email</a>

    <br/>
</div>

</body>
</html>
