<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return view('pages.home', [
            'posts' => $posts,
        ]);
    }
}
