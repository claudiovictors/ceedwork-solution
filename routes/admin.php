<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Administration Routes
|--------------------------------------------------------------------------
|
| Rotas responsáveis pela área administrativa da Ceedwork-Solutions.
|
| Prefixo: /ceed-admin
| Middleware: auth, admin
|
*/

Route::middleware(['auth', 'admin'])->prefix('ceed-admin')->group(function (): void {

    /**
     * ------------------------------------------------------------------------
     * Administrative Dashboard
     * ------------------------------------------------------------------------
     *
     * Área principal de gestão administrativa.
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /**
     * --------------------------------------------------------------------
     * Profile Management
     * --------------------------------------------------------------------
     *
     * Permite ao utilizador consultar, atualizar e eliminar
     * as informações do seu perfil.
     */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
