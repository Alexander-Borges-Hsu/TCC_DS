<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VerdeCalc</title>
    <link rel="icon" href="/imagens/imagem.png">
    <link rel="stylesheet" href="/css/styleFooter.css">
    <link rel="stylesheet" href="/css/styleTelaInicial.css">
    <link rel="stylesheet" href="/css/styleAside.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <header class="header">
            <a href="#" class="header__logo">Usuário</a>
            <ion-icon name="menu-outline" class="header__toggle" id="nav-toggle"></ion-icon>
            <nav class="nav" id="nav-menu">
                <div class="nav__content bd-grid">
                    <ion-icon name="close-outline" class="nav__close" id="nav-close"></ion-icon>
                    <div class="nav__perfil">
                        <div class="nav__img">
                            <img src="assets/img/perfil.png" alt="">
                        </div>
                        <div>
                            <a href="#" class="nav__name">Usuário</a>
                            
                        </div>
                    </div>
                    <div class="nav__menu">
                        <ul class="nav__list">
                            <li class="nav__item"><a href="#" class="nav__link active">Home</a></li>
                            <li class="nav__item"><a href="#" class="nav__link">Calculadora</a></li>
                            <li class="nav__item"><a href="#" class="nav__link">Cadastrar Produto</a></li>
                            <li class="nav__item"><a href="#" class="nav__link">Perfil</a></li>
                            <li class="nav__item"><a href="#" class="nav__link">Sobre Nós</a></li>
                        </ul>
                    </div>
                    <div class="nav__social">
                        <a href="#" class="nav__social-icon"><ion-icon name="logo-github"></ion-icon></a>                       
                    </div>
                </div>
            </nav>
        </header>

        <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
        <script src="assets/js/main.js"></script>

@yield('content')
</body>
</html>
