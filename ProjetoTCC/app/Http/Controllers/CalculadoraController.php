<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CalculadoraController extends Controller
{
    /**
     * Exibe o formulário da calculadora.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view("calculadora");
    }

    /**
     * Processa os dados submetidos pela calculadora, calcula CO2 e salva em JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function calcular(Request $request)
    {
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Iniciando cálculo.", ["request_data" => $request->all()]);

        // 1. Validação
        $validator = Validator::make($request->all(), [
            "distancia" => "required|numeric|min:0",
            "consumo_combustivel" => "required|numeric|min:0.1",
            "tipo_combustivel" => "required|string|in:gasolina,diesel,etanol",
            "consumo_energia" => "nullable|numeric|min:0",
            "producao" => "nullable|numeric|min:0",
        ]);

        if ($validator->fails()) {
            Log::error("[VerdeCalc Log] CalculadoraController@calcular: Falha na validação.", ["errors" => $validator->errors()]);
            return redirect()->route("calculadora.index")
                        ->withErrors($validator)
                        ->withInput();
        }
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Validação passou.");

        // 2. Fatores de emissão
        $fatores = [
            "gasolina" => 2.31,
            "diesel" => 2.68,
            "etanol" => 1.18,
            "gnv" => 1.96,
            "energia" => 0.09,
            "producao" => 0.5,
        ];

        // 3. Cálculos
        $consumo_total_combustivel = ($request->input("distancia") / 100) * $request->input("consumo_combustivel");
        $emissao_transporte = $consumo_total_combustivel * $fatores[$request->input("tipo_combustivel")];
        $emissao_energia = ($request->input("consumo_energia") ?? 0) * $fatores["energia"];
        $emissao_producao = ($request->input("producao") ?? 0) * $fatores["producao"];
        $co2_consumido = $emissao_transporte + $emissao_energia + $emissao_producao;

        // Obter unidades produzidas (importante para cálculo de intensidade de carbono)
        $unidades_produzidas = $request->input("producao") ?? 0;

        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Cálculos intermediários.", [
            "consumo_total_combustivel" => $consumo_total_combustivel,
            "emissao_transporte" => $emissao_transporte,
            "emissao_energia" => $emissao_energia,
            "emissao_producao" => $emissao_producao,
            "co2_consumido_bruto" => $co2_consumido,
            "unidades_produzidas" => $unidades_produzidas
        ]);

        // 4. Meta - Definida com base no volume de produção e tipo de operação
        // Determinar o porte da empresa com base nas unidades produzidas
        if ($unidades_produzidas <= 10) {
            $porte_empresa = "pequena";
        } elseif ($unidades_produzidas <= 50) {
            $porte_empresa = "media";
        } else {
            $porte_empresa = "grande";
        }
        
        // Definir meta base por porte
        $metas_base_por_porte = [
            "pequena" => 50,
            "media" => 100,
            "grande" => 200
        ];
        
        // Calcular meta ajustada com base na produção
        $meta_base = $metas_base_por_porte[$porte_empresa];
        
        // Se houver produção, ajustar a meta proporcionalmente
        if ($unidades_produzidas > 0) {
            // Fator de ajuste: 5kg por unidade para pequena, 3kg para média, 2kg para grande
            $fatores_ajuste = [
                "pequena" => 5,
                "media" => 3,
                "grande" => 2
            ];
            
            $fator_ajuste = $fatores_ajuste[$porte_empresa];
            $co2_meta = max($meta_base, $unidades_produzidas * $fator_ajuste);
        } else {
            // Se não houver produção, usar a meta base
            $co2_meta = $meta_base;
        }
        
        // Arredondar para duas casas decimais
        $co2_meta = round($co2_meta, 2);
        
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Meta calculada.", [
            "porte_empresa" => $porte_empresa,
            "meta_base" => $meta_base,
            "unidades_produzidas" => $unidades_produzidas,
            "co2_meta" => $co2_meta
        ]);
        
        // 5. Percentual da meta - Corrigido para ser mais realista
        // Se o consumo for menor que a meta, o percentual é a proporção do consumo em relação à meta
        // Se o consumo for maior que a meta, o percentual é limitado a 100%
        if ($co2_consumido <= $co2_meta) {
            $percentual_meta = $co2_meta > 0 ? round(($co2_consumido / $co2_meta) * 100) : 0;
        } else {
            // Limitamos a 100% para o gráfico, mas guardamos o valor real para cálculos
            $percentual_meta_real = $co2_meta > 0 ? round(($co2_consumido / $co2_meta) * 100) : 0;
            $percentual_meta = 100;
        }

        // 6. Fonte principal
        $fontes = [
            "Transporte" => $emissao_transporte,
            "Energia Elétrica" => $emissao_energia,
            "Produção Industrial/Serviços" => $emissao_producao
        ];
        $fonte_principal = "Nenhuma";
        if (max($fontes) > 0) {
             $fonte_principal = array_search(max($fontes), $fontes);
        }
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Fonte principal determinada.", ["fonte" => $fonte_principal]);

        // 7. Calcular pontuação de sustentabilidade (0-100)
        // Quanto menor o percentual da meta consumido, maior a pontuação
        if ($co2_consumido <= $co2_meta) {
            // Se estiver dentro da meta, a pontuação é proporcional ao quanto está abaixo
            $pontuacao = 100 - $percentual_meta;
            // Ajustar para uma escala de 50-100 (mesmo consumindo toda a meta, ainda tem 50 pontos)
            $pontuacao = 50 + ($pontuacao / 2);
        } else {
            // Se estiver acima da meta, a pontuação diminui mais rapidamente
            $excesso_percentual = ($co2_consumido - $co2_meta) / $co2_meta * 100;
            // Limitar o excesso para cálculo da pontuação
            $excesso_percentual = min($excesso_percentual, 100);
            // Pontuação diminui de 50 até 0 conforme o excesso aumenta
            $pontuacao = max(0, 50 - ($excesso_percentual / 2));
        }
        
        // Garantir que a pontuação nunca seja nula e arredondar
        $pontuacao = max(1, round($pontuacao, 1));
        
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Pontuação calculada.", [
            "co2_consumido" => $co2_consumido,
            "co2_meta" => $co2_meta,
            "percentual_meta" => $percentual_meta,
            "pontuacao" => $pontuacao
        ]);

        // 8. Salva os dados em JSON
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Tentando obter usuário autenticado.");
        $usuario = Auth::user();
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Verificando usuário autenticado.", ["user_id" => $usuario ? $usuario->id : "NÃO ENCONTRADO"]);

        if ($usuario) {
            try {
                // Preparar dados para salvar em JSON
                $co2Data = [
                    "user_id" => $usuario->id,
                    "co2_total" => round($co2_consumido, 2),
                    "co2_meta" => $co2_meta,
                    "percentual_meta" => $percentual_meta,
                    "percentual_meta_real" => $percentual_meta_real ?? $percentual_meta,
                    "pontuacao" => $pontuacao,
                    "data_calculo" => Carbon::now()->format('Y-m-d'),
                    "co2_transporte" => round($emissao_transporte, 2),
                    "co2_energia" => round($emissao_energia, 2),
                    "co2_producao" => round($emissao_producao, 2),
                    "unidades_produzidas" => $unidades_produzidas,
                    "porte_empresa" => $porte_empresa,
                    "fonte_emissao" => $fonte_principal,
                    "observacoes_co2" => sprintf(
                        "Cálculo (%s): Transporte=%.2fkg (%.1fkm, %.1fL/100km, %s); Energia=%.2fkg (%.1fkWh); Produção=%.2fkg (%d unidades).",
                        Carbon::now()->format("d/m/Y"),
                        $emissao_transporte,
                        $request->input("distancia"),
                        $request->input("consumo_combustivel"),
                        $request->input("tipo_combustivel"),
                        $emissao_energia,
                        $request->input("consumo_energia") ?? 0,
                        $emissao_producao,
                        $unidades_produzidas
                    ),
                    "updated_at" => Carbon::now()->format('Y-m-d')
                ];
                
                Log::info("[VerdeCalc Log] CalculadoraController@calcular: Dados a serem salvos em JSON.", ["user_id" => $usuario->id, "co2_data" => $co2Data]);

                // Atualizar o campo co2_data do usuário
                $usuario->co2_data = json_encode($co2Data);
                $usuario->save();
                
                // Criar diretório para armazenar arquivos JSON se não existir (backup)
                $jsonDir = storage_path('app/co2_data');
                if (!file_exists($jsonDir)) {
                    mkdir($jsonDir, 0755, true);
                }
                
                // Salvar dados em arquivo JSON específico para o usuário (backup)
                $jsonFilePath = storage_path('app/co2_data/user_' . $usuario->id . '_co2_data.json');
                file_put_contents($jsonFilePath, json_encode($co2Data, JSON_PRETTY_PRINT));
                
                Log::info("[VerdeCalc Log] CalculadoraController@calcular: Dados salvos com sucesso em JSON.", [
                    "user_id" => $usuario->id, 
                    "json_file" => $jsonFilePath
                ]);

            } catch (\Exception $e) {
                Log::error("[VerdeCalc Log] CalculadoraController@calcular: Exceção ao salvar dados em JSON.", [
                    "user_id" => $usuario->id, 
                    "error" => $e->getMessage(), 
                    "trace" => $e->getTraceAsString()
                ]);
                
                return redirect()->route("calculadora.index")
                            ->with("error", "Erro ao salvar os dados do cálculo: " . $e->getMessage())
                            ->withInput();
            }
        } else {
            Log::warning("[VerdeCalc Log] CalculadoraController@calcular: Usuário não autenticado, cálculo não será salvo.");
            return redirect()->route("calculadora.index")
                        ->with("error", "Usuário não autenticado. Faça login para salvar o cálculo.")
                        ->withInput();
        }

        // 9. Redireciona
        Log::info("[VerdeCalc Log] CalculadoraController@calcular: Redirecionando para relatório.", ["user_id" => $usuario->id]);
        return redirect()->route("relatorio.index")
                    ->with("success", "Cálculo de CO₂ realizado e salvo com sucesso!");
    }
}
