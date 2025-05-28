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
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#4CAF50">
    <link rel="apple-touch-icon" href="/imagens/icon-512x512.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="icon" href="/imagens/imagem.png">
    <link rel="stylesheet" href="/css/styleFooter.css">
    <link rel="stylesheet" href="/css/styleTelaInicial.css">
    <link rel="stylesheet" href="/css/styleAside.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    @stack("styles") {{-- Adicionado para estilos específicos da página --}}
</head>
<body>
  <header class="header">
            <ion-icon name="menu-outline" class="header__toggle" id="nav-toggle"></ion-icon>
            <nav class="nav" id="nav-menu">
                <div class="nav__content bd-grid">
                    <ion-icon name="close-outline" class="nav__close" id="nav-close"></ion-icon>
                    @if(Auth::user() != null)
                    <div class="nav__perfil">
                        <div class="nav__img">
                            <img src="/imagens/perfil.png" alt="">
                        </div>
                        <div>
                            <a href="/navegar/editarPerfil" class="nav__name">Olá, {{ Auth::user()->nome }}</a>
                        </div>
                    </div>
                    @else
                    <div class="nav__perfil">
                        <div class="nav__img">
                            <img src="/imagens/perfil.png" alt="">
                        </div>
                        <div>
                            <a href="/navegar/welcome" class="nav__name">Entre ou cadastre-se</a>
                        </div>
                    </div>
                    @endif
                    <div class="nav__menu">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="/navegar/telaInicial" class="nav__link active"><i class='bx bx-home-alt-2'></i> Home</a></li>
                        <li class="nav__item"><a href="/navegar/formularioUm" class="nav__link"><i class='bx bx-calculator'></i> Calculadora</a></li>
                        <li class="nav__item"><a href="/navegar/cadastrarProduto" class="nav__link"><i class='bx bx-cart-add'></i> Cadastrar Produto</a></li>
                        <li class="nav__item"><a href="/navegar/editarPerfil" class="nav__link"><i class='bx bx-user-circle'></i> Editar Perfil</a></li>
                        <li class="nav__item"><a href="/sobre" class="nav__link"><i class='bx bxs-user-detail'></i> Sobre Nós</a></li>
                        <li class="nav__item"><a href="/navegar/dicas" class="nav__link"><i class='bx bx-bulb'></i> Dicas</a></li>
                        <li class="nav__item"><a href="/navegar/ia" class="nav__link"><i class='bx bx-cloud'></i> IA</a></li>
                            {{-- Botão do Logout --}}
                        @if(Auth::user() != null)  
                        <form action="/logout" method="POST" style="margin: 0; padding: 0;" onsubmit="mostrarTelaCarregando()">
                            {{-- CSRF necessário para o POST --}}
                            @csrf
                            <button type="submit" class="nav__link" style="background: none; border: none; cursor: pointer; padding: 0; color: inherit;"><i class='bx bx-log-out' style="font-size: 1.3rem; margin-top: 2px;"></i></button>
                            
                        </form>
                        @endif
                        </li>
                    </ul>
                    </div>    
                </div>
            </nav>
        </header>

@yield("content")

        {{-- Scripts Globais --}}
        <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
        <script src="{{ asset("assets/js/main.js") }}"></script> 
        @stack("scripts") {{-- Adicionado para scripts específicos da página --}}
        @include('layouts.carregamento') {{-- Tela de carregamento --}}

    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js')
        .then(reg => console.log('Service Worker registrado com sucesso:', reg))
        .catch(err => console.warn('Erro ao registrar o Service Worker:', err));
    }
    </script>
</body>
</html>

