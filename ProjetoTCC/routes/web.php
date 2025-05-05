<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [EventController::class, 'index']);
Route::get('/navegar/{id}', [EventController::class, 'navegar']);
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::post('/login', [EventController::class, 'login']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


