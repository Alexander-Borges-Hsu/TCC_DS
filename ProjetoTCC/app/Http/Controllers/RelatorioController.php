<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
    /**
     * Fatores de intensidade de carbono por setor (kg CO2 por unidade de produção)
     * Valores baseados em médias setoriais e recomendações da SBTi
     */
    private $fatores_setor = [
        'industria' => [
            'alimentos_bebidas' => 1500,
            'textil' => 1200,
            'quimica' => 2500,
            'metalurgia' => 3000,
            'papel_celulose' => 2000,
            'construcao' => 1800,
            'eletroeletronicos' => 1000,
            'moveis' => 1100,
            'farmaceutica' => 1300,
            'automotiva' => 2200,
            'outros' => 1500
        ],
        'servicos' => [
            'comercio' => 800,
            'financeiro' => 500,
            'educacao' => 600,
            'saude' => 900,
            'tecnologia' => 700,
            'transporte' => 1200,
            'turismo' => 850,
            'alimentacao' => 950,
            'consultoria' => 450,
            'outros' => 800
        ],
        'agropecuaria' => [
            'agricultura' => 1700,
            'pecuaria' => 2200,
            'silvicultura' => 1500,
            'pesca' => 1600,
            'outros' => 1800
        ]
    ];

    /**
     * Fatores de escala por porte da empresa
     * Baseados em capacidade e responsabilidade proporcional
     */
    private $fatores_porte = [
        'micro' => 0.5,    // Até 9 funcionários
        'pequena' => 0.8,  // 10-49 funcionários
        'media' => 1.2,    // 50-249 funcionários
        'grande' => 1.5    // 250+ funcionários
    ];

    /**
     * Exibe a página do relatório
     */
    public function index()
    {
        // Obter dados do usuário
        $user = Auth::user();
        $userData = json_decode($user->co2_data ?? '{}', true);
        
        // Verificar se existe um cálculo atual
        if (!isset($userData['calculo_atual'])) {
            return redirect()->route('calculadora.index')
                ->with('error', 'Por favor, realize um cálculo de emissão primeiro.');
        }
        
        $calculo = $userData['calculo_atual'];
        $formData = $userData['formulario_um'] ?? null;
        
        // Preparar dados para o relatório
        $co2_consumido = $calculo['resultados']['emissao_total'];
        
        // Calcular meta contextualizada em vez de usar valor fixo
        $meta_info = $this->calcularMetaContextualizada($userData);
        $co2_meta = $meta_info['meta'];
        
        $percentual_bruto = ($co2_consumido / $co2_meta) * 100;
        // Garantir que nunca ultrapasse 100% e arredondar para 2 casas decimais
        $percentual_meta = round(min(100, $percentual_bruto), 2); 
        $reducao_necessaria = $co2_consumido > $co2_meta ? $co2_consumido - $co2_meta : 0;
        
        // Definir status com base no percentual da meta
        if ($percentual_meta <= 30) {
            $status_co2 = [
                'texto' => 'Excelente',
                'cor' => '#10b981', // Verde
                'icone' => 'fa-check-circle',
                'descricao' => 'Sua empresa tem um impacto ambiental mínimo. Continue com as boas práticas!'
            ];
        } elseif ($percentual_meta <= 60) {
            $status_co2 = [
                'texto' => 'Bom',
                'cor' => '#3b82f6', // Azul
                'icone' => 'fa-thumbs-up',
                'descricao' => 'Sua empresa tem um impacto ambiental moderado. Pequenos ajustes podem melhorar ainda mais.'
            ];
        } elseif ($percentual_meta <= 85) {
            $status_co2 = [
                'texto' => 'Atenção',
                'cor' => '#f59e0b', // Amarelo
                'icone' => 'fa-exclamation-circle',
                'descricao' => 'Sua empresa tem um impacto ambiental significativo. Ações de redução são recomendadas.'
            ];
        } else {
            $status_co2 = [
                'texto' => 'Crítico',
                'cor' => '#ef4444', // Vermelho
                'icone' => 'fa-exclamation-triangle',
                'descricao' => 'Sua empresa tem um impacto ambiental elevado. Ações imediatas são necessárias.'
            ];
        }
        
        // Calcular impacto ambiental equivalente
        $impacto_ambiental = [
            'arvores_necessarias' => round($co2_consumido / 22), // Uma árvore absorve cerca de 22kg de CO2 por ano
            'km_carro' => round($co2_consumido / 0.12), // 0.12kg CO2 por km (média)
            'meses_energia_casa' => round($co2_consumido / 100) // 100kg CO2 por mês (média residencial)
        ];
        
        // Calcular métricas avançadas
        $intensidade_carbono = 0;
        if (isset($calculo['entradas']['producao']) && $calculo['entradas']['producao'] > 0) {
            $intensidade_carbono = round($co2_consumido / $calculo['entradas']['producao'], 2);
        }
        
        // Pontuação de sustentabilidade (0-100)
        $pontuacao = 100 - min(100, $percentual_meta);
        
        // Dados de emissão por fonte
        $emissao_transporte = $calculo['resultados']['emissao_transporte'];
        $emissao_energia = $calculo['resultados']['emissao_energia'];
        $emissao_producao = $calculo['resultados']['emissao_producao'];
        
        // Fonte principal de emissão
        $fonte_emissao = $calculo['resultados']['fonte_principal'];
        
        // Dicas de redução baseadas na fonte principal
        $dicas_reducao = [];
        
        if ($fonte_emissao == 'Transporte') {
            $dicas_reducao = [
                'Otimize rotas de transporte para reduzir distâncias percorridas',
                'Considere a transição para veículos elétricos ou híbridos',
                'Implemente programas de carona compartilhada para funcionários',
                'Realize manutenção regular da frota para melhorar a eficiência',
                'Treine motoristas em técnicas de condução econômica'
            ];
        } elseif ($fonte_emissao == 'Energia Elétrica') {
            $dicas_reducao = [
                'Invista em painéis solares ou outras fontes de energia renovável',
                'Substitua equipamentos antigos por modelos mais eficientes energeticamente',
                'Implemente sistemas de iluminação LED e sensores de presença',
                'Estabeleça políticas de desligamento de equipamentos fora do horário de trabalho',
                'Melhore o isolamento térmico do edifício para reduzir custos de climatização'
            ];
        } else { // Produção
            $dicas_reducao = [
                'Otimize processos produtivos para reduzir desperdícios',
                'Invista em tecnologias mais limpas e eficientes',
                'Implemente sistemas de gestão ambiental (ISO 14001)',
                'Considere a economia circular e reutilização de materiais',
                'Treine funcionários em práticas sustentáveis de produção'
            ];
        }
        
        // Data do registro
        $data_registro = date('d/m/Y', strtotime($calculo['data_calculo']));
        
        // Adicionar informações sobre a meta contextualizada
        $meta_contextualizada = [
            'info' => $meta_info,
            'explicacao' => $this->gerarExplicacaoMeta($meta_info)
        ];
        
        // Passar todos os dados para a view
        return view('geradorRelatorios', compact(
            'co2_consumido',
            'co2_meta',
            'percentual_meta',
            'reducao_necessaria',
            'status_co2',
            'impacto_ambiental',
            'intensidade_carbono',
            'pontuacao',
            'emissao_transporte',
            'emissao_energia',
            'emissao_producao',
            'fonte_emissao',
            'dicas_reducao',
            'data_registro',
            'meta_contextualizada' // Nova variável com informações da meta contextualizada
        ));
    }
    
    /**
     * Calcula a meta de CO2 contextualizada com base nos dados do usuário
     * 
     * @param array $userData Dados do usuário
     * @return array Informações da meta calculada
     */
    private function calcularMetaContextualizada($userData)
    {
        // Parâmetros de configuração
        $ano_base = 2023;
        $reducao_anual = 4.2; // 4.2% de redução anual (alinhado com trajetória de 1.5°C)
        $meta_minima = 500; // Valor mínimo para meta de CO2 (kg)
        $fator_reducao_historico = 0.8; // 20% de redução em relação à média histórica
        
        // Extrair dados do perfil
        $perfil = $userData['formulario_um'] ?? [];
        
        // Determinar setor e subsetor com base nos dados do formulário
        $setor_principal = 'servicos'; // Valor padrão
        $subsetor = 'outros'; // Valor padrão
        
        // Mapear setor com base no tipo de negócio (se disponível)
        if (isset($perfil['tipo_negocio'])) {
            $tipo_negocio = strtolower($perfil['tipo_negocio']);
            
            // Mapeamento simplificado de tipo de negócio para setor
            if (strpos($tipo_negocio, 'indústria') !== false || 
                strpos($tipo_negocio, 'fabrica') !== false || 
                strpos($tipo_negocio, 'manufatura') !== false) {
                $setor_principal = 'industria';
            } elseif (strpos($tipo_negocio, 'agro') !== false || 
                     strpos($tipo_negocio, 'agricultura') !== false || 
                     strpos($tipo_negocio, 'pecuária') !== false) {
                $setor_principal = 'agropecuaria';
            } else {
                $setor_principal = 'servicos';
            }
            
            // Tentar determinar subsetor
            foreach (array_keys($this->fatores_setor[$setor_principal]) as $possivel_subsetor) {
                if ($possivel_subsetor != 'outros' && 
                    strpos($tipo_negocio, $possivel_subsetor) !== false) {
                    $subsetor = $possivel_subsetor;
                    break;
                }
            }
        }
        
        // Determinar porte com base no número de funcionários (se disponível)
        $porte_empresa = 'pequena'; // Valor padrão
        if (isset($perfil['num_funcionarios'])) {
            $num_funcionarios = intval($perfil['num_funcionarios']);
            
            if ($num_funcionarios <= 9) {
                $porte_empresa = 'micro';
            } elseif ($num_funcionarios <= 49) {
                $porte_empresa = 'pequena';
            } elseif ($num_funcionarios <= 249) {
                $porte_empresa = 'media';
            } else {
                $porte_empresa = 'grande';
            }
        }
        
        // Extrair dados de produção ou receita (se disponíveis)
        $volume_producao = 0;
        $receita_anual = 0;
        
        if (isset($userData['calculo_atual']['entradas']['producao'])) {
            $volume_producao = $userData['calculo_atual']['entradas']['producao'];
        }
        
        if (isset($perfil['receita_anual'])) {
            $receita_anual = floatval(str_replace(['R$', '.', ','], ['', '', '.'], $perfil['receita_anual']));
        }
        
        // 1. Definir meta base por setor
        if (isset($this->fatores_setor[$setor_principal][$subsetor])) {
            $co2_meta = $this->fatores_setor[$setor_principal][$subsetor];
        } else {
            $co2_meta = $this->fatores_setor[$setor_principal]['outros'] ?? 1000;
        }
        
        // 2. Ajustar por porte da empresa
        $fator_porte = $this->fatores_porte[$porte_empresa] ?? 1.0;
        $co2_meta = $co2_meta * $fator_porte;
        
        // 3. Considerar volume de produção ou receita (se disponível)
        $meta_intensidade = null;
        if ($volume_producao > 0) {
            $meta_intensidade = $co2_meta / 100; // Meta por 100 unidades
            $co2_meta = $meta_intensidade * $volume_producao;
        } elseif ($receita_anual > 0) {
            $meta_intensidade = $co2_meta / 100000; // Meta por R$ 100.000
            $co2_meta = $meta_intensidade * ($receita_anual / 1000); // Converter para milhares
        }
        
        // 4. Aplicar progressão temporal
        $ano_atual = date('Y');
        $anos_desde_base = max(0, $ano_atual - $ano_base);
        $fator_reducao_temporal = pow((100 - $reducao_anual) / 100, $anos_desde_base);
        $co2_meta = $co2_meta * $fator_reducao_temporal;
        
        // 5. Considerar histórico (se disponível)
        $meta_historica = null;
        if (isset($userData['historico_calculos']) && count($userData['historico_calculos']) > 0) {
            $ultimas_medicoes = array_slice($userData['historico_calculos'], -3);
            if (count($ultimas_medicoes) > 0) {
                $total_emissoes = 0;
                foreach ($ultimas_medicoes as $medicao) {
                    $total_emissoes += $medicao['resultados']['emissao_total'] ?? 0;
                }
                $media_emissoes = $total_emissoes / count($ultimas_medicoes);
                $meta_historica = $media_emissoes * $fator_reducao_historico;
                
                // Usar o menor valor entre a meta calculada e a meta histórica
                $co2_meta = min($co2_meta, $meta_historica);
            }
        }
        
        // 6. Garantir valor mínimo
        $co2_meta = max($co2_meta, $meta_minima);
        
        // Arredondar para inteiro
        $co2_meta = round($co2_meta);
        
        // Retornar informações da meta calculada
        return [
            'meta' => $co2_meta,
            'fatores' => [
                'setor' => $setor_principal,
                'subsetor' => $subsetor,
                'porte' => $porte_empresa,
                'fator_porte' => $fator_porte,
                'fator_reducao_temporal' => $fator_reducao_temporal,
            ],
            'meta_intensidade' => $meta_intensidade,
            'meta_historica' => $meta_historica,
            'ano_base' => $ano_base,
            'reducao_anual' => $reducao_anual,
            'volume_producao' => $volume_producao,
            'receita_anual' => $receita_anual
        ];
    }
    
    /**
     * Gera uma explicação textual sobre como a meta foi calculada
     * 
     * @param array $meta_info Informações da meta calculada
     * @return string Explicação da meta
     */
    private function gerarExplicacaoMeta($meta_info)
    {
        $fatores = $meta_info['fatores'];
        $setor = ucfirst($fatores['setor']);
        $porte = ucfirst($fatores['porte']);
        
        $explicacao = "Sua meta de CO2 foi personalizada com base no contexto da sua empresa. ";
        $explicacao .= "Consideramos que você atua no setor de <strong>{$setor}</strong> ";
        $explicacao .= "e é uma empresa de porte <strong>{$porte}</strong>. ";
        
        if ($meta_info['volume_producao'] > 0) {
            $explicacao .= "Também consideramos seu volume de produção de {$meta_info['volume_producao']} unidades. ";
        } elseif ($meta_info['receita_anual'] > 0) {
            $receita_formatada = number_format($meta_info['receita_anual'], 2, ',', '.');
            $explicacao .= "Também consideramos sua receita anual de R$ {$receita_formatada}. ";
        }
        
        $explicacao .= "A meta é atualizada anualmente com uma redução de {$meta_info['reducao_anual']}% ";
        $explicacao .= "para alinhar-se com os objetivos climáticos globais.";
        
        if ($meta_info['meta_historica'] !== null) {
            $explicacao .= " Além disso, consideramos seu histórico de emissões para definir uma meta desafiadora mas alcançável.";
        }
        
        return $explicacao;
    }
    
    /**
     * Exporta o relatório em PDF
     */
    public function exportarPDF()
    {
        // Implementação da exportação PDF
        // (mantida a implementação original)
        return redirect()->back()->with('info', 'Funcionalidade de exportação em desenvolvimento.');
    }
}
