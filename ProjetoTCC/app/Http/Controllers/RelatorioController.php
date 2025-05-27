<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RelatorioController extends Controller
{
    /**
     * Exibe o relatório de emissões de CO2
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Obtém o usuário autenticado
        $user = Auth::user();
        
        // Verifica se o usuário tem dados de CO2 armazenados
        if (!$user || !$user->co2_data) {
            return redirect()->route('calculadora.index')->with('error', 'Você precisa calcular suas emissões primeiro.');
        }
        
        // Decodifica os dados de CO2 do JSON
        $co2Data = json_decode($user->co2_data, true);
        
        if (!$co2Data) {
            return redirect()->route('calculadora.index')->with('error', 'Dados de emissão inválidos. Por favor, calcule novamente.');
        }
        
        // Log para debug
        Log::info("[VerdeCalc Log] RelatorioController@index: Dados CO2 decodificados", ["co2_data" => $co2Data]);
        
        // Extrai os valores principais
        $co2_consumido = number_format($co2Data['co2_total'] ?? 0, 2, ',', '.');
        $co2_meta = number_format($co2Data['co2_meta'] ?? 0, 2, ',', '.');
        $percentual_meta = intval($co2Data['percentual_meta'] ?? 0);
        $data_registro = isset($co2Data['data_calculo']) ? Carbon::parse($co2Data['data_calculo'])->format('d/m/Y') : Carbon::now()->format('d/m/Y');
        
        // Extrai os valores de emissão por fonte
        $emissao_transporte = number_format($co2Data['co2_transporte'] ?? 0, 2, ',', '.');
        $emissao_energia = number_format($co2Data['co2_energia'] ?? 0, 2, ',', '.');
        $emissao_producao = number_format($co2Data['co2_producao'] ?? 0, 2, ',', '.');
        
        // Calcula a redução necessária se estiver acima da meta
        $reducao_necessaria = 0;
        if (isset($co2Data['co2_total']) && isset($co2Data['co2_meta']) && $co2Data['co2_total'] > $co2Data['co2_meta']) {
            $reducao_necessaria = number_format(($co2Data['co2_total'] - $co2Data['co2_meta']), 2, ',', '.');
        }
        
        // Determina a fonte principal de emissão
        $fonte_emissao = $co2Data['fonte_emissao'] ?? 'Transporte';
        
        // Obtém métricas avançadas
        $unidades_produzidas = $co2Data['unidades_produzidas'] ?? 0;
        
        // Intensidade de carbono (emissão por unidade produzida)
        $intensidade_carbono = $unidades_produzidas > 0
            ? number_format(($co2Data['co2_total'] ?? 0) / $unidades_produzidas, 2, ',', '.')
            : "0,00";
        
        // Obtém pontuação de sustentabilidade (já calculada no CalculadoraController)
        $pontuacao = isset($co2Data['pontuacao']) 
            ? number_format($co2Data['pontuacao'], 1, ',', '.') 
            : "50,0"; // Valor padrão se não existir
        
        // Calcula equivalências de impacto ambiental
        $impacto_ambiental = [
            'arvores_necessarias' => ceil(($co2Data['co2_total'] ?? 0) / 22), // Uma árvore absorve cerca de 22kg de CO2 por ano
            'km_carro' => ceil(($co2Data['co2_total'] ?? 0) * 6), // Aproximadamente 166g de CO2 por km (6km por kg)
            'meses_energia_casa' => ceil(($co2Data['co2_total'] ?? 0) / 100) // Aproximadamente 100kg de CO2 por mês em uma casa média
        ];
        
        // Define dicas de redução baseadas na fonte principal
        $dicas_reducao = $this->getDicasReducao($fonte_emissao);
        
        // Define o status baseado no percentual da meta
        $status_co2 = $this->getStatusCO2($percentual_meta);
        
        // Dados para o gráfico
        $dadosGrafico = [
            'percentualMeta' => $percentual_meta,
            'statusCor' => $status_co2['cor']
        ];
        
        // Log para debug das métricas avançadas
        Log::info("[VerdeCalc Log] RelatorioController@index: Métricas avançadas calculadas", [
            "intensidade_carbono" => $intensidade_carbono,
            "pontuacao" => $pontuacao,
            "unidades_produzidas" => $unidades_produzidas,
            "emissao_transporte" => $emissao_transporte,
            "emissao_energia" => $emissao_energia,
            "emissao_producao" => $emissao_producao
        ]);
        
        return view('geradorRelatorios', compact(
            'co2_consumido',
            'co2_meta',
            'percentual_meta',
            'data_registro',
            'emissao_transporte',
            'emissao_energia',
            'emissao_producao',
            'reducao_necessaria',
            'fonte_emissao',
            'intensidade_carbono',
            'pontuacao',
            'impacto_ambiental',
            'dicas_reducao',
            'status_co2',
            'dadosGrafico'
        ));
    }
    
    /**
     * Retorna o status baseado no percentual da meta
     * 
     * @param int $percentual Percentual da meta atingido
     * @return array Informações de status (texto, cor, ícone, descrição)
     */
    private function getStatusCO2($percentual)
    {
        if ($percentual <= 40) {
            return [
                'texto' => 'Excelente',
                'cor' => '#22c55e',
                'icone' => 'fa-circle-check',
                'descricao' => 'Sua empresa está bem abaixo da meta de emissão de CO₂. Continue com as boas práticas!'
            ];
        } elseif ($percentual <= 70) {
            return [
                'texto' => 'Bom',
                'cor' => '#84cc16',
                'icone' => 'fa-thumbs-up',
                'descricao' => 'Sua empresa está dentro da meta de emissão de CO₂. Continue monitorando para manter o bom desempenho.'
            ];
        } elseif ($percentual <= 90) {
            return [
                'texto' => 'Regular',
                'cor' => '#f59e0b',
                'icone' => 'fa-exclamation-triangle',
                'descricao' => 'Sua empresa está próxima do limite da meta de emissão de CO₂. Considere implementar algumas medidas de redução.'
            ];
        } else {
            return [
                'texto' => 'Ruim',
                'cor' => '#ef4444',
                'icone' => 'fa-circle-exclamation',
                'descricao' => 'Sua empresa está no limite ou acima da meta de emissão de CO₂. Ações são necessárias para reduzir as emissões.'
            ];
        }
    }
    
    /**
     * Retorna dicas de redução baseadas na fonte principal
     * 
     * @param string $fonte Nome da fonte principal de emissão
     * @return array Lista de dicas de redução
     */
    private function getDicasReducao($fonte)
    {
        $dicas = [
            'Transporte' => [
                'Implemente um programa de conscientização ambiental para funcionários',
                'Considere a compensação de carbono através do plantio de árvores',
                'Estabeleça metas progressivas de redução de emissões',
                'Incentive o uso de transporte público ou caronas entre funcionários',
                'Considere a adoção de veículos elétricos ou híbridos para a frota da empresa',
                'Otimize rotas de entrega e logística para reduzir distâncias percorridas'
            ],
            'Energia Elétrica' => [
                'Implemente um programa de conscientização ambiental para funcionários',
                'Considere a compensação de carbono através do plantio de árvores',
                'Estabeleça metas progressivas de redução de emissões',
                'Invista em equipamentos com maior eficiência energética',
                'Considere a instalação de painéis solares ou outras fontes de energia renovável',
                'Implemente sistemas de automação para otimizar o consumo de energia'
            ],
            'Produção Industrial/Serviços' => [
                'Implemente um programa de conscientização ambiental para funcionários',
                'Considere a compensação de carbono através do plantio de árvores',
                'Estabeleça metas progressivas de redução de emissões',
                'Otimize processos produtivos para reduzir desperdícios',
                'Invista em tecnologias mais limpas e eficientes',
                'Considere a adoção de práticas de economia circular'
            ]
        ];
        
        return $dicas[$fonte] ?? $dicas['Transporte'];
    }
}
