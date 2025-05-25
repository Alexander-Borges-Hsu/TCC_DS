<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IaController extends Controller
{
    /**
     * Handle the incoming request to ask the AI (using DeepSeek via OpenRouter for free tier).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
        ]);

        $userQuestion = $request->input("question");
        $apiKey = env("OPENROUTER_API_KEY"); 

        if (!$apiKey) {
            Log::error("Chave da API OpenRouter não configurada no .env (OPENROUTER_API_KEY)");
            return response()->json(["error" => "Configuração interna do servidor incorreta."], 500);
        }

        $systemPrompt = "Você é um especialista em meio ambiente. Sua única função é responder perguntas *estritamente* relacionadas a tópicos ambientais como ecologia, conservação, mudanças climáticas, poluição, sustentabilidade, biodiversidade, energias renováveis e gestão de recursos naturais. Se a pergunta não for sobre meio ambiente, recuse educadamente informando que você só pode responder sobre questões ambientais. Não responda perguntas sobre outros assuntos, mesmo que relacionadas indiretamente.";

        $apiUrl = "https://openrouter.ai/api/v1/chat/completions";
        $modelIdentifier = "deepseek/deepseek-chat:free"; 

        try {
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $apiKey, 
                "Content-Type" => "application/json",
                "HTTP-Referer" => env('APP_URL', 'Laravel App'), 
                "X-Title" => env('APP_NAME', 'Laravel AI Integration'),
            ])->post($apiUrl, [
                "model" => $modelIdentifier,
                "messages" => [
                    ["role" => "system", "content" => $systemPrompt],
                    ["role" => "user", "content" => $userQuestion]
                ],
                "max_tokens" => 250, 
                "temperature" => 0.5, 
            ]);

            if ($response->successful()) {
                $aiAnswer = $response->json("choices.0.message.content");
                return response()->json(["answer" => trim($aiAnswer)]);
            } else {
                Log::error("Erro na API OpenRouter/DeepSeek: Status " . $response->status() . " Body: " . $response->body());
                return response()->json(["error" => "Falha ao comunicar com a IA."], $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Exceção ao chamar API OpenRouter/DeepSeek: " . $e->getMessage());
            return response()->json(["error" => "Ocorreu um erro inesperado."], 500);
        }
    }
}

