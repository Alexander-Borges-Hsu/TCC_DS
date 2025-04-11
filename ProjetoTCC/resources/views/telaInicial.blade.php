@extends('layouts.main')
@section('content')
<video src="/imagens/back-video-compressed.mp4" autoplay loop playsinline muted></video>
<header>
    <h1>Bem-vindo à <span>VerdeCalc</span></h1>
</header>
<main>
<!-- <h1>Bem-vindo, {{ Auth::user()->nome }}</h1> -->
    <div class="descricao">
        <p>
            Bem-vindo à VerdeCalc! Experimente nossa Calculadora de Carbono, uma ferramenta que estima as emissões de
            CO₂ geradas por atividades como transporte e consumo de energia.
            Ao inserir dados sobre seus hábitos diários, você poderá entender seu impacto ambiental e adotar práticas
            mais sustentáveis para reduzir as emissões de gases do efeito estufa.
        </p>
        <a href="/navegar/formularioUm" class="btn">Comece Agora</a>
    </div>
</main>

@endsection