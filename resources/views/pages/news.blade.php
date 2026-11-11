{{-- resources/views/news.blade.php --}}
@extends('layouts.main')

@section('title', 'Notícias | Ceedwork')
@section('description', 'Acompanhe as novidades da Ceedwork-Solutions: projetos, eventos, parcerias e dicas de tecnologia.')

@php
    $header = $pageContent->get('news', 'header', null, []);
@endphp

@section('herosection')
    @include('components._page-header', [
        'title' => $header['title'] ?? 'Notícias',
        'image' => \App\Support\ImageUrl::for($header['image'] ?? null),
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Notícias'],
        ],
    ])
@endsection

@section('content')
@php
    // Aceita uma URL externa ou um ficheiro local em public/assets/images
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    $posts = collect($posts ?? [])->values();
    $featured = $posts->first();
    $categories = $categories ?? $posts->pluck('category')->filter()->unique()->values();

    $postUrl = fn ($p) => route('news.show', $p['slug']);
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
            <p>Ainda não há notícias publicadas ou os filtros não correspondem.</p>
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