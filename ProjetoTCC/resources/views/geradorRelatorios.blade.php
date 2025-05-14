@extends("layouts.main")

@push("styles")
    <link rel="stylesheet" href="{{ asset("css/relatorio-impressao.css") }}">
    <link rel="stylesheet" href="{{ asset("css/relatorio.css") }}">
@endpush

@section("content")
<div class="area-conteudo-relatorio">
    <div class="container mx-auto px-4 py-8">
        <br>
        <br>
        <h1 class="titulo-pagina">Gerador de Relatórios - VerdeCalc</h1>

        {{-- Cartão de Filtros --}}
        <div class="max-w-3xl mx-auto cartao-relatorio">
            <h2 class="titulo-cartao-relatorio">Filtrar Relatório</h2>
            <form method="GET" action="{{ url("/navegar/relatorio") }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="selecao-periodo" class="block text-sm font-medium mb-1">Período Pré-definido:</label>
                        <select name="periodo" id="selecao-periodo" class="campo-formulario">
                            <option value="" {{ !($dadosRelatorio["periodo_selecionado"] ?? null) || ($dadosRelatorio["periodo_selecionado"] ?? null) == "personalizado" ? "selected" : "" }}>Personalizado</option>
                            <option value="7dias" {{ ($dadosRelatorio["periodo_selecionado"] ?? null) == "7dias" ? "selected" : "" }}>Últimos 7 dias</option>
                            <option value="30dias" {{ ($dadosRelatorio["periodo_selecionado"] ?? null) == "30dias" ? "selected" : "" }}>Últimos 30 dias</option>
                        </select>
                    </div>
                    <div>
                        <label for="campo-data-inicio" class="block text-sm font-medium mb-1">Data Início:</label>
                        <input type="date" name="inicio" id="campo-data-inicio" value="{{ $dadosRelatorio["filtro_inicio"] ?? "" }}" class="campo-formulario">
                    </div>
                    <div>
                        <label for="campo-data-fim" class="block text-sm font-medium mb-1">Data Fim:</label>
                        <input type="date" name="fim" id="campo-data-fim" value="{{ $dadosRelatorio["filtro_fim"] ?? "" }}" class="campo-formulario">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="botao-primario">Aplicar Filtros</button>
                </div>
            </form>
        </div>

        {{-- Container para os Cartões de Resumo (centralizado) --}}
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="cartao-relatorio text-center">
                    <h3 class="text-lg font-semibold mb-2">CO₂ Consumido Total</h3>
                    <p class="texto-valor-principal text-red-600">{{ $dadosRelatorio["co2_consumido_total"] ?? "N/A" }} kg</p>
                </div>
                <div class="cartao-relatorio text-center">
                    <h3 class="text-lg font-semibold mb-2">Meta de CO₂</h3>
                    <p class="texto-valor-principal text-green-600">{{ $dadosRelatorio["co2_meta"] ?? "N/A" }} kg</p>
                </div>
                <div class="cartao-relatorio text-center">
                    <h3 class="text-lg font-semibold mb-2">Avaliação VerdeCalc</h3>
                    <p class="texto-valor-secundario">{{ $dadosRelatorio["avaliacao_verdecalk"] ?? "N/A" }}</p>
                    <p class="text-xs text-gray-500 mt-2">(Excelente: &lt;=80%, Bom: &lt;=100%, Regular: &lt;=120%, Ruim: &gt;120%)</p>
                </div>
                <div class="cartao-relatorio text-center">
                    <h3 class="text-lg font-semibold mb-2">Data da Análise</h3>
                    <p class="texto-valor-terciario">{{ $dadosRelatorio["data_analise"] ?? "N/A" }}</p>
                    <p class="text-sm text-gray-500 mt-1">Período: {{ Carbon\Carbon::parse($dadosRelatorio["filtro_inicio"] ?? now())->format("d/m/Y") }} a {{ Carbon\Carbon::parse($dadosRelatorio["filtro_fim"] ?? now())->format("d/m/Y") }}</p>
                </div>
            </div>
        </div>

        {{-- Cartão do Gráfico --}}
        <div class="max-w-4xl mx-auto cartao-relatorio">
            <h2 class="titulo-cartao-relatorio">Gráfico: Consumo de CO₂ vs Meta</h2>
            <div style="height: 400px; width: 100%;">
                <canvas id="grafico-consumo-meta"></canvas>
            </div>
        </div>

    </div>
</div>
@endsection

@push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Injeta os dados do gráfico do PHP para o JavaScript
        window.graficoDadosParaPagina = {
            labels: @json($dadosGrafico["labels"] ?? []),
            consumoData: @json($dadosGrafico["consumo"] ?? []),
            metaData: @json($dadosGrafico["meta"] ?? [])
        };

        document.addEventListener("DOMContentLoaded", function() {
            if (typeof window.inicializarGraficoConsumoVsMeta === "function" && window.graficoDadosParaPagina) {
                window.inicializarGraficoConsumoVsMeta(
                    window.graficoDadosParaPagina.labels,
                    window.graficoDadosParaPagina.consumoData,
                    window.graficoDadosParaPagina.metaData
                );
            } else {
                console.warn("Função inicializarGraficoConsumoVsMeta ou dados do gráfico não encontrados.");
            }
        });
    </script>
    <script src="{{ asset("js/relatorio.js") }}" defer></script>
@endpush



