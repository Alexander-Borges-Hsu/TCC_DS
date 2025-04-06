<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index']);
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::post('/login', [EventController::class, 'login']);

