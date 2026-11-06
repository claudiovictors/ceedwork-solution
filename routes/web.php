<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/about-us', function () {
    return view('pages.about');
});

Route::get('/contacts', [ContactController::class, 'show'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'send'])
    ->middleware('throttle:5,1') // máx. 5 envios por minuto por IP
    ->name('contacts.send');
