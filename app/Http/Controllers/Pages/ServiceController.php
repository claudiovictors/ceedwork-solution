<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index(): mixed
    {
        return view('pages.service');
    }
}
