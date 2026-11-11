@php
    $stats = isset($stats) && is_array($stats) ? $stats : [];

    $user = auth()->user();
    $firstName = $user?->name
        ? explode(' ', trim($user->name))[0]
        : 'Administrador';

    $cards = [
        [
            'label' => 'Total de artigos',
            'value' => $stats['posts'] ?? '—',
            'icon' => 'bx-news',
            'tone' => 'blue',
            'description' => 'Publicações registadas no blog',
        ],
        [
            'label' => 'Artigos publicados',
            'value' => $stats['published'] ?? '—',
            'icon' => 'bx-check-circle',
            'tone' => 'teal',
            'description' => 'Conteúdos visíveis no website',
        ],
        [
            'label' => 'Rascunhos',
            'value' => $stats['drafts'] ?? '—',
            'icon' => 'bx-edit-alt',
            'tone' => 'amber',
            'description' => 'Conteúdos ainda não publicados',
        ],
        [
            'label' => 'Serviços ativos',
            'value' => $stats['services'] ?? 0,
            'icon' => 'bx-briefcase',
            'tone' => 'sky',
            'description' => 'Serviços disponíveis no website',
        ],
        [
            'label' => 'Projetos publicados',
            'value' => $stats['projects'] ?? 0,
            'icon' => 'bx-folder-open',
            'tone' => 'amber',
            'description' => 'Projetos visíveis no portfólio',
        ],
    ];
@endphp

<section aria-labelledby="dashboard-welcome">

    <div class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div class="min-w-0">
                <p class="text-sm text-[#4a5568]">
                    Bem-vindo de volta,
                    <span class="font-semibold text-[#031b3a]">{{ $firstName }}</span>
                </p>

                <h2 id="dashboard-welcome" class="mt-1 text-xl font-semibold tracking-tight text-[#031b3a] sm:text-2xl">
                    O que vamos gerir hoje?
                </h2>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#4a5568]">
                    Acompanhe o conteúdo e a atividade do website da Ceedwork-Solutions num só lugar.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">

                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#1baa99] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#148577] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#1baa99] focus-visible:ring-offset-2"
                >
                    <i class="bx bx-globe text-lg"></i>
                    Visualizar website
                </a>

                <a
                    href="{{ route('profile.edit') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:border-[#c3ebfa] hover:bg-[#f8fafd] hover:text-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2"
                >
                    <i class="bx bx-user text-lg"></i>
                    Meu perfil
                </a>

            </div>

        </div>

    </div>

    <div class="mt-6">

        <div class="mb-4 flex items-end justify-between gap-4">
            <div>
                <h2 class="text-base font-semibold text-[#031b3a]">Resumo geral do website</h2>
                <p class="mt-1 text-xs text-[#4a5568]">Indicadores principais do conteúdo institucional.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @foreach($cards as $card)
                <x-admin-stat-card
                    :label="$card['label']"
                    :value="$card['value']"
                    :description="$card['description']"
                    :icon="$card['icon']"
                    :tone="$card['tone']"
                />
            @endforeach
        </div>

    </div>

</section>
