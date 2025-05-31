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
        <input type="text" placeholder="Quilometragem mensal">
        <br>
        <h2 class="subtitulo">Máquinas e Equipamentos</h2>
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
        
        <label>Tempo médio de funcionamento por mês (em horas)</label>
        <input type="number" placeholder="Tempo de funcionamento em horas">
        <br>
        <br>
        <label>Consumo médio por hora (litros ou kWh)</label>
        <input type="text" placeholder="Consumo médio por hora">
        <br>
        <br>
        <label>Quantidade de papel A4 utilizado por mês (resmas ou folhas)</label>
        <input type="text" placeholder="Tempo de funcionamento em horas">
        <br>
        <br>
        <h2 class="subtitulo">Materiais de Escritório e Suprimentos</h2>
        <label>Quantidade de papel higiênico consumido por mês (rolo ou kg)</label>
        <input type="text" placeholder="Quantidade papel higiênico">
        <br>
        <br>
        <label>Uso de copos descartáveis (número por mês)</label>
        <input type="number" placeholder="Quantidade copos descartáveis">
        <br>
        <br>
        <label>Uso de copos descartáveis usados com frequência (especificar e quantificar)</label>
        <input type="text" placeholder="Tempo de funcionamento em horas">
        <br>
        <br>
        <h2 class="subtitulo">Resíduos Sólidos</h2>
        <label>Quantidade de lixo comum gerado por mês (kg ou sacos de 100L)</label>
        <input type="text" placeholder="Quantidade de lixo comum">
        <br>
        <br>
        <label>Quantidade de lixo reciclável separado (kg por mês)</label>
        <input type="number" placeholder="Quantidade lixo reciclável">
        <br>
        <br>
        <label>Há compostagem de resíduos orgânicos?</label>
        <div class="buttons">
            <input type="radio" id="compostagem-sim" name="compostagem" value="sim">
            <label for="compostagem-sim">Sim</label>
            <input type="radio" id="compostagem-nao" name="compostagem" value="nao">
            <label for="compostagem-nao">Não</label>
        </div>
        <br>
        <h2 class="subtitulo">Número de Funcionários</h2>
        <label>Quantidade de funcionários fixos</label>
        <input type="number" placeholder="Quantidade de funcionários fixos">
        <br>
        <br>
        <label>Quantos se deslocam diariamente até a empresa?</label>
        <input type="number" placeholder="Quantidade de funcionários que se deslocam até a empresa">
        <br>
        <br>
        <label>Meios de transporte mais usados</label>
        <div class="buttons">
            <input type="checkbox" id="carro" name="fontes[]" value="Carro">
            <label for="carro">Carro</label>

            <input type="checkbox" id="onibus" name="fontes[]" value="Onibus">
            <label for="onibus">Onibus</label>

            <input type="checkbox" id="bicicleta" name="fontes[]" value="Bicicleta">
            <label for="bicicleta">Bicicleta</label>

            <input type="checkbox" id="pé" name="fontes[]" value="A pé">
            <label for="pé">Vai a pé</label>
        </div>
        <br>
        <h2 class="subtitulo">T.I e Infraestrutura</h2>
        <label>Quantidade de computadores e servidores ativos</label>
        <input type="number" placeholder="Quantidade de computadores e servidores ativos">
        <br>
        <br>
        <label>Horas de uso por dia</label>
        <input type="number" placeholder="Horas de uso por dia">
        <br>
        <br>
        <label>Uso de servidores em nuvem?</label>
        <div class="buttons">
            <input type="radio" id="servidores-sim" name="servidores" value="sim">
            <label for="servidores-sim">Sim</label>
            <input type="radio" id="servidores-nao" name="servidores" value="nao">
            <label for="servidores-nao">Não</label>
        </div>
        <br>
        <label>Nome do provedor</label>
        <input type="text" placeholder="Nome do provedor">
        <br>
        <br>
        <br>
        <input type="submit" value="Registrar" id="registrar" class="botao-input">
    </form>
</section>

@endsection