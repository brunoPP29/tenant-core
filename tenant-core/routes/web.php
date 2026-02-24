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

Route::post('/modules/{id}/{action}', [GlobalModulesController::class, ''])
    ->middleware(['auth', 'verified'])
    ->name('modules.action');; //falta endpoint de ativar ou n


//CREATE MODULES ROUTES
Route::view('/modules/create', 'modules.create')
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.create');

Route::post('/modules/create', [GlobalModulesController::class, 'store'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.store');


require __DIR__.'/settings.php';
