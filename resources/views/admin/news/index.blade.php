<x-app-layout>
    <x-slot name="title">Notícias</x-slot>
    <x-slot name="pageTitle">Notícias</x-slot>
    <x-slot name="pageDescription">Gerir artigos publicados, rascunhos e destaques do website</x-slot>

    <x-admin-page-header
        title="Notícias"
        description="Crie, edite e publique os artigos do website."
        icon="bx bx-news"
    >
        <a href="{{ route('admin.news.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
            <i class="bx bx-plus text-lg"></i>
            Nova notícia
        </a>
    </x-admin-page-header>

    <form method="GET" action="{{ route('admin.news.index') }}" class="mt-6 rounded-xl border border-[#e6edf7] bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
            <div class="md:col-span-2">
                <label for="search" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Pesquisar</label>
                <input id="search" name="search" type="search" value="{{ $filters['search'] }}"
                       placeholder="Título ou resumo"
                       class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Estado</label>
                <select id="status" name="status"
                        class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <option value="">Todos</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" @selected($filters['status'] === $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="category" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Categoria</label>
                <select id="category" name="category"
                        class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <option value="">Todas</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected($filters['category'] === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-2">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                <i class="bx bx-search text-base"></i>
                Filtrar
            </button>

            @if($filters['search'] !== '' || $filters['status'] !== '' || $filters['category'] !== '')
                <a href="{{ route('admin.news.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] px-3.5 py-2 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                    Limpar filtros
                </a>
            @endif
        </div>
    </form>

    <div class="mt-6">
        @if($posts->isEmpty())
            <x-admin-empty-state
                icon="bx bx-news"
                title="Ainda não existem notícias"
                description="Crie a primeira notícia para começar a publicar conteúdo no website."
            >
                <a href="{{ route('admin.news.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                    <i class="bx bx-plus text-lg"></i>
                    Criar notícia
                </a>
            </x-admin-empty-state>
        @else
            <x-admin-table>
                <x-slot name="head">
                    <th class="px-4 py-3 font-semibold">Notícia</th>
                    <th class="px-4 py-3 font-semibold">Categoria</th>
                    <th class="px-4 py-3 font-semibold">Estado</th>
                    <th class="px-4 py-3 font-semibold">Publicação</th>
                    <th class="px-4 py-3 font-semibold">Autor</th>
                    <th class="px-4 py-3 text-right font-semibold">Ações</th>
                </x-slot>

                <x-slot name="body">
                    @foreach($posts as $post)
                        <tr class="align-top">
                            <td class="px-4 py-4">
                                <div class="flex items-start gap-3">
                                    @if($post->cover_image)
                                        <img src="{{ $post->cover_url }}" alt="{{ $post->title }}"
                                             class="h-12 w-16 shrink-0 rounded-lg object-cover ring-1 ring-[#e6edf7]">
                                    @else
                                        <span class="flex h-12 w-16 shrink-0 items-center justify-center rounded-lg bg-[#eef4fb] text-[#13397c]">
                                            <i class="bx bx-news text-xl"></i>
                                        </span>
                                    @endif

                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <a href="{{ route('admin.news.edit', $post) }}"
                                               class="font-semibold text-[#031b3a] hover:text-[#13397c]">
                                                {{ $post->title }}
                                            </a>

                                            @if($post->is_featured)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-[#eef4fb] px-2 py-0.5 text-[11px] font-semibold text-[#13397c]">
                                                    <i class="bx bxs-star text-xs"></i>
                                                    Destaque
                                                </span>
                                            @endif
                                        </div>

                                        <p class="mt-1 line-clamp-2 max-w-xl text-xs text-[#4a5568]">
                                            {{ $post->excerpt }}
                                        </p>

                                        <p class="mt-1 text-[11px] text-[#8a97a8]">/{{ $post->slug }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $post->category?->name ?? '—' }}
                            </td>

                            <td class="px-4 py-4">
                                <x-admin-status-badge
                                    :tone="$post->status === \App\Enums\PostStatus::Published ? 'teal' : 'amber'"
                                    :label="$post->status?->label() ?? '—'"
                                />
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $post->published_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $post->author?->name ?? '—' }}
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('admin.news.edit', $post) }}"
                                       class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                        <i class="bx bx-edit-alt text-base"></i>
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('admin.news.toggle-status', $post) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                            <i class="bx {{ $post->status === \App\Enums\PostStatus::Published ? 'bx-hide' : 'bx-show' }} text-base"></i>
                                            {{ $post->status === \App\Enums\PostStatus::Published ? 'Despublicar' : 'Publicar' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.news.destroy', $post) }}"
                                          onsubmit="return confirm('Eliminar esta notícia? Esta ação não pode ser revertida no painel.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-red-200 px-2.5 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                            <i class="bx bx-trash text-base"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-admin-table>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
