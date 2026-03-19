<?php

use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GlobalModulesController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\SitesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. ROTAS GERAIS (Abertas a qualquer logado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::view('/', 'dashboard')->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| 2. ROTAS ADMINISTRATIVAS (Superuser)
| Gerenciamento Global de Módulos
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'superuser'])->group(function () {

    // Grupo de Módulos Globais
    Route::controller(GlobalModulesController::class)->group(function () {
        Route::get('/modules', 'index')->name('modules.index');
        Route::patch('/modules/create', 'store')->name('modules.store');
        Route::delete('/modules/delete/{id}', 'destroy')->name('modules.delete');
        
        // Ativação Global
        Route::patch('/modules/{id}/activate', 'activate')->name('modules.activate');
        Route::patch('/modules/{id}/deactivate', 'deactivate')->name('modules.deactivate');
    });

    // View de criação (separada pois não usa controller)
    Route::view('/modules/create', 'modules.create')->name('modules.create');

});

/*
|--------------------------------------------------------------------------
| 3. ROTAS DE EMPRESA / USUÁRIO
| Gerenciamento de Módulos e Configurações da Empresa
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Módulos da Empresa ---
    Route::controller(ModulesController::class)->group(function () {
        Route::get('/company/modules', 'index')->name('modulesCompany.index');
        Route::get('/company/modules/{slug}', 'show')->name('modulesCompany.show');
        Route::get('/company/modules/{id}/reset', 'destroy')->name('modulesCompany.reset');
        Route::patch('/company/modules/{id}/activate', 'activate')->name('modulesCompany.activate');
        Route::patch('/company/modules/{id}/deactivate', 'deactivate')->name('modulesCompany.deactivate');
        Route::patch('/company/modules/store', 'store')->name('modulesCompany.store');
        
        // Rota duplicada que você tinha no final do arquivo (mantida por segurança)
        Route::get('/modules/{slug}', 'show')->name('modules.show');
    });

    // --- Configurações da Empresa ---
    Route::controller(CompanySettingsController::class)->group(function () {
        Route::get('/company/settings', 'index')->name('settingsCompany.index');
        Route::patch('/company/settings', 'store')->name('settingsCompany.store');
    });
        /*
        |--------------------------------------------------------------------------
        | Gallery Routes
        |--------------------------------------------------------------------------
        */
        Route::controller(GalleryController::class)->group(function () {
            Route::post('/company/manage/gallery', 'store')->name('modulesCompany.galleryStore');
            Route::get('/company/manage/gallery/{id}', 'index')->name('modulesCompany.galleryManage');
    });

});

/*
|--------------------------------------------------------------------------
| 4. ROTAS DO SITE DA COMPANY
|--------------------------------------------------------------------------
*/

    Route::controller(SitesController::class)->group(function () {
        Route::get('/site/{company_name}', 'index')->name('sites.index');
    });

            /*
            |--------------------------------------------------------------------------
            | ROTAS DO SITE GALERIA
            |--------------------------------------------------------------------------
            */
        Route::controller(GalleryController::class)->group(function () {
            Route::get('/site/{company_name}/gallery', 'viewGallery')->name('sites.viewGallery');
    });



/*
|--------------------------------------------------------------------------
| 6. ARQUIVOS EXTERNOS
|--------------------------------------------------------------------------
*/
require __DIR__.'/settings.php';