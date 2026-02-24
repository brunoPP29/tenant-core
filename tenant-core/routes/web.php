<?php

use App\Http\Controllers\GlobalModulesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/modules', [GlobalModulesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('modules.index');

//SINGLE VIEW ROUTES

Route::get('/modules/{slug}', [GlobalModulesController::class, 'show'])
    ->middleware(['auth', 'verified'])  
    ->name('modules.show');


//ACTIVATE OR DEACTIVATE MODULE ROUTES

Route::post('/modules/{id}', [GlobalModulesController::class, ''])
    ->middleware(['auth', 'verified'])
    ->name('modules.activate'); //falta endpoint de ativar ou n

Route::patch('/modules/{id}', [GlobalModulesController::class, ''])
    ->middleware(['auth', 'verified'])
    ->name('modules.deactivate'); //falta endpoint de ativar ou n


//CREATE MODULES ROUTES
Route::view('/modules/create', 'modules.create')
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.create');

Route::post('/modules/create', [GlobalModulesController::class, 'store'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.store');


require __DIR__.'/settings.php';
