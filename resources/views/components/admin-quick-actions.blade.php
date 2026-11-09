@php
    $actions = [
        [
            'title' => 'Novo artigo',
            'description' => 'Escrever uma publicação para o blog',
            'icon' => 'bx-edit',
            'tone' => 'blue',
        ],
        [
            'title' => 'Nova página',
            'description' => 'Criar uma página institucional',
            'icon' => 'bx-file-plus',
            'tone' => 'sky',
        ],
        [
            'title' => 'Novo projeto',
            'description' => 'Adicionar um trabalho ao portfólio',
            'icon' => 'bx-briefcase',
            'tone' => 'amber',
        ],
        [
            'title' => 'Gerir perfil',
            'description' => 'Atualizar os seus dados de acesso',
            'icon' => 'bx-user-circle',
            'tone' => 'teal',
            'href' => route('profile.edit'),
        ],
        [
            'title' => 'Ver website',
            'description' => 'Abrir o website público da Ceedwork',
            'icon' => 'bx-globe',
            'tone' => 'teal',
            'href' => route('home'),
            'external' => true,
        ],
    ];

    $tones = [
        'blue' => 'bg-[#e6edf7] text-[#13397c]',
        'sky' => 'bg-[#e8f4f9] text-[#2f96bf]',
        'amber' => 'bg-[#fdf3e7] text-[#9a5b13]',
        'teal' => 'bg-[#e7f6f3] text-[#0d5c52]',
    ];
@endphp

<section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm">

    <div>
        <h3 class="font-semibold text-[#031b3a]">
            Ações rápidas
        </h3>

        <p class="mt-1 text-xs text-[#4a5568]">
            Atalhos para as tarefas mais frequentes.
        </p>
    </div>

    <div class="mt-5 space-y-2">

        @foreach($actions as $action)
            @php
                $hasRoute = ! empty($action['href']);
                $isExternal = ! empty($action['external']);
                $tone = $tones[$action['tone']] ?? $tones['blue'];
            @endphp

            <a
                href="{{ $hasRoute ? $action['href'] : '#' }}"
                @if(! $hasRoute) aria-disabled="true" @click.prevent @endif
                @if($isExternal) target="_blank" rel="noopener noreferrer" @endif
                title="{{ $hasRoute ? $action['title'] : $action['title'] . ' — disponível em breve' }}"
                class="group flex items-center gap-3 rounded-lg border p-3 transition
                {{ $hasRoute
                    ? 'border-[#eef2f8] hover:border-[#c3ebfa] hover:bg-[#f8fafd]'
                    : 'cursor-not-allowed border-dashed border-[#e6edf7] bg-[#f8fafd]/60' }}"
            >
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $tone }}">
                    <i class="bx {{ $action['icon'] }} text-xl"></i>
                </span>

                <span class="min-w-0 flex-1">
                    <span class="block truncate text-sm font-semibold {{ $hasRoute ? 'text-[#031b3a]' : 'text-[#4a5568]' }}">
                        {{ $action['title'] }}
                    </span>
                    <span class="block truncate text-xs text-[#4a5568]/80">
                        {{ $action['description'] }}
                    </span>
                </span>

                @if($hasRoute)
                    <i class="bx bx-chevron-right text-xl text-[#4a5568]/50 transition group-hover:translate-x-0.5 group-hover:text-[#031b3a]"></i>
                @else
                    <span class="shrink-0 rounded-full bg-white px-2 py-0.5 text-[9px] font-semibold uppercase tracking-wide text-[#4a5568] ring-1 ring-[#e6edf7]">
                        Breve
                    </span>
                @endif
            </a>
        @endforeach

    </div>

</section>
