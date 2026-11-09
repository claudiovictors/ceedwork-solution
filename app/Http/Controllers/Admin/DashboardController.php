<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel administrativo.
     */
    public function index(): View
    {
        return view('dashboard.index');
    }
}
