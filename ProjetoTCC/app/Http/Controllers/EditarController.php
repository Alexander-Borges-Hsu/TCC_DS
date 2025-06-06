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
            'profilePic' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'userName' => 'required|string|max:100',
            'companyName' => 'required|string|max:100',
            'currentPassword' => 'required_with:newPassword|string',
            'newPassword' => 'nullable|string|min:6|confirmed',
        ]);

        // Upload da nova imagem de perfil
        if ($request->hasFile('profilePic')) {
            $imagem = $request->file('profilePic');
            $nomeImagem = uniqid() . '.' . $imagem->getClientOriginalExtension();
            $caminho = $imagem->storeAs('perfil', $nomeImagem, 'public');
            $user->foto_perfil = $caminho;
        }

        // Atualiza nome e empresa
        $user->nome = $request->userName;
        $user->nome_empresa = $request->companyName;

        // Atualização da senha
        if ($request->filled('newPassword')) {
            // Verifica se a senha atual está correta
            if (!Hash::check($request->currentPassword, $user->password)) {
                return back()->with('error', 'Senha atual incorreta.');
            }

            // Define nova senha
            $user->password = Hash::make($request->newPassword);
        }

        // Salva todas as alterações
        $user->save();

        return back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
