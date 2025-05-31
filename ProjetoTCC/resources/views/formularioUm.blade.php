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


@extends('layouts.mainForms')
@section('content')
<section class="form-container">
    <h2 class="titulo">Olá, antes de começarmos, insira algumas informações empresariais.</h2>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
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
    
    <form action="{{ route('formulario.store') }}" method="POST">
        @csrf
        <label for="cnpj">CNPJ da empresa</label>
        <input type="text" id="cnpj" name="cnpj" placeholder="CNPJ" value="{{ old('cnpj') }}" required>
        <br>
        <br>
        <label for="nome_empresa">Nome completo da empresa</label>
        <input type="text" id="nome_empresa" name="nome_empresa" placeholder="Nome da empresa" value="{{ old('nome_empresa') }}" required>
        <br>
        <br>
        <label for="endereco">Endereço da sede</label>
        <input type="text" id="endereco" name="endereco" placeholder="Endereço da sede" value="{{ old('endereco') }}" required>
        <br>
        <br>
        <label for="ramo_atividade">Ramo de atividade principal</label>
        <input type="text" id="ramo_atividade" name="ramo_atividade" placeholder="Ramo da sua empresa" value="{{ old('ramo_atividade') }}" required>
        <br>
        <br>
        <label for="num_funcionarios">Quantos funcionários a empresa possui?</label>
        <input type="number" id="num_funcionarios" name="num_funcionarios" placeholder="Quantos funcionários possui" value="{{ old('num_funcionarios') }}" required>

        <h3 class="subtituloform1">Dados Operacionais e Produção</h3>
        <label>A empresa realiza monitoramento de emissões de CO₂?</label>
        <div class="buttons">
            <input type="radio" id="monitoramento-sim" name="monitoramento" value="sim" {{ old('monitoramento') == 'sim' ? 'checked' : '' }} required>
            <label for="monitoramento-sim">Sim</label>
            <input type="radio" id="monitoramento-nao" name="monitoramento" value="nao" {{ old('monitoramento') == 'nao' ? 'checked' : '' }}>
            <label for="monitoramento-nao">Não</label>
        </div>

        <label>Quais fontes de emissão sua empresa possui?</label>
        <div class="buttons">
            <input type="checkbox" id="industria" name="fontes[]" value="Industria" {{ is_array(old('fontes')) && in_array('Industria', old('fontes')) ? 'checked' : '' }}>
            <label for="industria">Indústria</label>

            <input type="checkbox" id="transporte" name="fontes[]" value="Transporte" {{ is_array(old('fontes')) && in_array('Transporte', old('fontes')) ? 'checked' : '' }}>
            <label for="transporte">Transporte</label>

            <input type="checkbox" id="energias" name="fontes[]" value="Energias" {{ is_array(old('fontes')) && in_array('Energias', old('fontes')) ? 'checked' : '' }}>
            <label for="energias">Energias</label>

            <input type="checkbox" id="residuos" name="fontes[]" value="Resíduos" {{ is_array(old('fontes')) && in_array('Resíduos', old('fontes')) ? 'checked' : '' }}>
            <label for="residuos">Resíduos</label>
        </div>

        <label>A empresa possui certificações ambientais?</label>
        <div class="buttons">
            <input type="radio" id="cert-sim" name="certificacoes" value="sim" {{ old('certificacoes') == 'sim' ? 'checked' : '' }} required>
            <label for="cert-sim">Sim</label>
            <input type="radio" id="cert-nao" name="certificacoes" value="nao" {{ old('certificacoes') == 'nao' ? 'checked' : '' }}>
            <label for="cert-nao">Não</label>
        </div>

        <h3 class="subtituloform1">Gestão de Sustentabilidade</h3>
        <label>A empresa já implementou ações para redução de carbono?</label>
        <div class="buttons">
            <input type="radio" id="reduz-sim" name="reducao_carbono" value="sim" {{ old('reducao_carbono') == 'sim' ? 'checked' : '' }} required>
            <label for="reduz-sim">Sim</label>
            <input type="radio" id="reduz-nao" name="reducao_carbono" value="nao" {{ old('reducao_carbono') == 'nao' ? 'checked' : '' }}>
            <label for="reduz-nao">Não</label>
        </div>

        <label>A empresa realiza o cálculo da emissão de carbono?</label>
        <div class="buttons">
            <input type="radio" id="pegada-sim" name="pegada_carbono" value="sim" {{ old('pegada_carbono') == 'sim' ? 'checked' : '' }} required>
            <label for="pegada-sim">Sim</label>
            <input type="radio" id="pegada-nao" name="pegada_carbono" value="nao" {{ old('pegada_carbono') == 'nao' ? 'checked' : '' }}>
            <label for="pegada-nao">Não</label>
        </div>

        <label>Tipo de matriz energética principal?</label>
        <div class="buttons">
            <input type="radio" id="eletrica" name="matriz_energetica" value="Eletrica" {{ old('matriz_energetica') == 'Eletrica' ? 'checked' : '' }} required>
            <label for="eletrica">Elétrica</label>
            <input type="radio" id="solar" name="matriz_energetica" value="Solar" {{ old('matriz_energetica') == 'Solar' ? 'checked' : '' }}>
            <label for="solar">Solar</label>
            <input type="radio" id="eolica" name="matriz_energetica" value="Eólica" {{ old('matriz_energetica') == 'Eólica' ? 'checked' : '' }}>
            <label for="eolica">Eólica</label>
            <input type="radio" id="combustivel_fossil" name="matriz_energetica" value="Combustivel_Fossil" {{ old('matriz_energetica') == 'Combustivel_Fossil' ? 'checked' : '' }}>
            <label for="combustivel_fossil">Combustível Fóssil</label>
        </div>
        <br>
        <button type="submit" id="registrar" class="botao-input">Registrar e Continuar para Calculadora</button>
    </form>
</section>
</main>
@endsection
