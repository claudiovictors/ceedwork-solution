{{-- resources/views/news.blade.php --}}
@extends('layouts.main')

@section('title', 'Notícias | Ceedwork')
@section('description', 'Acompanhe as novidades da Ceedwork-Solutions: projetos, eventos, parcerias e dicas de tecnologia.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/news.css') }}">
@endpush

@section('herosection')
    @include('components._page-header', [
        'title'  => 'Notícias',
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Notícias'],
        ],
    ])
@endsection

@section('content')
@php
    // Accepts an external URL or a local file inside public/assets/images
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);
    $img = fn ($id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=900&q=75";

    // Example data. Later, pass $posts from a controller using the same keys.
    // The first post is the featured one.
    $posts = $posts ?? [
        [
            'title'    => 'Ceedwork lança nova plataforma de gestão',
            'excerpt'  => 'A Ceedwork apresentou a sua nova solução pensada para as necessidades das empresas angolanas, com foco em simplicidade e segurança.',
            'image'    => $img('1522071820081-009f0129c71c'),
            'date'     => '2026-07-01',
            'category' => 'Empresa',
        ],
        [
            'title'    => 'Presença marcante na feira de tecnologia',
            'excerpt'  => 'A equipa participou na edição deste ano, partilhando casos de sucesso e novas tendências em transformação digital.',
            'image'    => $img('1540575467063-178a50c2df87'),
            'date'     => '2026-06-15',
            'category' => 'Eventos',
        ],
        [
            'title'    => 'Nova parceria reforça infraestrutura',
            'excerpt'  => 'Um novo acordo estratégico vai ampliar a capacidade de resposta e o suporte aos clientes em todo o país.',
            'image'    => $img('1521737604893-d14cc237f11d'),
            'date'     => '2026-05-05',
            'category' => 'Empresa',
        ],
        [
            'title'    => 'Workshop de segurança digital',
            'excerpt'  => 'Realizámos um workshop prático sobre boas práticas de cibersegurança para pequenas e médias empresas.',
            'image'    => $img('1563986768609-322da13575f3'),
            'date'     => '2026-04-20',
            'category' => 'Eventos',
        ],
        [
            'title'    => 'Equipa cresce com novos talentos',
            'excerpt'  => 'Damos as boas-vindas a novos profissionais que vão reforçar as áreas de desenvolvimento e suporte técnico.',
            'image'    => $img('1542744173-8e7e53415bb0'),
            'date'     => '2026-03-10',
            'category' => 'Empresa',
        ],
        [
            'title'    => 'Cinco sinais de que o seu negócio precisa de um sistema à medida',
            'excerpt'  => 'Processos manuais, folhas de cálculo por todo o lado e falta de visão do negócio são alguns dos sinais de que está na hora de evoluir.',
            'image'    => $img('1498050108023-c5249f4df085'),
            'date'     => '2026-02-18',
            'category' => 'Dicas',
        ],
        [
            'title'    => 'Site institucional: por onde começar',
            'excerpt'  => 'Antes de pensar no design, defina o objetivo do site, o público e os conteúdos essenciais. Veja os primeiros passos.',
            'image'    => $img('1547658719-da2b51169166'),
            'date'     => '2026-01-27',
            'category' => 'Dicas',
        ],
        [
            'title'    => 'Aplicativo nativo ou híbrido? Como escolher',
            'excerpt'  => 'Entenda as diferenças entre as duas abordagens e o que deve pesar na decisão: orçamento, prazo e experiência do utilizador.',
            'image'    => $img('1512941937669-90a1b58e7e9c'),
            'date'     => '2025-12-12',
            'category' => 'Tecnologia',
        ],
        [
            'title'    => 'Porque a segurança dos dados importa para as empresas',
            'excerpt'  => 'Backups, acessos controlados e boas práticas simples ajudam a proteger a informação do seu negócio.',
            'image'    => $img('1558494949-ef010cbdcc31'),
            'date'     => '2025-11-04',
            'category' => 'Tecnologia',
        ],
    ];

    $posts = collect($posts)->values();
    $featured = $posts->first();
    $categories = $categories ?? $posts->pluck('category')->filter()->unique()->values();

    $postUrl = fn ($p) => url('/noticias/' . ($p['slug'] ?? Illuminate\Support\Str::slug($p['title'])));
    $date    = fn ($p) => \Carbon\Carbon::parse($p['date'])->locale('pt');
    $fDate   = $featured ? $date($featured) : null;
@endphp

<section class="news">
    <div class="container">

        {{-- Filters + search --}}
        <div class="news-toolbar" data-reveal>
            <ul class="news-filters" aria-label="Filtrar por categoria">
                <li>
                    <button type="button" class="news-filter is-active" data-category="all" aria-pressed="true">Todas</button>
                </li>
                @foreach($categories as $category)
                    <li>
                        <button type="button" class="news-filter" data-category="{{ $category }}" aria-pressed="false">{{ $category }}</button>
                    </li>
                @endforeach
            </ul>

            <label class="news-search">
                <i class='bx bx-search' aria-hidden="true"></i>
                <input type="search" id="newsSearch" placeholder="Pesquisar notícias" aria-label="Pesquisar notícias" autocomplete="off">
            </label>
        </div>

        {{-- Featured post (hidden while filtering) --}}
        @if($featured)
            <div class="news-featured" id="newsFeatured">
                <article class="news-featured__inner" data-reveal>
                    <a href="{{ $postUrl($featured) }}" class="news-featured__media">
                        <img src="{{ $src($featured['image']) }}" alt="{{ $featured['title'] }}" loading="eager">
                        <span class="news-flag">Destaque</span>
                    </a>

                    <div class="news-featured__content">
                        <ul class="news-meta">
                            <li><i class='bx bx-calendar' aria-hidden="true"></i> <time datetime="{{ $fDate->toDateString() }}">{{ $fDate->translatedFormat('d \d\e F \d\e Y') }}</time></li>
                            <li><i class='bx bx-category' aria-hidden="true"></i> {{ $featured['category'] }}</li>
                        </ul>

                        <h2 class="news-featured__title">
                            <a href="{{ $postUrl($featured) }}">{{ $featured['title'] }}</a>
                        </h2>
                        <p>{{ $featured['excerpt'] }}</p>

                        <a href="{{ $postUrl($featured) }}" class="btn">
                            Ler notícia <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </article>
            </div>
        @endif

        {{-- List --}}
        <div class="news-list__head">
            <h2 class="news-list__title" id="newsListTitle">Últimas notícias</h2>
            <p class="news-count" id="newsCount" aria-live="polite"></p>
        </div>

        <ul class="news-grid" id="newsGrid">
            @foreach($posts as $post)
                @php $d = $date($post); @endphp

                <li class="news-item"
                    data-category="{{ $post['category'] }}"
                    @if($loop->first) data-featured="true" hidden @endif
                    data-reveal style="--reveal-delay:{{ ($loop->index % 3) * 100 }}ms">

                    <article class="news-card">
                        <a href="{{ $postUrl($post) }}" class="news-card__media">
                            <img src="{{ $src($post['image']) }}" alt="{{ $post['title'] }}" loading="lazy">

                            <time class="news-card__date" datetime="{{ $d->toDateString() }}">
                                <small>{{ ucfirst($d->translatedFormat('M')) }}</small>
                                <strong>{{ $d->format('d') }}</strong>
                                <small>{{ $d->format('Y') }}</small>
                            </time>
                        </a>

                        <div class="news-card__body">
                            <span class="news-tag">{{ $post['category'] }}</span>
                            <h3 class="news-card__title">
                                <a href="{{ $postUrl($post) }}">{{ $post['title'] }}</a>
                            </h3>
                            <p class="news-card__excerpt">{{ $post['excerpt'] }}</p>
                            <a href="{{ $postUrl($post) }}" class="btn btn--outline">Ler mais</a>
                        </div>
                    </article>
                </li>
            @endforeach
        </ul>

        {{-- Empty state --}}
        <div class="news-empty" id="newsEmpty" hidden>
            <i class='bx bx-search-alt' aria-hidden="true"></i>
            <h3>Nenhuma notícia encontrada</h3>
            <p>Tente outra palavra ou escolha outra categoria.</p>
            <button type="button" class="btn btn--outline" id="newsReset">Limpar filtros</button>
        </div>

        {{-- Load more --}}
        <div class="news-more">
            <button type="button" class="btn btn--outline" id="newsMore" hidden>
                Ver mais notícias <i class='bx bx-chevron-down'></i>
            </button>
        </div>
    </div>
</section>

<script>
    (() => {
        const STEP = 6;

        const chips    = document.querySelectorAll('.news-filter');
        const cards    = [...document.querySelectorAll('.news-item')];
        const search   = document.getElementById('newsSearch');
        const featured = document.getElementById('newsFeatured');
        const title    = document.getElementById('newsListTitle');
        const count    = document.getElementById('newsCount');
        const empty    = document.getElementById('newsEmpty');
        const more     = document.getElementById('newsMore');
        const reset    = document.getElementById('newsReset');

        const normalize = (s) => s.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

        // texto pesquisável de cada cartão (categoria + título + resumo)
        cards.forEach(c => {
            const parts = c.querySelectorAll('.news-tag, .news-card__title, .news-card__excerpt');
            c.dataset.search = normalize([...parts].map(el => el.textContent).join(' ').replace(/\s+/g, ' '));
        });

        let category = 'all';
        let query = '';
        let limit = STEP;

        const render = () => {
            const filtering = category !== 'all' || query !== '';

            if (featured) featured.hidden = filtering;
            title.textContent = filtering ? 'Resultados' : 'Últimas notícias';

            const matches = cards.filter(c => {
                if (c.dataset.featured && !filtering) return false; // já aparece no destaque
                const okCategory = category === 'all' || c.dataset.category === category;
                return okCategory && c.dataset.search.includes(query);
            });

            cards.forEach(c => { c.hidden = true; });
            matches.slice(0, limit).forEach(c => { c.hidden = false; });

            const shown = Math.min(limit, matches.length);
            count.textContent = matches.length ? `A mostrar ${shown} de ${matches.length}` : '';
            empty.hidden = matches.length > 0;
            more.hidden = matches.length <= limit;

            chips.forEach(chip => {
                const on = chip.dataset.category === category;
                chip.classList.toggle('is-active', on);
                chip.setAttribute('aria-pressed', on);
            });
        };

        chips.forEach(chip => chip.addEventListener('click', () => {
            category = chip.dataset.category;
            limit = STEP;
            render();
        }));

        search.addEventListener('input', () => {
            query = normalize(search.value.trim());
            limit = STEP;
            render();
        });

        more.addEventListener('click', () => { limit += STEP; render(); });

        reset.addEventListener('click', () => {
            category = 'all';
            query = '';
            search.value = '';
            limit = STEP;
            render();
        });

        render();
    })();
</script>
@endsection