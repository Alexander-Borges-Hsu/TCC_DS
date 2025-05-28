<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalculadoraController extends Controller
{
    /**
     * Exibe a página da calculadora
     */
    public function index()
    {
        // Obter dados do formulário do usuário (se existirem)
        $user = Auth::user();
        $userData = json_decode($user->co2_data ?? '{}', true);
        $formData = $userData['formulario_um'] ?? null;
        
        return view('calculadora', compact('formData'));
    }

    /**
     * Processa os dados da calculadora
     */
    public function calcular(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'distancia' => 'required|numeric',
            'consumo_combustivel' => 'required|numeric',
            'tipo_combustivel' => 'required|string|in:gasolina,diesel,etanol',
            'consumo_energia' => 'nullable|numeric',
            'producao' => 'nullable|numeric',
            // Validação para novas perguntas
            'consumo_gas' => 'nullable|numeric',
            'unidade_gas' => 'nullable|string|in:m3,kg',
            'finalidade_gas' => 'nullable|string',
            'finalidade_gas_outro' => 'nullable|string',
            'reposicao_gases' => 'nullable|string|in:sim,nao',
            'tipo_gas_refrigerante' => 'nullable|string',
            'quantidade_gas' => 'nullable|numeric',
            'processos' => 'nullable|array',
            'processos.*' => 'nullable|string',
            'volume_producao' => 'nullable|numeric',
        ]);

        // Fatores de emissão (kg CO2 por unidade)
        $fatores = [
            'gasolina' => 2.31, // kg CO2 por litro
            'diesel' => 2.68,   // kg CO2 por litro
            'etanol' => 1.51,   // kg CO2 por litro
            'energia' => 0.0817, // kg CO2 por kWh (média brasileira)
            'producao' => 0.5,   // kg CO2 por unidade (valor genérico)
            // Novos fatores de emissão
            'gas_natural' => 2.07, // kg CO2 por m³ (CETESB)
            'glp' => 2.93,        // kg CO2 por kg (CETESB)
            'r410a' => 2088,      // GWP (potencial de aquecimento global)
            'r22' => 1810,        // GWP
            'r134a' => 1430,      // GWP
            'r404a' => 3922,      // GWP
            'r407c' => 1774,      // GWP
            'r32' => 675,         // GWP
            'calcario' => 0.44,   // tCO2 por tonelada de calcário (MCTI)
            'metais' => 1.8,      // tCO2 por tonelada (média para aço)
            'vidro' => 0.6,       // tCO2 por tonelada
            'papel' => 0.7,       // tCO2 por tonelada
            'petroquimicos' => 2.3, // tCO2 por tonelada
            'carbonatos' => 0.5,   // tCO2 por tonelada
        ];

        // Cálculos de emissão
        $distancia = $request->distancia;
        $consumo = $request->consumo_combustivel;
        $combustivel = $request->tipo_combustivel;
        
        // Cálculo de combustível: (distância * consumo/100) = litros consumidos
        $litros = ($distancia * $consumo) / 100;
        $emissao_transporte = $litros * $fatores[$combustivel];
        
        // Cálculo de energia elétrica (se fornecido)
        $emissao_energia = 0;
        if ($request->consumo_energia) {
            $emissao_energia = $request->consumo_energia * $fatores['energia'];
        }
        
        // Cálculo de produção (se fornecido)
        $emissao_producao = 0;
        if ($request->producao) {
            $emissao_producao = $request->producao * $fatores['producao'];
        }
        
        // Cálculo de gás natural ou GLP (se fornecido)
        $emissao_gas = 0;
        if ($request->consumo_gas) {
            $fator_gas = ($request->unidade_gas == 'm3') ? $fatores['gas_natural'] : $fatores['glp'];
            $emissao_gas = $request->consumo_gas * $fator_gas;
        }
        
        // Cálculo de emissões fugitivas de gases refrigerantes (se fornecido)
        $emissao_refrigerante = 0;
        if ($request->reposicao_gases == 'sim' && $request->quantidade_gas && $request->tipo_gas_refrigerante) {
            $gwp = 0;
            switch ($request->tipo_gas_refrigerante) {
                case 'r410a':
                    $gwp = $fatores['r410a'];
                    break;
                case 'r22':
                    $gwp = $fatores['r22'];
                    break;
                case 'r134a':
                    $gwp = $fatores['r134a'];
                    break;
                case 'r404a':
                    $gwp = $fatores['r404a'];
                    break;
                case 'r407c':
                    $gwp = $fatores['r407c'];
                    break;
                case 'r32':
                    $gwp = $fatores['r32'];
                    break;
                default:
                    $gwp = 1000; // Valor médio para outros gases
            }
            $emissao_refrigerante = $request->quantidade_gas * $gwp;
        }
        
        // Cálculo de processos industriais (se fornecido)
        $emissao_processos = 0;
        if ($request->processos && !in_array('nenhum', $request->processos) && $request->volume_producao) {
            $fator_processo = 0;
            
            // Calcular o fator médio com base nos processos selecionados
            $processos_count = 0;
            foreach ($request->processos as $processo) {
                if (isset($fatores[$processo])) {
                    $fator_processo += $fatores[$processo];
                    $processos_count++;
                }
            }
            
            if ($processos_count > 0) {
                $fator_processo = $fator_processo / $processos_count;
                $emissao_processos = $request->volume_producao * $fator_processo * 1000; // Converter de tCO2 para kgCO2
            }
        }
        
        // Emissão total
        $emissao_total = $emissao_transporte + $emissao_energia + $emissao_producao + 
                         $emissao_gas + $emissao_refrigerante + $emissao_processos;
        
        // Determinar a fonte principal de emissão
        $fontes = [
            'Transporte' => $emissao_transporte,
            'Energia Elétrica' => $emissao_energia,
            'Produção' => $emissao_producao,
            'Gás Natural/GLP' => $emissao_gas,
            'Gases Refrigerantes' => $emissao_refrigerante,
            'Processos Industriais' => $emissao_processos
        ];
        
        arsort($fontes);
        $fonte_principal = key($fontes);
        
        // Armazenar os resultados no usuário
        $user = Auth::user();
        $userData = json_decode($user->co2_data ?? '{}', true);
        
        $calculoData = [
            'data_calculo' => now()->format('Y-m-d H:i:s'),
            'entradas' => [
                'distancia' => $distancia,
                'consumo_combustivel' => $consumo,
                'tipo_combustivel' => $combustivel,
                'consumo_energia' => $request->consumo_energia,
                'producao' => $request->producao,
                'consumo_gas' => $request->consumo_gas,
                'unidade_gas' => $request->unidade_gas,
                'finalidade_gas' => $request->finalidade_gas,
                'reposicao_gases' => $request->reposicao_gases,
                'tipo_gas_refrigerante' => $request->tipo_gas_refrigerante,
                'quantidade_gas' => $request->quantidade_gas,
                'processos' => $request->processos,
                'volume_producao' => $request->volume_producao,
            ],
            'resultados' => [
                'emissao_transporte' => round($emissao_transporte, 2),
                'emissao_energia' => round($emissao_energia, 2),
                'emissao_producao' => round($emissao_producao, 2),
                'emissao_gas' => round($emissao_gas, 2),
                'emissao_refrigerante' => round($emissao_refrigerante, 2),
                'emissao_processos' => round($emissao_processos, 2),
                'emissao_total' => round($emissao_total, 2),
                'fonte_principal' => $fonte_principal,
            ]
        ];
        
        $userData['calculo_atual'] = $calculoData;
        
        // Adicionar ao histórico de cálculos
        if (!isset($userData['historico_calculos'])) {
            $userData['historico_calculos'] = [];
        }
        
        $userData['historico_calculos'][] = $calculoData;
        
        // Salvar no usuário
        $user->co2_data = json_encode($userData);
        $user->save();
        
        // Redirecionar para a página de relatório
        return redirect()->route('relatorio.index')->with('success', 'Cálculo de emissão realizado com sucesso!');
    }
}
