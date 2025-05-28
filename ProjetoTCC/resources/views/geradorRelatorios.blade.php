@extends("layouts.main")

@push("styles")
<link rel="stylesheet" href="{{ asset("css/relatorio-impressao.css") }}">
<link rel="stylesheet" href="{{ asset("css/relatorio.css") }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
@endpush

@section("content")
<div class="area-conteudo-relatorio">
    <div class="container mx-auto px-4 py-8">
        <h1 class="titulo-pagina fade-in">Relatório de Desempenho Ambiental</h1>

        {{-- Status e Resumo --}}
        <div class="max-w-5xl mx-auto mb-6 slide-in-up" style="animation-delay: 0.1s">
            <div class="status-card" style="border-left-color: {{ $status_co2['cor'] }};">
                <div class="status-icon" style="color: {{ $status_co2['cor'] }};">
                    <i class="fas {{ $status_co2['icone'] }}"></i>
                </div>
                <div class="status-title" style="color: {{ $status_co2['cor'] }};">
                    {{ $status_co2['texto'] }}
                </div>
                <div class="status-description">
                    {{ $status_co2['descricao'] }}
                </div>
            </div>
        </div>

        {{-- Container para os Cartões de Resumo --}}
        <div class="max-w-5xl mx-auto">
            <div class="grid-container mb-6">
                <div class="grid-item cartao-relatorio text-center danger slide-in-left" style="animation-delay: 0.2s">
                    <div class="content-aligned">
                        <h3 class="text-lg font-semibold mb-2">CO₂ Consumido Total</h3>
                        <p class="texto-valor-principal">{{ $co2_consumido ?? "N/A" }} <span style="font-size: 0.6em;">kg</span></p>
                    </div>
                </div>
                <div class="grid-item cartao-relatorio text-center primary slide-in-left" style="animation-delay: 0.3s">
                    <div class="content-aligned">
                        <h3 class="text-lg font-semibold mb-2">Meta de CO₂</h3>
                        <p class="texto-valor-secundario">{{ $co2_meta ?? "N/A" }} <span style="font-size: 0.6em;">kg</span></p>
                    </div>
                </div>
                <div class="grid-item cartao-relatorio text-center warning slide-in-left" style="animation-delay: 0.4s">
                    <div class="content-aligned">
                        <h3 class="text-lg font-semibold mb-2">Percentual da Meta</h3>
                        <p class="texto-valor-terciario">{{ number_format($percentual_meta ?? 0, 2, '.', '') }}<span style="font-size: 0.6em;">%</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data da Análise --}}
        <div class="max-w-5xl mx-auto mb-6">
            <div class="cartao-relatorio primary slide-in-up" style="animation-delay: 0.5s">
                <div class="flex items-center">
                    <div class="mr-4" style="color: var(--color-primary);">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Data da Análise</h3>
                        <p class="text-2xl font-bold">{{ $data_registro ?? "N/A" }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Impacto Ambiental Equivalente --}}
        <div class="max-w-5xl mx-auto cartao-relatorio mb-6 secondary slide-in-up" style="animation-delay: 0.6s">
            <h2 class="titulo-cartao-relatorio">
                <i class="fas fa-leaf"></i>
                Impacto Ambiental Equivalente
            </h2>
            <div class="grid-container mt-4">
                <div class="impact-card">
                    <div class="impact-icon">
                        <i class="fas fa-tree"></i>
                    </div>
                    <div class="spacing-y-2">
                        <div class="text-xl font-bold">{{ $impacto_ambiental['arvores_necessarias'] ?? 0 }} árvores</div>
                        <div class="text-sm text-gray-600">necessárias para absorver essa quantidade de CO₂ em um ano</div>
                    </div>
                </div>
                <div class="impact-card">
                    <div class="impact-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="spacing-y-2">
                        <div class="text-xl font-bold">{{ $impacto_ambiental['km_carro'] ?? 0 }} km</div>
                        <div class="text-sm text-gray-600">percorridos por um carro médio</div>
                    </div>
                </div>
                <div class="impact-card">
                    <div class="impact-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="spacing-y-2">
                        <div class="text-xl font-bold">{{ $impacto_ambiental['meses_energia_casa'] ?? 0 }} meses</div>
                        <div class="text-sm text-gray-600">de consumo de energia de uma residência média</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Métricas Avançadas --}}
        <div class="max-w-5xl mx-auto cartao-relatorio mb-6 primary slide-in-up" style="animation-delay: 0.7s">
            <h2 class="titulo-cartao-relatorio">
                <i class="fas fa-chart-line"></i>
                Métricas Avançadas
            </h2>
            <div class="grid-container mt-4">
                <div class="grid-item metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="metric-content spacing-y-2">
                        <div class="metric-title">Intensidade de Carbono</div>
                        <div class="metric-value">{{ $intensidade_carbono ?? "N/A" }} kg CO₂/unidade</div>
                        <div class="metric-description">
                            Emissão de CO₂ por unidade produzida
                        </div>
                    </div>
                </div>
                <div class="grid-item metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="metric-content spacing-y-2">
                        <div class="metric-title">Pontuação de Sustentabilidade</div>
                        <div class="metric-value">{{ $pontuacao ?? "N/A" }} / 100</div>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ min(100, $pontuacao ?? 0) }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section-title mt-6">Emissão por Fonte</div>
            <div class="grid-container">
                <div class="grid-item metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="metric-content spacing-y-2">
                        <div class="metric-title">Transporte</div>
                        <div class="metric-value">{{ $emissao_transporte ?? "N/A" }} kg</div>
                    </div>
                </div>
                <div class="grid-item metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="metric-content spacing-y-2">
                        <div class="metric-title">Energia Elétrica</div>
                        <div class="metric-value">{{ $emissao_energia ?? "N/A" }} kg</div>
                    </div>
                </div>
                <div class="grid-item metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <div class="metric-content spacing-y-2">
                        <div class="metric-title">Produção Industrial/Serviços</div>
                        <div class="metric-value">{{ $emissao_producao ?? "N/A" }} kg</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dicas de Redução --}}
        <div class="max-w-5xl mx-auto cartao-relatorio mb-6 secondary slide-in-up" style="animation-delay: 0.8s">
            <h2 class="titulo-cartao-relatorio">
                <i class="fas fa-lightbulb"></i>
                Dicas para Redução de Emissões
            </h2>
            <div style="background-color: #f9fafb; padding: 1rem; margin-bottom: 1rem; border-left: 4px solid var(--color-secondary);">
                <p class="flex items-center" style="color: var(--color-text-medium);">
                    <i class="fas fa-info-circle mr-2" style="color: var(--color-secondary);"></i>
                    Sua principal fonte de emissão é: <strong class="ml-2" style="color: var(--color-secondary);">{{ $fonte_emissao }}</strong>
                </p>
            </div>
            
            <div class="spacing-y-4">
                @foreach($dicas_reducao as $dica)
                <div class="tip-card">
                    <div class="tip-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>{{ $dica }}</div>
                </div>
                @endforeach
            </div>
        </div>
        
        {{-- Cartão do Gráfico --}}
        <div class="max-w-5xl mx-auto cartao-relatorio mb-6 primary slide-in-up" style="animation-delay: 0.5s">
            <h2 class="titulo-cartao-relatorio">
                <i class="fas fa-chart-pie"></i>
                Desempenho em Relação à Meta
            </h2>
            <div style="height: 300px; width: 100%; position: relative; display: flex; justify-content: center; align-items: center;">
                <div class="gauge-container" style="width: 300px; height: 300px; position: relative;">
                    <canvas id="grafico-gauge" width="300" height="300"></canvas>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-lg" style="color: var(--color-text-medium);">
                    @if($percentual_meta == 100)
                        Você precisa reduzir <strong style="color: {{ $status_co2['cor'] }};">{{ $reducao_necessaria }} kg</strong> de CO₂ para atingir sua meta.
                    @else
                        <strong style="color: {{ $status_co2['cor'] }};">{{ number_format($percentual_meta, 2, '.', '') }}%</strong> das suas ações impactam o meio ambiente.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Injeta os dados do relatório para uso no JavaScript
    window.dadosGrafico = {
        percentualMeta: {{ number_format($percentual_meta ?? 0, 2, '.', '') }},
        statusCor: "{{ $status_co2['cor'] ?? '#ef4444' }}"
    };
</script>
@endsection

@push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="{{ asset('js/relatorio.js') }}"></script>
@endpush
