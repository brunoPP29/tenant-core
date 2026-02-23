<?php

use App\Http\Controllers\GlobalModulesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('/modules', 'modules.index')
    ->middleware(['auth', 'verified'])
    ->name('modules');


//ACTIVATE OR DEACTIVATE MODULE ROUTES

Route::post('/modules/{id}/{action}', [GlobalModulesController::class, 'index']);

require __DIR__.'/settings.php';
