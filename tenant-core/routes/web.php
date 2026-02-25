<?php

use App\Http\Controllers\GlobalModulesController;
use App\Http\Controllers\ModulesController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// ================= ADMIN ROUTES =================

// lista módulos globais
Route::get('/modules', [GlobalModulesController::class, 'index'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.index');

// criar módulo
Route::view('/modules/create', 'modules.create')
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.create');

Route::post('/modules/create', [GlobalModulesController::class, 'store'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.store');

//deletar módulo
Route::delete('modules/delete/{id}', [GlobalModulesController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.delete');

// ativar / desativar global
Route::patch('/modules/{id}/activate', [GlobalModulesController::class, 'activate'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.activate');

Route::patch('/modules/{id}/deactivate', [GlobalModulesController::class, 'deactivate'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.deactivate');

//ver modulo especifico
Route::get('/modules/{slug}', [ModulesController::class, 'show'])
    ->middleware(['auth', 'verified', 'superuser'])
    ->name('modules.show');


// ================= USER / COMPANY ROUTES =================

// listar módulos disponíveis para empresa
Route::get('/company/modules', [ModulesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('modulesCompany.index');

// ver módulo específico
Route::get('/company/modules/{slug}', [ModulesController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('modulesCompany.show');

// ativar para empresa
Route::patch('/company/modules/{id}/activate', [ModulesController::class, 'activate'])
    ->middleware(['auth', 'verified'])
    ->name('modulesCompany.activate');

// desativar para empresa
Route::patch('/company/modules/{id}/deactivate', [ModulesController::class, 'deactivate'])
    ->middleware(['auth', 'verified'])
    ->name('modulesCompany.deactivate');


require __DIR__.'/settings.php';