<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\Pages\ContactController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\NewsController;
use App\Http\Controllers\Pages\PortfolioController;
use App\Http\Controllers\Pages\ServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group([], function (): void {

    // -----------------------------------------------------------------------
    // Rota Principal (Página Inicial)
    // -----------------------------------------------------------------------
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    // -----------------------------------------------------------------------
    // Rota Sobre Nós
    // -----------------------------------------------------------------------
    Route::view('/about-us', 'pages.about')
        ->name('about');

    // -----------------------------------------------------------------------
    // Rotas de Serviços
    // -----------------------------------------------------------------------
    Route::get('/services', [ServiceController::class, 'index'])
        ->name('services');

    // -----------------------------------------------------------------------
    // Rotas de Portfólio
    // -----------------------------------------------------------------------
    Route::get('/portfolio', [PortfolioController::class, 'index'])
        ->name('portfolio');

    // -----------------------------------------------------------------------
    // Rotas de Notícias e Artigos
    // -----------------------------------------------------------------------
    Route::get('/news', [NewsController::class, 'index'])
        ->name('news');

    Route::get('/news/{slug}', [NewsController::class, 'show'])
        ->name('news.show');

    // -----------------------------------------------------------------------
    // Rotas de Contacto
    // -----------------------------------------------------------------------
    Route::get('/contact', [ContactController::class, 'show'])
        ->name('contact');

    Route::post('/contact', [ContactController::class, 'send'])
        ->middleware('throttle:5,1')
        ->name('contact.send');

    Route::post('/assistant/chat', [AssistantController::class, 'chat'])
    ->middleware('throttle:15,1')
    ->name('assistant.chat');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
