<?php

namespace App\Http\Controllers\Pages;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Lista as notícias publicadas.
     */
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->with(['category', 'author'])
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->get()
            ->map(static fn (Post $post): array => [
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'image' => $post->cover_url,
                'date' => $post->published_at->toDateString(),
                'category' => $post->category?->name ?? 'Sem categoria',
            ])
            ->values();

        return view('pages.news', [
            'posts' => $posts,
            'categories' => $posts
                ->pluck('category')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    /**
     * Exibe uma notícia publicada.
     */
    public function show(Post $post): View
    {
        abort_unless(
            $post->status === PostStatus::Published && $post->published_at?->isPast(),
            404
        );

        $post->load(['category', 'author']);

        $related = Post::query()
            ->published()
            ->whereKeyNot($post->getKey())
            ->with(['category', 'author'])
            ->orderByRaw('CASE WHEN category_id = ? THEN 0 ELSE 1 END', [$post->category_id])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pages.news-show', [
            'post' => $post,
            'related' => $related,
        ]);
    }
}
