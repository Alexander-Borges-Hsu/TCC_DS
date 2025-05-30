<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;


class SenhaController extends Controller{
    public function formEmail()
    {
        return view('esqueci-senha');
    }

    public function enviarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
        ]);

        $codigo = rand(100000, 999999);

        Cache::put('codigo_' . $request->email, $codigo, now()->addMinutes(10));

        Mail::raw("Seu código de recuperação é: $codigo", function ($message) use ($request) {
            $message->to($request->email)->subject('Código de Recuperação');
        });

        return redirect()->route('senha.form.codigo')->with('email', $request->email);
    }

    public function formCodigo(Request $request)
    {
        $email = session('email');
        return view('verificar-codigo', compact('email'));
    }

    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
            'codigo' => 'required',
            'nova_senha' => 'required|min:6|confirmed',
            ], [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'Insira um e-mail válido.',
            'codigo.required' => 'Você precisa informar o código recebido.',
            'nova_senha.required' => 'A nova senha é obrigatória.',
            'nova_senha.min' => 'A nova senha deve ter no mínimo 6 caracteres.',
            'nova_senha.confirmed' => 'As senhas não coincidem.',
        ]);

        $codigoCorreto = Cache::get('codigo_' . $request->email);

        if ($codigoCorreto != $request->codigo) {
            return back()->withErrors(['codigo' => 'Código incorreto ou expirado.']);
        }

        $usuario = Usuario::where('email', $request->email)->first();
        $usuario->password = Hash::make($request->nova_senha);
        $usuario->save();

        Cache::forget('codigo_' . $request->email);

        return redirect('/navegar/welcome')->with('status', 'Senha redefinida com sucesso!');
    }
}
