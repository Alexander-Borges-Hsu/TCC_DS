<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Necessário para o método indexRelatorio
use App\models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon; // Necessário para manipulação de datas no relatório
use Illuminate\Support\Facades\View; // Para verificar se a view existe

class EventController extends Controller
{
    public function index(){
        return view("telaInicial");
    }

    // Modificado para aceitar Request e tratar a página de relatório
    public function navegar(Request $request, $page){
        $protectedLog = ["welcome"];
        $protectedUnLog = ["editarPerfil", "formularioUm"];

        if(in_array($page, $protectedLog) && Auth::check()){ 
            return redirect("/");
        } elseif(in_array($page, $protectedUnLog) && !Auth::check()){
            return redirect("/navegar/welcome");
        } 
        else{
            if (View::exists($page)) {
                return view($page);
            }
            abort(404, "View [{$page}] não encontrada."); // Página não encontrada
        }
    }

    // Método para exibir o relatório (lógica movida para cá)
    public function indexRelatorio(Request $request)
    {
        // Define as datas de filtro padrão (últimos 7 dias se não especificado)
        $filtro_inicio = $request->input("inicio", Carbon::now()->subDays(6)->toDateString()); // 6 dias atrás + hoje = 7 dias
        $filtro_fim = $request->input("fim", Carbon::now()->toDateString());
        $periodo_selecionado = $request->input("periodo");

        // Ajusta as datas com base no período pré-definido, se houver
        if ($periodo_selecionado && $periodo_selecionado !== "personalizado") {
            if ($periodo_selecionado === "7dias") {
                $filtro_inicio = Carbon::now()->subDays(6)->toDateString();
                $filtro_fim = Carbon::now()->toDateString();
            } elseif ($periodo_selecionado === "30dias") {
                $filtro_inicio = Carbon::now()->subDays(29)->toDateString();
                $filtro_fim = Carbon::now()->toDateString();
            }
        }

        // Simulação de dados do banco de dados (dados fictícios)
        $co2_consumido_total_ficticio = rand(50, 200); // Consumo varia
        $co2_meta_ficticio = 100; // Meta fixa para exemplo

        $dadosRelatorio = [
            "co2_consumido_total" => $co2_consumido_total_ficticio,
            "co2_meta" => $co2_meta_ficticio,
            "avaliacao_verdecalk" => $this->calcularAvaliacao($co2_consumido_total_ficticio, $co2_meta_ficticio),
            "data_analise" => Carbon::now()->format("d/m/Y"),
            "filtro_inicio" => $filtro_inicio,
            "filtro_fim" => $filtro_fim,
            "periodo_selecionado" => $periodo_selecionado ?: "personalizado",
        ];

        $dadosGrafico = $this->gerarDadosGraficoFicticios($filtro_inicio, $filtro_fim, $co2_meta_ficticio);

        // Comentário: Retorna a view do relatório com os dados processados.
        return view("geradorRelatorios", compact("dadosRelatorio", "dadosGrafico"));
    }

    // Método auxiliar para calcular a avaliação (exemplo)
    private function calcularAvaliacao($consumo, $meta)
    {
        if ($meta == 0) return "Meta não definida"; // Evita divisão por zero
        $percentual = ($consumo / $meta) * 100;
        if ($percentual <= 80) return "Excelente";
        if ($percentual <= 100) return "Bom";
        if ($percentual <= 120) return "Regular";
        return "Ruim";
    }

    // Método auxiliar para gerar dados fictícios para o gráfico
    private function gerarDadosGraficoFicticios($inicio, $fim, $meta)
    {
        $labels = [];
        $consumoData = [];
        $metaData = [];
        $currentDate = Carbon::parse($inicio);
        $endDate = Carbon::parse($fim);

        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format("d/m");
            // Simula variação no consumo, podendo ultrapassar a meta em alguns dias
            $consumoData[] = rand(max(0, $meta - 50), $meta + 70); 
            $metaData[] = $meta;
            $currentDate->addDay();
        }
        return [
            "labels" => $labels,
            "consumo" => $consumoData,
            "meta" => $metaData,
        ];
    }

    //Método para fazer o cadastro
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            "nome"     => "required|string|max:255",
            "email"    => "required|string|unique:usuarios,email",
            "password"    => "required|min:6",
            "cnpj"     => "required|unique:usuarios,cnpj",
        ],
        [
            "email.email"    => "Insira um e-mail válido.",
            "email.unique"   => "Este e-mail já está em uso.",
            
            "password.required" => "A senha é obrigatória.",
            "password.min"      => "A senha deve ter no mínimo :min caracteres.",
        
            "cnpj.required" => "O campo CNPJ é obrigatório.",
            "cnpj.unique"   => "Este CNPJ já foi cadastrado."
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }

        Usuario::create([
            "nome"     => $request->nome,
            "email"    => $request->email,
            "password"    => Hash::make($request->password),
            "cnpj"     => $request->cnpj,
        ]);

        return response()->json(["message" => "Cadastro realizado com sucesso!"]);
    }

    //Método para fazer o login
    public function login(Request $request){
        $credenciais = $request->validate([
            "email" => ["required"],
            "password" => ["required"],
        ]);

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            return response()->json([
                "nome" => $usuario->nome,
                "email" => $usuario->email
            ]);
        }

        return response()->json([
            "errors" => [
                "password" => ["Email ou senha incorretos."]
            ]
        ], 422);
    }
}

