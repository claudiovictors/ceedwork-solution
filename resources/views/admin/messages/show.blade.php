<x-app-layout>
    <x-slot name="title">Mensagem de {{ $message->name }}</x-slot>
    <x-slot name="pageTitle">Mensagem</x-slot>
    <x-slot name="pageDescription">Detalhe da mensagem recebida pelo website</x-slot>

    <x-admin-page-header
        title="Mensagem de {{ $message->name }}"
        description="{{ $message->subject }}"
        icon="bx bx-envelope"
    >
        <a href="{{ route('admin.messages.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
            <i class="bx bx-left-arrow-alt text-lg"></i>
            Voltar
        </a>

        <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                <i class="bx {{ $message->read_at === null ? 'bx-check' : 'bx-envelope' }} text-lg"></i>
                {{ $message->read_at === null ? 'Marcar como lida' : 'Marcar como não lida' }}
            </button>
        </form>

        <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.$message->subject) }}"
           class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
            <i class="bx bx-reply text-lg"></i>
            Responder
        </a>

        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
              data-confirm="Eliminar esta mensagem? Esta ação não pode ser revertida."
              data-confirm-title="Eliminar mensagem"
              data-confirm-button="Eliminar">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                <i class="bx bx-trash text-lg"></i>
                Eliminar
            </button>
        </form>
    </x-admin-page-header>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm lg:col-span-2">
            <header class="flex flex-wrap items-center justify-between gap-3 border-b border-[#eef2f8] pb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#4a5568]">Assunto</p>
                    <h2 class="mt-1 text-lg font-semibold text-[#031b3a]">{{ $message->subject }}</h2>
                </div>

                <x-admin-status-badge
                    :tone="$message->read_at === null ? 'amber' : 'teal'"
                    :label="$message->read_at === null ? 'Não lida' : 'Lida'"
                />
            </header>

            <div class="prose prose-sm mt-5 max-w-none text-[#1f2a3d]">
                {!! nl2br(e($message->message)) !!}
            </div>
        </section>

        <aside class="space-y-4">
            <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-[#031b3a]">Remetente</h2>

                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-[#8a97a8]">Nome</dt>
                        <dd class="mt-1 text-[#1f2a3d]">{{ $message->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-[#8a97a8]">Email</dt>
                        <dd class="mt-1">
                            <a href="mailto:{{ $message->email }}" class="font-medium text-[#13397c] hover:text-[#031b3a]">
                                {{ $message->email }}
                            </a>
                        </dd>
                    </div>

                    @if($message->phone)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-[#8a97a8]">Telefone</dt>
                            <dd class="mt-1">
                                <a href="tel:{{ preg_replace('/\s+/', '', $message->phone) }}" class="font-medium text-[#13397c] hover:text-[#031b3a]">
                                    {{ $message->phone }}
                                </a>
                            </dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-[#8a97a8]">Recebida em</dt>
                        <dd class="mt-1 text-[#1f2a3d]">{{ $message->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm">
                <h2 class="text-sm font-semibold text-[#031b3a]">Detalhes técnicos</h2>

                <dl class="mt-4 space-y-3 text-xs">
                    <div>
                        <dt class="font-semibold uppercase tracking-wide text-[#8a97a8]">Endereço IP</dt>
                        <dd class="mt-1 break-all font-mono text-[#4a5568]">{{ $message->ip_address ?: '—' }}</dd>
                    </div>

                    <div>
                        <dt class="font-semibold uppercase tracking-wide text-[#8a97a8]">Navegador</dt>
                        <dd class="mt-1 break-words text-[#4a5568]">{{ $message->user_agent ?: '—' }}</dd>
                    </div>

                    @if($message->read_at)
                        <div>
                            <dt class="font-semibold uppercase tracking-wide text-[#8a97a8]">Lida em</dt>
                            <dd class="mt-1 text-[#4a5568]">{{ $message->read_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    @endif
                </dl>
            </section>
        </aside>
    </div>
</x-app-layout>
