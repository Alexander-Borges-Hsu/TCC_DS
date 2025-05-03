<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(){
        return view('telaInicial');
    }
    public function navegar($page){

        return view($page);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nome'     => 'required|string|max:255',
            'email'    => 'required|string|unique:usuarios,email',
            'password'    => 'required|min:6',
            'cnpj'     => 'required|unique:usuarios,cnpj',
        ],
        [
            'email.email'    => 'Insira um e-mail válido.',
            'email.unique'   => 'Este e-mail já está em uso.',
            
            'password.required' => 'A senha é obrigatória.',
            'password.min'      => 'A senha deve ter no mínimo :min caracteres.',
        
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'cnpj.unique'   => 'Este CNPJ já foi cadastrado.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Usuario::create([
            'nome'     => $request->nome,
            'email'    => $request->email,
            'password'    => Hash::make($request->password),
            'cnpj'     => $request->cnpj,
        ]);

        return response()->json(['message' => 'Cadastro realizado com sucesso!']);
    }

    public function login(Request $request){
        $credenciais = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            return response()->json([
                'nome' => $usuario->nome,
                'email' => $usuario->email
            ]);
        }

        return response()->json([
            'errors' => [
                'password' => ['Email ou senha incorretos.']
            ]
        ], 422);
    }
    
}
