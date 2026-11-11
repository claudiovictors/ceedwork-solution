<x-app-layout>
    <x-slot name="title">Portfólio</x-slot>
    <x-slot name="pageTitle">Portfólio</x-slot>
    <x-slot name="pageDescription">Gerir os projetos apresentados no website</x-slot>

    <x-admin-page-header
        title="Portfólio"
        description="Organize os projetos, categorias, tecnologias e imagens do portfólio."
        icon="bx bx-grid-alt"
    >
        <a href="{{ route('admin.portfolio.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
            <i class="bx bx-plus text-lg"></i>
            Novo projeto
        </a>
    </x-admin-page-header>

    <form method="GET" action="{{ route('admin.portfolio.index') }}" class="mt-6 rounded-xl border border-[#e6edf7] bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-12 sm:items-end">
            <div class="sm:col-span-6">
                <label for="search" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Pesquisar</label>
                <input id="search" name="search" type="search" value="{{ $search }}"
                       placeholder="Nome, resumo ou categoria"
                       class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
            </div>

            <div class="sm:col-span-4">
                <label for="category" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Categoria</label>
                <select id="category" name="category"
                        class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 sm:col-span-2">
                <button type="submit"
                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-[#13397c] px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                    <i class="bx bx-search text-base"></i>
                    Filtrar
                </button>

                @if($search !== '' || $selectedCategory !== '')
                    <a href="{{ route('admin.portfolio.index') }}"
                       class="inline-flex items-center justify-center rounded-lg border border-[#e6edf7] px-3.5 py-2 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]"
                       title="Limpar filtros">
                        <i class="bx bx-x text-lg"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <div class="mt-6">
        @if($projects->isEmpty())
            <x-admin-empty-state
                icon="bx bx-grid-alt"
                title="Ainda não existem projetos"
                description="Crie o primeiro projeto para o apresentar no portfólio."
            >
                <a href="{{ route('admin.portfolio.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                    <i class="bx bx-plus text-lg"></i>
                    Criar projeto
                </a>
            </x-admin-empty-state>
        @else
            <x-admin-table>
                <x-slot name="head">
                    <th class="px-4 py-3 font-semibold">Projeto</th>
                    <th class="px-4 py-3 font-semibold">Categoria</th>
                    <th class="px-4 py-3 font-semibold">Tecnologias</th>
                    <th class="px-4 py-3 font-semibold">Ordem</th>
                    <th class="px-4 py-3 font-semibold">Estado</th>
                    <th class="px-4 py-3 text-right font-semibold">Ações</th>
                </x-slot>

                <x-slot name="body">
                    @foreach($projects as $project)
                        <tr class="align-top">
                            <td class="px-4 py-4">
                                <div class="flex items-start gap-3">
                                    @if($project->image)
                                        <img src="{{ $project->image_url }}" alt="{{ $project->name }}"
                                             class="h-12 w-16 shrink-0 rounded-lg object-cover ring-1 ring-[#e6edf7]">
                                    @elseif($project->logo)
                                        <span class="flex h-12 w-16 shrink-0 items-center justify-center rounded-lg bg-[#f8fafd] ring-1 ring-[#e6edf7]">
                                            <img src="{{ $project->logo_url }}" alt="{{ $project->name }}" class="max-h-10 max-w-14 object-contain">
                                        </span>
                                    @else
                                        <span class="flex h-12 w-16 shrink-0 items-center justify-center rounded-lg bg-[#eef4fb] text-[#13397c]">
                                            <i class="bx bx-folder text-2xl"></i>
                                        </span>
                                    @endif

                                    <div class="min-w-0">
                                        <a href="{{ route('admin.portfolio.edit', $project) }}"
                                           class="font-semibold text-[#031b3a] hover:text-[#13397c]">
                                            {{ $project->name }}
                                        </a>
                                        <p class="mt-1 line-clamp-2 max-w-xl text-xs text-[#4a5568]">
                                            {{ $project->summary }}
                                        </p>
                                        @if($project->url)
                                            <a href="{{ $project->url }}" target="_blank" rel="noopener noreferrer"
                                               class="mt-1 inline-flex items-center gap-1 text-[11px] font-medium text-[#2f96bf] hover:text-[#13397c]">
                                                <i class="bx bx-link-external"></i>
                                                {{ $project->url }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $project->category ?: '—' }}
                            </td>

                            <td class="px-4 py-4">
                                @php($technologies = $project->technologies ?? [])
                                <div class="flex max-w-[16rem] flex-wrap gap-1">
                                    @forelse(array_slice($technologies, 0, 4) as $technology)
                                        <span class="rounded-md bg-[#eef4fb] px-2 py-0.5 text-[11px] font-semibold text-[#13397c]">{{ $technology }}</span>
                                    @empty
                                        <span class="text-xs text-[#8a97a8]">—</span>
                                    @endforelse

                                    @if(count($technologies) > 4)
                                        <span class="rounded-md bg-[#f3f6fa] px-2 py-0.5 text-[11px] font-semibold text-[#4a5568]">+{{ count($technologies) - 4 }}</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $project->sort_order }}
                            </td>

                            <td class="px-4 py-4">
                                <x-admin-status-badge
                                    :tone="$project->is_published ? 'teal' : 'slate'"
                                    :label="$project->is_published ? 'Publicado' : 'Rascunho'"
                                />
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('admin.portfolio.edit', $project) }}"
                                       class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                        <i class="bx bx-edit-alt text-base"></i>
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('admin.portfolio.toggle-published', $project) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                            <i class="bx {{ $project->is_published ? 'bx-hide' : 'bx-show' }} text-base"></i>
                                            {{ $project->is_published ? 'Despublicar' : 'Publicar' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.portfolio.destroy', $project) }}"
                                          data-confirm="Eliminar este projeto?"
                                          data-confirm-title="Eliminar projeto"
                                          data-confirm-button="Eliminar">
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
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
