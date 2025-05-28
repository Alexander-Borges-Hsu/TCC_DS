@extends('layouts.mainForms')

@section('content')
<section class="form-container">
    <h2 class="titulo">Calculadora de Emissão de CO₂ - VerdeCalc</h2>
    <p class="subtitulo-desc">Preencha os dados abaixo para estimar a emissão de carbono da sua empresa.</p>

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

    <form action="{{ route('calculadora.calcular') }}" method="POST" class="calc-form">
        @csrf

        <div class="form-section">
            <h3 class="subtitulo">Transporte e Logística</h3>
            <label for="distancia">Qual a distância média percorrida mensalmente (km/mês)?</label>
            <input type="number" step="0.1" id="distancia" name="distancia" value="{{ old('distancia') }}" placeholder="Distância em km por mês" required>
            <br>
            <br>
            <label for="consumo_combustivel">Qual o consumo médio de combustível (L/100km)?</label>
            <input type="number" step="0.1" id="consumo_combustivel" name="consumo_combustivel" value="{{ old('consumo_combustivel') }}" placeholder="Consumo em litros por 100km" required>
            <br>
            <br>
            <label for="tipo_combustivel">Qual o tipo de combustível mais utilizado?</label>
            <div class="buttons">
                <input type="radio" id="gasolina" name="tipo_combustivel" value="gasolina" {{ old('tipo_combustivel') == 'gasolina' ? 'checked' : '' }} required>
                <label for="gasolina">Gasolina</label>
                <input type="radio" id="diesel" name="tipo_combustivel" value="diesel" {{ old('tipo_combustivel') == 'diesel' ? 'checked' : '' }}>
                <label for="diesel">Diesel</label>
                <input type="radio" id="etanol" name="tipo_combustivel" value="etanol" {{ old('tipo_combustivel') == 'etanol' ? 'checked' : '' }}>
                <label for="etanol">Etanol</label>
            </div>
        </div>

        <div class="form-section">
            <h3 class="subtitulo">Energia Elétrica</h3>
            <label for="consumo_energia">Qual o consumo médio mensal de energia elétrica (kWh/mês)?</label>
            <input type="number" step="0.1" id="consumo_energia" name="consumo_energia" value="{{ old('consumo_energia') }}" placeholder="Consumo em kWh por mês">
            <div class="info-box">
                <p>Você pode encontrar esta informação na sua conta de energia elétrica mensal.</p>
            </div>
        </div>

        <!-- NOVA PERGUNTA 1: Consumo de Gás Natural e GLP -->
        <div class="form-section">
            <h3 class="subtitulo">Consumo de Gás Natural e GLP</h3>
            <label for="consumo_gas">Qual o consumo médio mensal de gás natural ou GLP (m³ ou kg/mês)?</label>
            <div class="input-group">
                <input type="number" step="0.1" id="consumo_gas" name="consumo_gas" value="{{ old('consumo_gas') }}" placeholder="Quantidade consumida por mês">
                <select id="unidade_gas" name="unidade_gas">
                    <option value="m3" {{ old('unidade_gas') == 'm3' ? 'selected' : '' }}>m³ (gás natural)</option>
                    <option value="kg" {{ old('unidade_gas') == 'kg' ? 'selected' : '' }}>kg (GLP)</option>
                </select>
            </div>
            <br>
            <br>
            <label for="finalidade_gas">Qual a finalidade principal deste consumo?</label>
            <div class="buttons">
                <input type="radio" id="aquecimento" name="finalidade_gas" value="aquecimento" {{ old('finalidade_gas') == 'aquecimento' ? 'checked' : '' }}>
                <label for="aquecimento">Aquecimento de água</label>
                
                <input type="radio" id="processos" name="finalidade_gas" value="processos" {{ old('finalidade_gas') == 'processos' ? 'checked' : '' }}>
                <label for="processos">Processos industriais</label>
                
                <input type="radio" id="cozinha" name="finalidade_gas" value="cozinha" {{ old('finalidade_gas') == 'cozinha' ? 'checked' : '' }}>
                <label for="cozinha">Cozinha/refeitório</label>
                
                <input type="radio" id="geracao" name="finalidade_gas" value="geracao" {{ old('finalidade_gas') == 'geracao' ? 'checked' : '' }}>
                <label for="geracao">Geração de energia</label>
                
                <input type="radio" id="outro_gas" name="finalidade_gas" value="outro" {{ old('finalidade_gas') == 'outro' ? 'checked' : '' }}>
                <label for="outro_gas">Outro</label>
            </div>
            <div id="outro_gas_div" style="display: none;">
                <br>
                <label for="finalidade_gas_outro">Especifique:</label>
                <input type="text" id="finalidade_gas_outro" name="finalidade_gas_outro" value="{{ old('finalidade_gas_outro') }}" placeholder="Especifique a finalidade">
            </div>
            <div class="info-box">
                <p>Segundo a CETESB, os fatores de emissão para gás natural são de 2,07 kgCO₂e/m³ e para GLP são de 2,93 kgCO₂e/kg.</p>
            </div>
        </div>

        <!-- NOVA PERGUNTA 2: Emissões Fugitivas de Gases Refrigerantes -->
        <div class="form-section">
            <h3 class="subtitulo">Emissões Fugitivas de Gases Refrigerantes</h3>
            <label>Houve reposição de gases refrigerantes em sistemas de ar-condicionado ou refrigeração no último ano?</label>
            <div class="buttons">
                <input type="radio" id="reposicao-sim" name="reposicao_gases" value="sim" {{ old('reposicao_gases') == 'sim' ? 'checked' : '' }}>
                <label for="reposicao-sim">Sim</label>
                <input type="radio" id="reposicao-nao" name="reposicao_gases" value="nao" {{ old('reposicao_gases') == 'nao' ? 'checked' : '' }}>
                <label for="reposicao-nao">Não</label>
            </div>
            
            <div id="reposicao_details" style="display: none;">
                <br>
                <label for="tipo_gas_refrigerante">Qual o tipo de gás refrigerante utilizado?</label>
                <select id="tipo_gas_refrigerante" name="tipo_gas_refrigerante">
                    <option value="">Selecione o tipo de gás</option>
                    <option value="r410a" {{ old('tipo_gas_refrigerante') == 'r410a' ? 'selected' : '' }}>R-410A (GWP: 2.088)</option>
                    <option value="r22" {{ old('tipo_gas_refrigerante') == 'r22' ? 'selected' : '' }}>R-22 (HCFC-22) (GWP: 1.810)</option>
                    <option value="r134a" {{ old('tipo_gas_refrigerante') == 'r134a' ? 'selected' : '' }}>R-134a (HFC-134a) (GWP: 1.430)</option>
                    <option value="r404a" {{ old('tipo_gas_refrigerante') == 'r404a' ? 'selected' : '' }}>R-404A (GWP: 3.922)</option>
                    <option value="r407c" {{ old('tipo_gas_refrigerante') == 'r407c' ? 'selected' : '' }}>R-407C (GWP: 1.774)</option>
                    <option value="r32" {{ old('tipo_gas_refrigerante') == 'r32' ? 'selected' : '' }}>R-32 (GWP: 675)</option>
                    <option value="outro" {{ old('tipo_gas_refrigerante') == 'outro' ? 'selected' : '' }}>Outro</option>
                </select>
                <br>
                <br>
                <label for="quantidade_gas">Qual a quantidade reposta no último ano (kg/ano)?</label>
                <input type="number" step="0.01" id="quantidade_gas" name="quantidade_gas" value="{{ old('quantidade_gas') }}" placeholder="Quantidade em kg por ano">
                <div class="info-box">
                    <p>Gases refrigerantes têm alto potencial de aquecimento global (GWP). Por exemplo, 1kg de R-410A equivale a 2.088kg de CO₂. Fonte: Inventário de Emissões de GEE da B3 (2020-2021) e Programa Brasileiro de Eliminação dos HCFCs (MMA).</p>
                </div>
            </div>
        </div>

        <!-- NOVA PERGUNTA 3: Processos Industriais Específicos -->
        <div class="form-section">
            <h3 class="subtitulo">Processos Industriais Específicos</h3>
            <label>A empresa realiza algum dos seguintes processos que geram emissões diretas de CO₂?</label>
            <div class="buttons">
                <input type="checkbox" class="processo-check" id="calcario" name="processos[]" value="calcario" {{ is_array(old('processos')) && in_array('calcario', old('processos')) ? 'checked' : '' }}>
                <label for="calcario">Calcinação de calcário/produção de cimento</label>
                
                <input type="checkbox" class="processo-check" id="metais" name="processos[]" value="metais" {{ is_array(old('processos')) && in_array('metais', old('processos')) ? 'checked' : '' }}>
                <label for="metais">Produção de metais (aço, alumínio, etc.)</label>
                
                <input type="checkbox" class="processo-check" id="vidro" name="processos[]" value="vidro" {{ is_array(old('processos')) && in_array('vidro', old('processos')) ? 'checked' : '' }}>
                <label for="vidro">Produção de vidro</label>
                
                <input type="checkbox" class="processo-check" id="papel" name="processos[]" value="papel" {{ is_array(old('processos')) && in_array('papel', old('processos')) ? 'checked' : '' }}>
                <label for="papel">Produção de papel e celulose</label>
                
                <input type="checkbox" class="processo-check" id="petroquimicos" name="processos[]" value="petroquimicos" {{ is_array(old('processos')) && in_array('petroquimicos', old('processos')) ? 'checked' : '' }}>
                <label for="petroquimicos">Processos petroquímicos</label>
                
                <input type="checkbox" class="processo-check" id="carbonatos" name="processos[]" value="carbonatos" {{ is_array(old('processos')) && in_array('carbonatos', old('processos')) ? 'checked' : '' }}>
                <label for="carbonatos">Uso de carbonatos na produção</label>
                
                <input type="checkbox" id="nenhum" name="processos[]" value="nenhum" {{ is_array(old('processos')) && in_array('nenhum', old('processos')) ? 'checked' : '' }}>
                <label for="nenhum">Nenhum dos anteriores</label>
            </div>
            
            <div id="processos_details" style="display: none;">
                <br>
                <label for="volume_producao">Qual o volume médio mensal de produção (toneladas/mês)?</label>
                <input type="number" step="0.01" id="volume_producao" name="volume_producao" value="{{ old('volume_producao') }}" placeholder="Volume em toneladas por mês">
                <div class="info-box">
                    <p>Processos industriais específicos geram emissões diretas de CO₂ independentes da queima de combustíveis. Por exemplo, a calcinação de calcário emite aproximadamente 0,44 tCO₂ por tonelada de calcário processado. Fonte: Inventário Brasileiro de Emissões (MCTI).</p>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="subtitulo">Produção Industrial/Serviços</h3>
            <label for="producao">Quantas unidades são produzidas ou serviços prestados mensalmente?</label>
            <input type="number" step="1" id="producao" name="producao" value="{{ old('producao') }}" placeholder="Quantidade mensal de unidades/serviços">
            <div class="info-box">
                <p>Informe a quantidade mensal de produtos fabricados ou serviços prestados pela sua empresa.</p>
            </div>
        </div>

        <button type="submit" id="registrar" class="botao-input">Calcular Emissão de CO₂</button>
    </form>

    <div class="info-section">
        <h3 class="subtitulo">Como Funciona a Calculadora</h3>
        <p>A calculadora de CO₂ estima a emissão de carbono da sua empresa com base em seis fatores principais:</p>
        <ul>
            <li><strong>Transporte e Logística:</strong> Calcula as emissões com base na distância percorrida mensalmente, consumo de combustível e tipo de combustível utilizado.</li>
            <li><strong>Energia Elétrica:</strong> Estima as emissões baseadas no consumo mensal de energia elétrica em kWh.</li>
            <li><strong>Gás Natural e GLP:</strong> Calcula as emissões diretas do consumo mensal de gás natural (m³) ou GLP (kg) em diferentes aplicações.</li>
            <li><strong>Gases Refrigerantes:</strong> Contabiliza as emissões fugitivas anuais de gases refrigerantes com alto potencial de aquecimento global.</li>
            <li><strong>Processos Industriais:</strong> Estima as emissões mensais de processos específicos como calcinação, produção de metais, vidro, etc.</li>
            <li><strong>Produção:</strong> Calcula as emissões associadas à produção mensal de bens ou serviços.</li>
        </ul>
    </div>

    <!-- Seção de Fontes e Referências -->
    <div class="fontes-container">
        <h3 class="subtitulo">Fontes e Referências Oficiais</h3>
        <div class="fontes-grid">
            <div class="fonte-item">
                <h4>Programa Brasileiro GHG Protocol (FGV)</h4>
                <p>Metodologia oficial para inventários corporativos de GEE no Brasil</p>
                <a href="https://eaesp.fgv.br/centros/centro-estudos-sustentabilidade/projetos/programa-brasileiro-ghg-protocol" target="_blank" class="fonte-link">Acessar fonte</a>
            </div>
            
            <div class="fonte-item">
                <h4>CETESB - Companhia Ambiental do Estado de São Paulo</h4>
                <p>Notas técnicas sobre quantificação de emissões</p>
                <a href="https://cetesb.sp.gov.br/proclima/" target="_blank" class="fonte-link">Acessar fonte</a>
            </div>
            
            <div class="fonte-item">
                <h4>Ministério da Ciência, Tecnologia e Inovações (MCTI)</h4>
                <p>Inventário Nacional de Emissões</p>
                <a href="https://www.gov.br/mcti/pt-br/acompanhe-o-mcti/sirene" target="_blank" class="fonte-link">Acessar fonte</a>
            </div>
            
            <div class="fonte-item">
                <h4>Ministério do Meio Ambiente (MMA)</h4>
                <p>Programa Brasileiro de Eliminação dos HCFCs</p>
                <a href="https://www.gov.br/mma/pt-br/assuntos/mudanca-do-clima/ozonio" target="_blank" class="fonte-link">Acessar fonte</a>
            </div>
            
            <div class="fonte-item">
                <h4>B3 - Brasil, Bolsa, Balcão</h4>
                <p>Inventário de Emissões de Gases de Efeito Estufa</p>
                <a href="https://www.b3.com.br/pt_br/b3/sustentabilidade/" target="_blank" class="fonte-link">Acessar fonte</a>
            </div>
            
            <div class="fonte-item">
                <h4>ABNT NBR ISO 14064</h4>
                <p>Norma brasileira para quantificação e elaboração de relatórios de emissões de gases de efeito estufa</p>
                <a href="https://www.abnt.org.br/" target="_blank" class="fonte-link">Acessar fonte</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Para a finalidade do gás
        const selectFinalidadeGas = document.getElementById('outro_gas');
        const divOutroGas = document.getElementById('outro_gas_div');
        
        if (selectFinalidadeGas && divOutroGas) {
            selectFinalidadeGas.addEventListener('change', function() {
                divOutroGas.style.display = this.checked ? 'block' : 'none';
            });
            // Inicializar estado
            if (selectFinalidadeGas.checked) {
                divOutroGas.style.display = 'block';
            }
        }
        
        // Para reposição de gases refrigerantes
        const radioReposicaoSim = document.getElementById('reposicao-sim');
        const radioReposicaoNao = document.getElementById('reposicao-nao');
        const divReposicaoDetails = document.getElementById('reposicao_details');
        
        if (radioReposicaoSim && divReposicaoDetails) {
            radioReposicaoSim.addEventListener('change', function() {
                divReposicaoDetails.style.display = this.checked ? 'block' : 'none';
            });
            // Inicializar estado
            if (radioReposicaoSim.checked) {
                divReposicaoDetails.style.display = 'block';
            }
        }
        
        if (radioReposicaoNao && divReposicaoDetails) {
            radioReposicaoNao.addEventListener('change', function() {
                divReposicaoDetails.style.display = 'none';
            });
        }
        
        // Para processos industriais
        const checkboxProcessos = document.querySelectorAll('.processo-check');
        const checkboxNenhum = document.getElementById('nenhum');
        const divProcessosDetails = document.getElementById('processos_details');
        
        function updateProcessosDetails() {
            let algumProcessoMarcado = false;
            checkboxProcessos.forEach(function(checkbox) {
                if (checkbox.checked) {
                    algumProcessoMarcado = true;
                }
            });
            
            divProcessosDetails.style.display = algumProcessoMarcado ? 'block' : 'none';
        }
        
        if (checkboxProcessos.length > 0 && checkboxNenhum && divProcessosDetails) {
            // Inicializar estado
            updateProcessosDetails();
            
            // Adicionar event listeners
            checkboxProcessos.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxNenhum.checked = false;
                    }
                    updateProcessosDetails();
                });
            });
            
            checkboxNenhum.addEventListener('change', function() {
                if (this.checked) {
                    checkboxProcessos.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                    divProcessosDetails.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush
