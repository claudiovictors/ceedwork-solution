<x-app-layout>
    <x-slot name="title">Mensagens</x-slot>
    <x-slot name="pageTitle">Mensagens</x-slot>
    <x-slot name="pageDescription">Mensagens recebidas pelo formulário de contacto</x-slot>

    <x-admin-page-header
        title="Mensagens"
        description="Consulte e responda às mensagens enviadas pelo website."
        icon="bx bx-envelope"
    >
        <span class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-3 py-2 text-sm font-semibold text-[#4a5568]">
            <i class="bx bx-envelope text-base text-[#13397c]"></i>
            {{ $unreadCount }} não lida{{ $unreadCount === 1 ? '' : 's' }}
        </span>
    </x-admin-page-header>

    <form method="GET" action="{{ route('admin.messages.index') }}" class="mt-6 rounded-xl border border-[#e6edf7] bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 gap-3 md:grid-cols-4">
            <div class="md:col-span-3">
                <label for="search" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Pesquisar</label>
                <input id="search" name="search" type="search" value="{{ $search }}"
                       placeholder="Nome, email, telefone, assunto ou mensagem"
                       class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Estado</label>
                <select id="status" name="status"
                        class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <option value="">Todas</option>
                    <option value="unread" @selected($status === 'unread')>Não lidas</option>
                    <option value="read" @selected($status === 'read')>Lidas</option>
                </select>
            </div>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-2">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-3.5 py-2 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                <i class="bx bx-search text-base"></i>
                Filtrar
            </button>

            @if($search !== '' || $status !== '')
                <a href="{{ route('admin.messages.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] px-3.5 py-2 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                    Limpar filtros
                </a>
            @endif
        </div>
    </form>

    <div class="mt-6">
        @if($messages->isEmpty())
            <x-admin-empty-state
                icon="bx bx-envelope"
                title="Ainda não existem mensagens"
                description="As mensagens enviadas pelo formulário de contacto aparecerão aqui."
            />
        @else
            <x-admin-table>
                <x-slot name="head">
                    <th class="px-4 py-3 font-semibold">Remetente</th>
                    <th class="px-4 py-3 font-semibold">Assunto</th>
                    <th class="px-4 py-3 font-semibold">Recebida</th>
                    <th class="px-4 py-3 font-semibold">Estado</th>
                    <th class="px-4 py-3 text-right font-semibold">Ações</th>
                </x-slot>

                <x-slot name="body">
                    @foreach($messages as $message)
                        <tr class="align-top {{ $message->read_at === null ? 'bg-[#f8fbff]' : '' }}">
                            <td class="px-4 py-4">
                                <div class="min-w-0">
                                    <a href="{{ route('admin.messages.show', $message) }}"
                                       class="{{ $message->read_at === null ? 'font-semibold text-[#031b3a]' : 'font-medium text-[#4a5568]' }} hover:text-[#13397c]">
                                        {{ $message->name }}
                                    </a>
                                    <p class="mt-1 text-xs text-[#4a5568]">{{ $message->email }}</p>
                                    @if($message->phone)
                                        <p class="mt-0.5 text-xs text-[#8a97a8]">{{ $message->phone }}</p>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <p class="{{ $message->read_at === null ? 'font-semibold text-[#031b3a]' : 'text-[#4a5568]' }}">
                                    {{ $message->subject }}
                                </p>
                                <p class="mt-1 line-clamp-2 max-w-md text-xs text-[#4a5568]/80">
                                    {{ \Illuminate\Support\Str::limit($message->message, 120) }}
                                </p>
                            </td>

                            <td class="px-4 py-4 text-sm text-[#4a5568]">
                                {{ $message->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>

                            <td class="px-4 py-4">
                                <x-admin-status-badge
                                    :tone="$message->read_at === null ? 'amber' : 'teal'"
                                    :label="$message->read_at === null ? 'Não lida' : 'Lida'"
                                />
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('admin.messages.show', $message) }}"
                                       class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                        <i class="bx bx-show text-base"></i>
                                        Ver
                                    </a>

                                    <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 rounded-lg border border-[#e6edf7] px-2.5 py-1.5 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                                            <i class="bx {{ $message->read_at === null ? 'bx-check' : 'bx-envelope' }} text-base"></i>
                                            {{ $message->read_at === null ? 'Marcar lida' : 'Marcar não lida' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                                          data-confirm="Eliminar esta mensagem? Esta ação não pode ser revertida."
                                          data-confirm-title="Eliminar mensagem"
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
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
