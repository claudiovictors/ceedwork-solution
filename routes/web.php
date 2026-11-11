
<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\Pages\ContactController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\NewsController;
use App\Http\Controllers\Pages\PortfolioController;
use App\Http\Controllers\Pages\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
|
| Rotas públicas do website institucional da Ceedwork-Solutions.
|
| Estas rotas permitem aos visitantes navegar pelo website, consultar
| os serviços, conhecer os projetos, acompanhar notícias e contactar
| a equipa da empresa.
|
| Middleware padrão: web
|
*/

/**
 * ------------------------------------------------------------------------
 * Home
 * ------------------------------------------------------------------------
 *
 * Página inicial do website.
 */

/**
 * Exibe a página principal.
 *
 * GET /
 * Controller: HomeController::index
 * Route name: home
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/**
 * ------------------------------------------------------------------------
 * About Us
 * ------------------------------------------------------------------------
 *
 * Informações institucionais sobre a empresa.
 */

/**
 * Exibe a página Sobre Nós.
 *
 * GET /about-us
 * View: pages.about
 * Route name: about
 */
Route::view('/about-us', 'pages.about')
    ->name('about');

/**
 * ------------------------------------------------------------------------
 * Services
 * ------------------------------------------------------------------------
 *
 * Apresentação dos serviços e soluções tecnológicas oferecidos
 * pela Ceedwork-Solutions.
 */

/**
 * Lista os serviços disponíveis.
 *
 * GET /services
 * Controller: ServiceController::index
 * Route name: services
 */
Route::get('/services', [ServiceController::class, 'index'])
    ->name('services');

/**
 * ------------------------------------------------------------------------
 * Portfolio
 * ------------------------------------------------------------------------
 *
 * Apresentação dos projetos e trabalhos desenvolvidos pela empresa.
 */

/**
 * Lista os projetos do portfólio.
 *
 * GET /portfolio
 * Controller: PortfolioController::index
 * Route name: portfolio
 */
Route::get('/portfolio', [PortfolioController::class, 'index'])
    ->name('portfolio');

/**
 * ------------------------------------------------------------------------
 * News & Articles
 * ------------------------------------------------------------------------
 *
 * Gestão e apresentação de notícias e artigos publicados no website.
 */

/**
 * Lista as notícias e artigos publicados.
 *
 * GET /news
 * Controller: NewsController::index
 * Route name: news
 */
Route::get('/news', [NewsController::class, 'index'])
    ->name('news');

/**
 * Exibe os detalhes de uma notícia através do seu slug.
 *
 * GET /news/{post}
 * Controller: NewsController::show
 * Route name: news.show
 *
 * @param  Post  $post  Notícia identificada pelo slug.
 */
Route::get('/news/{post}', [NewsController::class, 'show'])
    ->name('news.show');

/**
 * ------------------------------------------------------------------------
 * Contact
 * ------------------------------------------------------------------------
 *
 * Permite aos visitantes entrar em contacto com a equipa da empresa.
 */

/**
 * Exibe o formulário de contacto.
 *
 * GET /contact
 * Controller: ContactController::show
 * Route name: contact
 */
Route::get('/contact', [ContactController::class, 'show'])
    ->name('contact');

/**
 * Processa e envia uma mensagem submetida pelo formulário de contacto.
 *
 * POST /contact
 * Controller: ContactController::send
 * Middleware: throttle:5,1
 * Route name: contact.send
 *
 * Limite: 5 pedidos por minuto.
 */
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

/**
 * ------------------------------------------------------------------------
 * Virtual Assistant
 * ------------------------------------------------------------------------
 *
 * Endpoint responsável pelo processamento das mensagens enviadas
 * ao assistente virtual do website.
 */

/**
 * Processa uma mensagem enviada ao assistente virtual.
 *
 * POST /assistant/chat
 * Controller: AssistantController::chat
 * Middleware: throttle:15,1
 * Route name: assistant.chat
 *
 * Limite: 15 pedidos por minuto.
 */
Route::post('/assistant/chat', [AssistantController::class, 'chat'])
    ->middleware('throttle:15,1')
    ->name('assistant.chat');

/*
|--------------------------------------------------------------------------
| Route Files
|--------------------------------------------------------------------------
|
| Carregamento das rotas de autenticação e administração.
|
*/

require __DIR__.'/auth.php';

require __DIR__.'/admin.php';
