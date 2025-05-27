@extends("layouts.main")

@section("content")
<div class="container mt-5">
    <h2>Calculadora de Emissão de CO₂ - VerdeCalc</h2>
    <p>Preencha os dados abaixo para estimar sua emissão de carbono.</p>

    {{-- Exibe mensagens de sucesso ou erro --}}
    @if (session("success"))
        <div class="alert alert-success">
            {{ session("success") }}
        </div>
    @endif
    @if (session("error"))
        <div class="alert alert-danger">
            {{ session("error") }}
        </div>
    @endif

    {{-- Exibe erros de validação --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops! Verifique os erros abaixo:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route("calculadora.calcular") }}" method="POST">
        @csrf

        <fieldset class="mb-4 p-3 border rounded">
            <legend class="w-auto px-2 h6">Transporte</legend>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="distancia" class="form-label">Distância percorrida (km):</label>
                    <input type="number" step="0.1" class="form-control" id="distancia" name="distancia" value="{{ old("distancia") }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="consumo_combustivel" class="form-label">Consumo (L/100km):</label>
                    <input type="number" step="0.1" class="form-control" id="consumo_combustivel" name="consumo_combustivel" value="{{ old("consumo_combustivel") }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tipo_combustivel" class="form-label">Tipo de Combustível:</label>
                    <select class="form-select" id="tipo_combustivel" name="tipo_combustivel" required>
                        <option value="gasolina" {{ old("tipo_combustivel") == "gasolina" ? "selected" : "" }}>Gasolina</option>
                        <option value="diesel" {{ old("tipo_combustivel") == "diesel" ? "selected" : "" }}>Diesel</option>
                        <option value="etanol" {{ old("tipo_combustivel") == "etanol" ? "selected" : "" }}>Etanol</option>
                    </select>
                </div>
            </div>
        </fieldset>

        <fieldset class="mb-4 p-3 border rounded">
            <legend class="w-auto px-2 h6">Energia Elétrica</legend>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="consumo_energia" class="form-label">Consumo de Energia (kWh): <small>(Opcional)</small></label>
                    <input type="number" step="0.1" class="form-control" id="consumo_energia" name="consumo_energia" value="{{ old("consumo_energia") }}">
                </div>
            </div>
        </fieldset>

        <fieldset class="mb-4 p-3 border rounded">
            <legend class="w-auto px-2 h6">Produção Industrial/Serviços</legend>
             <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="producao" class="form-label">Unidades Produzidas/Serviços: <small>(Opcional)</small></label>
                    <input type="number" step="1" class="form-control" id="producao" name="producao" value="{{ old("producao") }}">
                </div>
            </div>
        </fieldset>

        <button type="submit" class="btn btn-primary">Calcular Emissão de CO₂</button>
    </form>

    <hr>

    <div class="mt-4">
        <h4>Como Funciona a Calculadora</h4>
        <p>A calculadora de CO₂ estima sua emissão de carbono com base em até três fatores principais:</p>
        <ul>
            <li><strong>Transporte:</strong> Calcula as emissões com base na distância percorrida, consumo de combustível e tipo de combustível utilizado.</li>
            <li><strong>Energia Elétrica:</strong> Estima as emissões baseadas no consumo de energia elétrica em kWh (use a média mensal ou anual).</li>
            <li><strong>Produção:</strong> Calcula as emissões associadas à produção de bens ou serviços (use uma métrica relevante para sua atividade).</li>
        </ul>
        <p><small>Nota: Os fatores de emissão utilizados são valores médios e podem variar. Para uma análise precisa, consulte fontes específicas para sua região e atividade.</small></p>
    </div>

</div>
@endsection

@push("styles")
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/calculadora.css') }}">
@endpush

@push("scripts")
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/calculadora.js') }}"></script>
@endpush
