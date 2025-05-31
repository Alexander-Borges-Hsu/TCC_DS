<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FormularioController extends Controller
{
    /**
     * Exibe o formulário inicial
     */
    public function index()
    {
        return view('formularioUm');
    }

    /**
     * Processa os dados do formulário e redireciona para a calculadora
     */
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'cnpj' => 'required|string',
            'nome_empresa' => 'required|string',
            'endereco' => 'required|string',
            'ramo_atividade' => 'required|string',
            'num_funcionarios' => 'required|numeric',
            'monitoramento' => 'required|in:sim,nao',
            'fontes' => 'required|array',
            'certificacoes' => 'required|in:sim,nao',
            'reducao_carbono' => 'required|in:sim,nao',
            'pegada_carbono' => 'required|in:sim,nao',
            'matriz_energetica' => 'required|string',
        ]);

        // Obter o usuário autenticado
        $user = Auth::user();

        // Preparar os dados para armazenamento em JSON
        $formData = [
            'empresa' => [
                'cnpj' => $request->cnpj,
                'nome' => $request->nome_empresa,
                'endereco' => $request->endereco,
                'ramo_atividade' => $request->ramo_atividade,
                'num_funcionarios' => $request->num_funcionarios,
            ],
            'sustentabilidade' => [
                'monitoramento_co2' => $request->monitoramento,
                'fontes_emissao' => $request->fontes,
                'certificacoes' => $request->certificacoes,
                'acoes_reducao' => $request->reducao_carbono,
                'calculo_pegada' => $request->pegada_carbono,
                'matriz_energetica' => $request->matriz_energetica,
            ],
            'data_registro' => now()->format('Y-m-d H:i:s'),
        ];

        // Armazenar os dados no campo co2_data do usuário
        if (!$user->co2_data) {
            $user->co2_data = json_encode(['formulario_um' => $formData]);
        } else {
            $userData = json_decode($user->co2_data, true) ?: [];
            $userData['formulario_um'] = $formData;
            $user->co2_data = json_encode($userData);
        }

        // Salvar as alterações
        $user->save();

        // Redirecionar para a calculadora
        return redirect()->route('calculadora.index')->with('success', 'Dados empresariais registrados com sucesso! Agora vamos calcular suas emissões de CO₂.');
    }
}
