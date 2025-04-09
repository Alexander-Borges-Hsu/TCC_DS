@extends('layouts.mainForms')
@section('content')

<section class="form-container">
    <h2 class="subtitulo">Energia Elétrica</h2>
    <form>
        <label>Qual foi o consumo médio mensal de energia elétrica (em kWh)?</label>
        <input type="number" placeholder="Consumo mensal em kWh">
        <br>
        <br>
        <label>A energia consumida é proveniente de fonte renovável?</label>
        <div class="buttons">
            <input type="radio" id="renovavel-sim" name="renovavel" value="sim">
            <label for="renovavel-sim">Sim</label>
            <input type="radio" id="renovavel-nao" name="renovavel" value="nao">
            <label for="renovavel-nao">Não</label>
        </div>
        <br>
        <label for="uf">Qual é o estado (UF) da empresa?</label>
        <select id="uf" name="uf">
            <option value="AC">Acre</option>    
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select>
        <br>
        <h2 class="subtitulo">Transporte e Logística</h2>
        <label>Quantos veículos a empresa possui?</label>
        <input type="number" placeholder="Quantidade de veículos">
        <br>
        <br>
        <label>Tipo de veículo</label>
        <input type="text" placeholder="Carro, caminhão, moto, etc...">
        <br>
        <br>
        <label>Tipo de combustível usado</label>
        <div class="buttons">
            <input type="checkbox" id="gasolina" name="fontes[]" value="Gasolina">
            <label for="gasolina">Gasolina</label>

            <input type="checkbox" id="diesel1" name="fontes[]" value="Diesel">
            <label for="diesel1">Diesel</label>

            <input type="checkbox" id="etanol" name="fontes[]" value="Etanol">
            <label for="etanol">Etanol</label>

            <input type="checkbox" id="gnv" name="fontes[]" value="GNV">
            <label for="gnv">GNV</label>

            <input type="checkbox" id="eletrico" name="fontes[]" value="Elétrico">
            <label for="eletrico">Elétrico</label>
        </div>
        <br>
        <label>Quilometragem média mensal de cada tipo</label>
        <input type="number" placeholder="Quilometragem mensal">
        <br>
        <h3 class="subtitulo">Máquinas e Equipamentos</h3>
        <label>Quantas máquinas a empresa usa regularmente? (Descrição por tipo)</label>
        <input type="text" placeholder="Quantidade e descrição das máquinas">
        <br>
        <br>
        <label>Tipos de energia usada</label>
        <div class="buttons">
            <input type="checkbox" id="eletrica" name="fontes[]" value="Elétrica">
            <label for="eletrica">Elétrica</label>

            <input type="checkbox" id="diesel" name="fontes[]" value="Diesel">
            <label for="diesel">Diesel</label>

            <input type="checkbox" id="gas" name="fontes[]" value="Gás">
            <label for="gas">Gás</label>
        </div>
        <br>
        <label>A empresa possui certificações ambientais?</label>
        <div class="buttons">
            <input type="radio" id="cert-sim" name="certificacoes" value="sim">
            <label for="cert-sim">Sim</label>
            <input type="radio" id="cert-nao" name="certificacoes" value="nao">
            <label for="cert-nao">Não</label>
        </div>

        <h3 class="subtitulo">Gestão de Sustentabilidade</h3>
        <label>A empresa já implementou ações para redução de carbono?</label>
        <div class="buttons">
            <input type="radio" id="reduz-sim" name="reducao_carbono" value="sim">
            <label for="reduz-sim">Sim</label>
            <input type="radio" id="reduz-nao" name="reducao_carbono" value="nao">
            <label for="reduz-nao">Não</label>
        </div>

        <label>A empresa realiza o cálculo da emissão de carbono?</label>
        <div class="buttons">
            <input type="radio" id="pegada-sim" name="pegada_carbono" value="sim">
            <label for="pegada-sim">Sim</label>
            <input type="radio" id="pegada-nao" name="pegada_carbono" value="nao">
            <label for="pegada-nao">Não</label>
        </div>

        <label>Tipo de matriz energética principal?</label>
        <div class="buttons">
            <input type="radio" id="eletrica" name="matriz_energetica" value="Eletrica">
            <label for="eletrica">Elétrica</label>
            <input type="radio" id="solar" name="matriz_energetica" value="Solar">
            <label for="solar">Solar</label>
            <input type="radio" id="eolica" name="matriz_energetica" value="Eólica">
            <label for="eolica">Eólica</label>
            <input type="radio" id="combustivel_fossil" name="matriz_energetica" value="Combustivel_Fossil">
            <label for="combustivel_fossil">Combustível Fóssil</label>
        </div>
        <br>
        <input type="submit" value="Registrar" id="registrar" class="botao-input">
    </form>
</section>

@endsection