
<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| Rotas responsáveis pela autenticação dos utilizadores administrativos,
| incluindo registo, login, recuperação de palavra-passe e verificação
| de endereço de e-mail.
|
| Prefixo: /ceed-admin
|
*/

/**
 * ------------------------------------------------------------------------
 * Guest Routes
 * ------------------------------------------------------------------------
 *
 * Acessíveis apenas a utilizadores não autenticados.
 *
 * Middleware: guest
 */
Route::middleware('guest')->prefix('ceed-admin')->group(function () {

    /**
     * Exibe o formulário de registo de um novo administrador.
     *
     * GET /ceed-admin/register
     * Controller: RegisteredUserController::create
     * Route name: register
     */
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    /**
     * Processa o registo de um novo administrador.
     *
     * POST /ceed-admin/register
     * Controller: RegisteredUserController::store
     */
    Route::post('register', [RegisteredUserController::class, 'store']);

    /**
     * Exibe o formulário de autenticação administrativa.
     *
     * GET /ceed-admin
     * Controller: AuthenticatedSessionController::create
     * Route name: login
     */
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    /**
     * Processa as credenciais de autenticação.
     *
     * POST /ceed-admin/login
     * Controller: AuthenticatedSessionController::store
     */
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    /**
     * Exibe o formulário de recuperação de palavra-passe.
     *
     * GET /ceed-admin/forgot-password
     * Controller: PasswordResetLinkController::create
     * Route name: password.request
     */
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    /**
     * Envia o link de recuperação de palavra-passe.
     *
     * POST /ceed-admin/forgot-password
     * Controller: PasswordResetLinkController::store
     * Route name: password.email
     */
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    /**
     * Exibe o formulário para redefinir a palavra-passe.
     *
     * GET /ceed-admin/reset-password/{token}
     * Controller: NewPasswordController::create
     * Route name: password.reset
     */
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    /**
     * Processa a redefinição da palavra-passe.
     *
     * POST /ceed-admin/reset-password
     * Controller: NewPasswordController::store
     * Route name: password.store
     */
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});


/**
 * ------------------------------------------------------------------------
 * Authenticated Routes
 * ------------------------------------------------------------------------
 *
 * Acessíveis apenas a utilizadores autenticados.
 *
 * Middleware: auth
 */
Route::middleware('auth')->prefix('ceed-admin')->group(function () {

    /**
     * Exibe a página de aviso de verificação de e-mail.
     *
     * GET /ceed-admin/verify-email
     * Controller: EmailVerificationPromptController
     * Route name: verification.notice
     */
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    /**
     * Verifica o endereço de e-mail através de um link assinado.
     *
     * GET /ceed-admin/verify-email/{id}/{hash}
     * Controller: VerifyEmailController
     * Middleware: signed, throttle:6,1
     * Route name: verification.verify
     */
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    /**
     * Reenvia a notificação de verificação de e-mail.
     *
     * POST /ceed-admin/email/verification-notification
     * Controller: EmailVerificationNotificationController::store
     * Middleware: throttle:6,1
     * Route name: verification.send
     */
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    /**
     * Exibe o formulário de confirmação da palavra-passe.
     *
     * GET /ceed-admin/confirm-password
     * Controller: ConfirmablePasswordController::show
     * Route name: password.confirm
     */
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    /**
     * Processa a confirmação da palavra-passe.
     *
     * POST /ceed-admin/confirm-password
     * Controller: ConfirmablePasswordController::store
     */
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    /**
     * Atualiza a palavra-passe do utilizador autenticado.
     *
     * PUT /ceed-admin/password
     * Controller: PasswordController::update
     * Route name: password.update
     */
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    /**
     * Termina a sessão do utilizador autenticado.
     *
     * POST /ceed-admin/logout
     * Controller: AuthenticatedSessionController::destroy
     * Route name: logout
     */
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
