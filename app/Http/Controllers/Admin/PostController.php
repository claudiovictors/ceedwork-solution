<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Support\HtmlSanitizer;
use App\Support\ImageUploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private readonly HtmlSanitizer $sanitizer,
        private readonly ImageUploader $uploader,
    ) {}

    /**
     * Lista as notícias com pesquisa, filtros e paginação.
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => (string) $request->query('search', ''),
            'status' => (string) $request->query('status', ''),
            'category' => (string) $request->query('category', ''),
        ];

        $status = PostStatus::tryFrom($filters['status']);

        $posts = Post::query()
            ->with(['category', 'author'])
            ->when(filled($filters['search']), function (Builder $query) use ($filters): void {
                $search = trim($filters['search']);

                $query->where(function (Builder $query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%");
                });
            })
            ->when($status instanceof PostStatus, fn (Builder $query) => $query->where('status', $status->value))
            ->when(
                ctype_digit($filters['category']),
                fn (Builder $query) => $query->where('category_id', (int) $filters['category'])
            )
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.news.index', [
            'posts' => $posts,
            'categories' => Category::orderBy('name')->get(),
            'statuses' => PostStatus::cases(),
            'filters' => $filters,
        ]);
    }

    /**
     * Exibe o formulário de criação de uma notícia.
     */
    public function create(): View
    {
        return view('admin.news.create', [
            'post' => new Post([
                'status' => PostStatus::Draft,
                'is_featured' => false,
            ]),
            'categories' => Category::orderBy('name')->get(),
            'statuses' => PostStatus::cases(),
        ]);
    }

    /**
     * Guarda uma nova notícia.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['remove_cover']);

        $data['body'] = $this->sanitizer->clean($data['body']);
        $data['excerpt'] = filled($data['excerpt'] ?? null)
            ? $data['excerpt']
            : Str::limit(strip_tags($data['body']), 180);
        $data['author_id'] = $request->user()->id;
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->uploader->store(
                $request->file('cover_image'),
                'posts/covers'
            );
        }

        Post::create($this->normalizePublication($data));

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Notícia criada com sucesso.');
    }

    /**
     * Exibe o formulário de edição de uma notícia.
     */
    public function edit(Post $post): View
    {
        return view('admin.news.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'statuses' => PostStatus::cases(),
        ]);
    }

    /**
     * Atualiza uma notícia existente.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        unset($data['remove_cover']);

        $data['body'] = $this->sanitizer->clean($data['body']);
        $data['excerpt'] = filled($data['excerpt'] ?? null)
            ? $data['excerpt']
            : Str::limit(strip_tags($data['body']), 180);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            $this->uploader->delete($post->cover_image);
            $data['cover_image'] = $this->uploader->store(
                $request->file('cover_image'),
                'posts/covers'
            );
        } elseif ($request->boolean('remove_cover')) {
            $this->uploader->delete($post->cover_image);
            $data['cover_image'] = null;
        } else {
            unset($data['cover_image']);
        }

        $post->update($this->normalizePublication($data));

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Notícia atualizada com sucesso.');
    }

    /**
     * Remove uma notícia.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->uploader->delete($post->cover_image);
        $post->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('status', 'Notícia eliminada com sucesso.');
    }

    /**
     * Alterna entre rascunho e publicado.
     */
    public function toggleStatus(Post $post): RedirectResponse
    {
        if ($post->status === PostStatus::Published) {
            $post->update([
                'status' => PostStatus::Draft,
                'published_at' => null,
            ]);

            return back()->with('status', 'Notícia movida para rascunhos.');
        }

        $post->update([
            'status' => PostStatus::Published,
            'published_at' => now(),
        ]);

        return back()->with('status', 'Notícia publicada com sucesso.');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizePublication(array $data): array
    {
        if (PostStatus::from($data['status']) === PostStatus::Draft) {
            $data['published_at'] = null;

            return $data;
        }

        if (blank($data['published_at'] ?? null)) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
