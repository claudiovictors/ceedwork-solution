<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->active()
            ->with('items')
            ->ordered()
            ->get();

        return view('pages.service', [
            'services' => $services,
        ]);
    }
}
