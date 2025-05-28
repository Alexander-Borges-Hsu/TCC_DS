<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
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
        $co2_meta = 1000; // Meta padrão, pode ser personalizada no futuro
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
            'data_registro'
        ));
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
