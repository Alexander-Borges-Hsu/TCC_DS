<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Usuario;
class EventController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function store(Request $request){

        $usuario = new Usuario();
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $senhaHash = password_hash($request->senha, PASSWORD_DEFAULT);
        $usuario->password = $senhaHash;
        $usuario->cnpj = $request->cnpj;
        $usuario->save();

        return redirect('/');
    }

    
}
