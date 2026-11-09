<x-app-layout>
    <x-slot name="title">Serviços</x-slot>
    <x-slot name="pageTitle">Serviços</x-slot>
    <x-slot name="pageDescription">Gerir os serviços apresentados no website</x-slot>

    <x-admin-page-header
        title="Serviços"
        description="Organize os serviços, os ícones e a lista de itens de cada oferta."
        icon="bx bx-briefcase-alt-2"
    >
        <a href="{{ route('admin.services.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
            <i class="bx bx-plus text-lg"></i>
            Novo serviço
        </a>
    </x-admin-page-header>

    <form method="GET" action="{{ route('admin.services.index') }}" class="mt-6 rounded-xl border border-[#e6edf7] bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="flex-1">
                <label for="search" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Pesquisar</label>
                <input id="search" name="search" type="search" value="{{ $search }}"
                       placeholder="Título ou resumo"
                       class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
            </div>

            <div class="flex items-center gap-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                    <i class="bx bx-search text-base"></i>
                    Filtrar
                </button>

                @if($search !== '')
                    <a href="{{ route('admin.services.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] px-3.5 py-2 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                        Limpar
                    </a>
                @endif
            </div>
        </div>
    </form>

    <div class="mt-6">
        @if($services->isEmpty())
            <x-admin-empty-state
                icon="bx bx-briefcase-alt-2"
                title="Ainda não existem serviços"
                description="Crie o primeiro serviço para o apresentar no website."
            >
                <a href="{{ route('admin.services.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                    <i class="bx bx-plus text-lg"></i>
                    Criar serviço
                </a>
            </x-admin-empty-state>
        @else
            <x-admin-table>
                <x-slot name="head">
                    <th class="px-4 py-3 font-semibold">Serviço</th>
                    <th class="px-4 py-3 font-semibold">Itens</th>
                    <th class="px-4 py-3 font-semibold">Ordem</th>
                    <th class="px-4 py-3 font-semibold">Estado</th>
                    <th class="px-4 py-3 text-right font-semibold">Ações</th>
                </x-slot>

                <x-slot name="body">
                    @foreach($services as $service)
                        <tr class="align-top">
                            <td class="px-4 py-4">
                                <div class="flex items-start gap-3">
                                    @if($service->image)
                                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}"
                                             class="h-12 w-16 shrink-0 rounded-lg object-cover ring-1 ring-[#e6edf7]">
                                    @else
                                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-[#eef4fb] text-[#13397c]">
                                            <i class="{{ $service->icon ?: 'bx bx-code-alt' }} text-2xl"></i>
                                        </span>
                                    @endif

                                    <div class="min-w-0">
                                        <a href="{{ route('admin.services.edit', $service) }}"
                                           class="font-semibold text-[#031b3a] hover:text-[#13397c]">
                                            {{ $service->title }}
                                        </a>
                                        <p class="mt-1 line-clamp-2 max-w-xl text-xs text-[#4a5568]">
                                            {{ $service->summary }}
                                        </p>
                                        <p class="mt-1 text-[11px] text-[#8a97a8]">/{{ $service->slug }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $service->items_count }}
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $service->sort_order }}
                            </td>

                            <td class="px-4 py-4">
                                <x-admin-status-badge
                                    :tone="$service->is_active ? 'teal' : 'slate'"
                                    :label="$service->is_active ? 'Ativo' : 'Inativo'"
                                />
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                        <i class="bx bx-edit-alt text-base"></i>
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('admin.services.toggle-active', $service) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                            <i class="bx {{ $service->is_active ? 'bx-hide' : 'bx-show' }} text-base"></i>
                                            {{ $service->is_active ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                          onsubmit="return confirm('Eliminar este serviço e todos os seus itens?');">
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
                {{ $services->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
