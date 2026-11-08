<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    public function index(): mixed
    {
        return view('pages.portfolio');
    }
}
