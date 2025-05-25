<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SenhaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IaController;

Route::get('/', [EventController::class, 'index']);
Route::get('/navegar/{id}', [EventController::class, 'navegar']);
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::post('/login', [EventController::class, 'login']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// rotas do esqeci senha
Route::get('/esqueci-senha', [SenhaController::class, 'formEmail'])->name('senha.form.email');
Route::post('/esqueci-senha', [SenhaController::class, 'enviarCodigo'])->name('senha.enviar.codigo');

Route::get('/verificar-codigo', [SenhaController::class, 'formCodigo'])->name('senha.form.codigo');
Route::post('/verificar-codigo', [SenhaController::class, 'verificarCodigo'])->name('senha.verificar.codigo');

//rotas IA
Route::get('/', function () {
    return view('welcome');
});
Route::post('/ia/perguntar', [IaController::class, 'ask'])->name('ia.perguntar');








