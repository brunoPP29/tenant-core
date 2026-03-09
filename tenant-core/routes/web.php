<?php

use App\Http\Controllers\GlobalModulesController;
use App\Http\Controllers\ModulesController;
use Illuminate\Support\Facades\Route;




// ================= GLOBAL ROUTES =================
Route::view('/', 'dashboard')
->middleware(['auth', 'verified'])
->name('dashboard');

// ================= ADMIN ROUTES =================

Route::middleware(['auth', 'verified', 'superuser'])->group(function () {
    
    // lista módulos globais
    Route::get('/modules', [GlobalModulesController::class, 'index'])
    ->name('modules.index');
    
    // criar módulo
    Route::view('/modules/create', 'modules.create')
    ->name('modules.create');
    
    Route::patch('/modules/create', [GlobalModulesController::class, 'store'])
    ->name('modules.store');
    
    // deletar módulo
    Route::delete('modules/delete/{id}', [GlobalModulesController::class, 'destroy'])
    ->name('modules.delete');
    
    // ativar / desativar global
    Route::patch('/modules/{id}/activate', [GlobalModulesController::class, 'activate'])
    ->name('modules.activate');
    
    Route::patch('/modules/{id}/deactivate', [GlobalModulesController::class, 'deactivate'])
    ->name('modules.deactivate');
    
    });
    
    
    // ================= USER / COMPANY ROUTES =================
    
    Route::middleware(['auth', 'verified'])->group(function () {
        
        // listar módulos disponíveis para empresa
        Route::get('/company/modules', [ModulesController::class, 'index'])
        ->name('modulesCompany.index');
        
        // ver módulo específico
        Route::get('/company/modules/{slug}', [ModulesController::class, 'show'])
        ->name('modulesCompany.show');
        
        Route::get('/company/modules/{id}/reset', [ModulesController::class, 'destroy'])
        ->name('modulesCompany.reset');
        
        // ativar para empresa
        Route::patch('/company/modules/{id}/activate', [ModulesController::class, 'activate'])
        ->name('modulesCompany.activate');
        
        // desativar para empresa
        Route::patch('/company/modules/{id}/deactivate', [ModulesController::class, 'deactivate'])
        ->name('modulesCompany.deactivate');
        
        Route::patch('/company/modules/store', [ModulesController::class, 'store'])
        ->name('modulesCompany.store');
        
        // ver modulo especifico
        Route::get('/modules/{slug}', [ModulesController::class, 'show'])
            ->name('modules.show');
        });
        
        
        require __DIR__.'/settings.php';