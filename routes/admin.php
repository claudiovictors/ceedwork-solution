
<?php

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
| Middleware: auth
|
*/

/**
 * ------------------------------------------------------------------------
 * Administrative Dashboard
 * ------------------------------------------------------------------------
 *
 * Área principal de gestão administrativa.
 * Exige autenticação e verificação do endereço de e-mail.
 */
Route::middleware('auth')->prefix('ceed-admin')->group(function (): void {

    /**
     * Exibe o painel administrativo.
     *
     * GET /ceed-admin/dashboard
     * View: dashboard
     * Middleware: verified
     * Route name: dashboard
     */
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })
        ->middleware('verified')
        ->name('dashboard');


    /**
     * --------------------------------------------------------------------
     * Profile Management
     * --------------------------------------------------------------------
     *
     * Permite ao utilizador consultar, atualizar e eliminar
     * as informações do seu perfil.
     */

    /**
     * Exibe o formulário de edição do perfil.
     *
     * GET /ceed-admin/profile
     * Controller: ProfileController::edit
     * Route name: profile.edit
     */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    /**
     * Atualiza as informações do perfil.
     *
     * PATCH /ceed-admin/profile
     * Controller: ProfileController::update
     * Route name: profile.update
     */
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    /**
     * Elimina a conta do utilizador autenticado.
     *
     * DELETE /ceed-admin/profile
     * Controller: ProfileController::destroy
     * Route name: profile.destroy
     */
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
