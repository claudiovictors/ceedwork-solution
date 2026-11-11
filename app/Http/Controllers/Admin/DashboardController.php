<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel administrativo.
     */
    public function index(): View
    {
        $recentPosts = Post::query()
            ->latest()
            ->limit(5)
            ->get(['title', 'status', 'created_at'])
            ->map(static fn (Post $post): array => [
                'title' => $post->title,
                'status' => $post->status->value,
                'created_at' => $post->created_at,
            ]);

        return view('dashboard.index', [
            'stats' => [
                'posts' => Post::query()->count(),
                'published' => Post::published()->count(),
                'drafts' => Post::query()->where('status', PostStatus::Draft->value)->count(),
                'services' => Service::active()->count(),
                'projects' => Project::published()->count(),
                'messages' => ContactMessage::query()->unread()->count(),
            ],
            'recentPosts' => $recentPosts,
        ]);
    }
}
