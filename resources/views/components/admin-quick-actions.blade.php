@php
    $sections = [
        [
            'title' => 'Artigos e blog',
            'description' => 'Publicações e notícias do website',
            'icon' => 'bx-news',
            'indexRoute' => 'admin.news.index',
            'createRoute' => 'admin.news.create',
            'createLabel' => 'Novo artigo',
        ],
        [
            'title' => 'Serviços',
            'description' => 'Serviços apresentados aos clientes',
            'icon' => 'bx-briefcase',
            'indexRoute' => 'admin.services.index',
            'createRoute' => 'admin.services.create',
            'createLabel' => 'Novo serviço',
        ],
        [
            'title' => 'Portfólio',
            'description' => 'Projetos apresentados no website',
            'icon' => 'bx-folder-open',
            'indexRoute' => 'admin.portfolio.index',
            'createRoute' => 'admin.portfolio.create',
            'createLabel' => 'Novo projeto',
        ],
    ];
@endphp

<section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm">

    <div>
        <h3 class="font-semibold text-[#031b3a]">
            Gestão de conteúdo
        </h3>

        <p class="mt-1 text-xs text-[#4a5568]">
            Aceda aos conteúdos existentes ou crie novos.
        </p>
    </div>

    <div class="mt-5 space-y-2">

        @foreach($sections as $section)
            <div class="rounded-lg border border-[#eef2f8] p-3">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#e6edf7] text-[#13397c]">
                        <i class="bx {{ $section['icon'] }} text-xl"></i>
                    </span>

                    <div class="min-w-0">
                        <h4 class="truncate text-sm font-semibold text-[#031b3a]">{{ $section['title'] }}</h4>
                        <p class="truncate text-xs text-[#4a5568]/80">{{ $section['description'] }}</p>
                    </div>
                </div>

                <div class="mt-3 flex gap-2">
                    <a
                        href="{{ route($section['indexRoute']) }}"
                        class="inline-flex items-center gap-1 rounded-md bg-[#f4f7fb] px-2.5 py-1.5 text-xs font-semibold text-[#13397c] transition hover:bg-[#e6edf7]"
                    >
                        Gerir <i class="bx bx-right-arrow-alt text-sm"></i>
                    </a>
                    <a
                        href="{{ route($section['createRoute']) }}"
                        class="inline-flex items-center gap-1 rounded-md bg-[#e7f6f3] px-2.5 py-1.5 text-xs font-semibold text-[#0d5c52] transition hover:bg-[#d2eee8]"
                    >
                        <i class="bx bx-plus text-sm"></i> {{ $section['createLabel'] }}
                    </a>
                </div>
            </div>
        @endforeach

    </div>

</section>
