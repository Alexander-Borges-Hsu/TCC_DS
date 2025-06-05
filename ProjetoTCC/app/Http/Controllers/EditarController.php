<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EditarController extends Controller
{
    public function update(Request $request)
    {
    $user = Auth::user();

        // Validação
        $request->validate([
            'profilePic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'userName' => 'required|string|max:100',
            'companyName' => 'required|string|max:100',
            'currentPassword' => 'required_with:nova_senha|nullable|string',
            'newPassword' => 'nullable|string|min:6|confirmed',
        ]);

        // Se houver upload de nova imagem
        if ($request->hasFile('profilePic')) {
            $imagem = $request->file('profilePic');
            $caminho = $imagem->store('perfil', 'public'); // 'perfil' = pasta em /storage/app/public/perfil
            $user->foto_perfil = $caminho;
        }
        // Atualização simples
        $user->nome = $request->userName;
        $user->nome_empresa = $request->companyName;

        // Se nova senha foi enviada
        if ($request->filled('newPassword')) {
            // Verifica senha atual
            if (!Hash::check($request->currentPassword, $user->password)) {
                return response()->json(['error' => 'Senha atual incorreta.'], 401);
            }

            // Altera a senha
            $user->password = Hash::make($request->nova_senha);
        }

        $user->save();

        if(response()->json(['success' => 'Perfil atualizado com sucesso.'])) {
            return redirect()->back()->with('success', 'Perfil atualizado com sucesso.');
        }else{
            return redirect()->back()->with('error', 'Senha atual incorreta.');    
        }
        
        

    }
}
