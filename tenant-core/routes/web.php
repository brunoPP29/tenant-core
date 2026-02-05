<?php

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

require __DIR__.'/settings.php';
