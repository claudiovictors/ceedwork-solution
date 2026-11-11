<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EditorUploadController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
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

    /**
     * --------------------------------------------------------------------
     * News Management
     * --------------------------------------------------------------------
     *
     * CRUD de notícias, publicação e uploads do editor de conteúdo.
     */
    Route::prefix('news')->name('admin.news.')->group(function (): void {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::patch('/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('toggle-status');
    });

    /**
     * --------------------------------------------------------------------
     * Services Management
     * --------------------------------------------------------------------
     *
     * CRUD de serviços e respetivos itens.
     */
    Route::prefix('services')->name('admin.services.')->group(function (): void {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{service}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{service}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::patch('/{service}/toggle-active', [ServiceController::class, 'toggleActive'])->name('toggle-active');
    });

    /**
     * --------------------------------------------------------------------
     * Portfolio Management
     * --------------------------------------------------------------------
     *
     * CRUD de projetos apresentados no portfólio.
     */
    Route::prefix('portfolio')->name('admin.portfolio.')->group(function (): void {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
        Route::patch('/{project}/toggle-published', [ProjectController::class, 'togglePublished'])->name('toggle-published');
    });

    /**
     * --------------------------------------------------------------------
     * Website Settings
     * --------------------------------------------------------------------
     *
     * Configurações globais do site: identidade, contactos, redes
     * sociais, aparência e assistente virtual.
     */
    Route::prefix('settings')->name('admin.settings.')->group(function (): void {
        Route::get('/', [SettingsController::class, 'edit'])->name('edit');
        Route::put('/{group}', [SettingsController::class, 'update'])->name('update');
    });

    /**
     * --------------------------------------------------------------------
     * Page Content
     * --------------------------------------------------------------------
     *
     * Conteúdo editável das páginas públicas, organizado por secções.
     */
    Route::prefix('pages')->name('admin.pages.')->group(function (): void {
        Route::get('/', [PageContentController::class, 'index'])->name('index');
        Route::get('/{page}/edit', [PageContentController::class, 'edit'])->name('edit');
        Route::put('/{page}', [PageContentController::class, 'update'])->name('update');
        Route::delete('/{page}/{section}', [PageContentController::class, 'restore'])->name('restore');
    });

    Route::post('/uploads/editor', [EditorUploadController::class, 'store'])
        ->middleware('throttle:60,1')
        ->name('admin.uploads.editor');
});
