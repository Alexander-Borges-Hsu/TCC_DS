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


@extends('layouts.main')
@section('content')
 <div class="video-wrapper">
    <video autoplay muted loop playsinline class="bg-video">
        <source src="{{ asset('imagens/back-video-compressed.mp4') }}" type="video/mp4">
    </video>
    <img src="{{ asset('imagens/background-senha.jpg') }}" alt="Fundo para mobile" class="bg-image-mobile">
</div>

<header>
    <h1>Bem-vindo à <span>VerdeCalc</span></h1>
</header>
<main>

    <div class="descricao">
        <p>
            Bem-vindo à VerdeCalc! Experimente nossa Calculadora de Carbono, uma ferramenta que estima as emissões de
            CO₂ geradas por atividades como transporte e consumo de energia.
            Ao inserir dados sobre seus consumos, você poderá entender o impacto ambiental da sua empresa e adotar práticas
            mais sustentáveis para reduzir as emissões de gases do efeito estufa.
        </p>
        <a href="/navegar/formularioUm" class="btn">Comece Agora</a>
    </div>
</main>

<script>
        document.addEventListener("DOMContentLoaded", function () {
        const navMenu = document.getElementById("nav-menu");
        const navToggle = document.getElementById("nav-toggle");
        const navClose = document.getElementById("nav-close");

        // Abre o menu
        if (navToggle) {
            navToggle.addEventListener("click", () => {
                navMenu.classList.add("show");
            });
        }

        // Fecha o menu
        if (navClose) {
            navClose.addEventListener("click", () => {
                navMenu.classList.remove("show");
            });
        }

        // Fecha o menu ao clicar em um link
        document.querySelectorAll(".nav__link").forEach(link => {
            link.addEventListener("click", () => {
                navMenu.classList.remove("show");
            });
        });
    });
</script>
@endsection