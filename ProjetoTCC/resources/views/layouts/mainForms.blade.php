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
    <link rel="icon" href="\imagens\imagem.png">
    <title>VerdeCalc</title>
    <link rel="stylesheet" href="/css/styleNavbar.css">
    <link rel="stylesheet" href="/css/form1.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="/css/formCalc.css">
    <link rel="stylesheet" href="/css/form2.css">
    <link rel="stylesheet" href="/css/editarPerfil.css">
    <link rel="stylesheet" href="/css/styleFooter.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <header class="header-form">
        <h1><span class="verde">Verde</span><span class="calc">Calc</span></h1>
        <nav>
            <ul>
                <li><a href="/navegar/telaInicial">Home</a></li>
                <li><a href="/navegar/formularioUm">Registre sua empresa</a></li>
                <li><a href="/navegar/editarPerfil">Editar perfil</a></li>
                <li><a href="/navegar/formularioDois">Notícias</a></li>
            </ul>
        </nav>
        <div class="usuario">
            <div class="icon"></div>
            <span>Olá, {{Auth::user()->nome}}</span>
        </div>
    </header>
    
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="widget1">
                        <div class="logo">
                            <div class="spanfooter"><span>Verde</span><span class="Vd">Calc</span></div>
                        </div>
                        <p>
                            O VerdeCalc é uma plataforma online dedicada à conscientização ambiental.
                            Nossa calculadora de emissão de carbono permite que você descubra quanto de carbono está
                            emitindo em suas atividades diárias, como transporte, consumo de energia e alimentação. Após
                            calcular sua emissão, oferecemos dicas práticas e eficazes para reduzir seu impacto
                            ambiental e
                            contribuir para um futuro mais sustentável.
                            Junte-se a nós na jornada por um planeta mais verde!
                        </p>
                        <div class="socialLinks">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="widget3">
                        <h5>
                            Links Rápidos
                        </h5>
                        <ul>
                            <li>
                                <a href="#">
                                    início
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Calculadora CO2
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Dicas para redução de carbono
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Quem somos
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    FAQ
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="widget4">
                        <h5>
                            Outros Links
                        </h5>
                        <ul>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Termos de uso
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Política de Privacidade
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Contato
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Redes sociais
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyRightArea">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>&copy; Todos os direitos reservados 2024.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="/js/scriptF1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>