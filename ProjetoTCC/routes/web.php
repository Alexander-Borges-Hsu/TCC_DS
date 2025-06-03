<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\CalculadoraController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\IaController;
use App\Http\Controllers\FormularioController; // Novo controller adicionado
use Illuminate\Support\Facades\Auth;

// Rotas públicas (acessíveis sem login)
Route::get('/', [EventController::class, 'index']);
Route::post('/login', [EventController::class, 'login']);

// Rotas de recuperação de senha (geralmente públicas)
Route::get('/esqueci-senha', [SenhaController::class, 'formEmail'])->name('senha.form.email');
Route::post('/esqueci-senha', [SenhaController::class, 'enviarCodigo'])->name('senha.enviar.codigo');
Route::get('/verificar-codigo', [SenhaController::class, 'formCodigo'])->name('senha.form.codigo');
Route::post('/verificar-codigo', [SenhaController::class, 'verificarCodigo'])->name('senha.verificar.codigo');

    // Rota de logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate(); // Invalida a sessão
        request()->session()->regenerateToken(); // Regenera o token CSRF
        return redirect('/');
    })->name('logout');

    // Rotas do Formulário
    Route::get('/formulario', [FormularioController::class, 'index'])->name('formulario.index');
    Route::post('/formulario', [FormularioController::class, 'store'])->name('formulario.store');

    // Rotas da Calculadora
    Route::get('/calculadora', [CalculadoraController::class, 'index'])->name('calculadora.index');
    Route::post('/calculadora/calcular', [CalculadoraController::class, 'calcular'])->name('calculadora.calcular');

    // Rotas do Relatório
    Route::get('/relatorio', [RelatorioController::class, 'index'])->name('relatorio.index');
    Route::get('/relatorio/exportar-pdf', [RelatorioController::class, 'exportarPDF'])->name('relatorio.exportar-pdf');
    
    // Rotas da IA (integradas do TCC_DS3)
    Route::get('/ia', function() { return view('ia'); })->name('ia.index');
    Route::post('/ia/perguntar', [IaController::class, 'ask'])->name('ia.perguntar');

    // Rota da página Sobre Nós
   

    // Suas outras rotas autenticadas (se houver)
    // Exemplo: Rota para navegar (se precisar de auth)
    // Route::get('/navegar/{id}', [EventController::class, 'navegar']); 
    
    // Exemplo: Rota para salvar eventos (se precisar de auth)
    // Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // Adicione aqui outras rotas que precisam de login, como editar perfil, etc.
    // Route::get('/editar-perfil', [ProfileController::class, 'edit'])->name('profile.edit');


// Nota: As rotas '/navegar/{id}' e '/events' do EventController foram deixadas de fora do grupo 'auth'. 
// Se elas precisarem de autenticação, mova-as para dentro do Route::middleware(['auth'])->group(...).
Route::get('/navegar/{id}', [EventController::class, 'navegar']);
Route::post('/events', [EventController::class, 'store'])->name('events.store');
