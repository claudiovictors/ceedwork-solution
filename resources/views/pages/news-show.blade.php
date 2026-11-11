{{-- resources/views/news-show.blade.php --}}
@extends('layouts.main')

@section('title', $post->title . ' | Ceedwork')
@section('description', $post->excerpt)

@section('herosection')
    @include('components._page-header', [
        'title'  => 'Notícias',
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Notícias', 'url' => '/news'],
            ['label' => Illuminate\Support\Str::limit($post->title, 40)],
        ],
    ])
@endsection

@section('content')
@php
    $postUrl = fn (\App\Models\Post $p) => route('news.show', $p);

    $publishedAt = $post->published_at ?? $post->created_at;
    $categoryName = $post->category?->name ?? 'Sem categoria';
    $authorName = $post->author?->name ?? 'Ceedwork';
    $coverImage = $post->cover_url;
    $body = $post->body ?? '';

    // minutos de leitura (~200 palavras por minuto)
    $words   = preg_match_all('/\pL+/u', strip_tags($body));
    $minutes = max(1, (int) ceil($words / 200));

    // links de partilha
    $enc  = rawurlencode(url()->current());
    $text = rawurlencode($post->title);
@endphp

{{-- barra de progresso de leitura --}}
<div class="reading-progress" id="readingProgress" aria-hidden="true"></div>

<article class="article">

    <header class="container article__head">
        <a href="{{ url('/news') }}" class="article__back">
            <i class='bx bx-arrow-back' aria-hidden="true"></i> Voltar às notícias
        </a>

        <span class="news-tag">{{ $categoryName }}</span>
        <h1 class="article__title">{{ $post->title }}</h1>

        <ul class="article__meta">
            <li><i class='bx bx-calendar' aria-hidden="true"></i> <time datetime="{{ $publishedAt->toDateString() }}">{{ $publishedAt->locale('pt')->translatedFormat('d \d\e F \d\e Y') }}</time></li>
            <li><i class='bx bx-time-five' aria-hidden="true"></i> {{ $minutes }} min de leitura</li>
            <li><i class='bx bx-user' aria-hidden="true"></i> {{ $authorName }}</li>
        </ul>
    </header>

    <figure class="container article__cover" data-reveal="zoom">
        <img src="{{ $coverImage }}" alt="{{ $post->title }}" loading="eager" fetchpriority="high">
    </figure>

    <div class="container article__layout">

        {{-- Partilhar --}}
        <aside class="article__share" aria-label="Partilhar esta notícia">
            <span class="article__share-label">Partilhar</span>
            <ul>
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $enc }}" target="_blank" rel="noopener noreferrer" aria-label="Partilhar no Facebook">
                        <i class='bx bxl-facebook'></i>
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/intent/tweet?url={{ $enc }}&text={{ $text }}" target="_blank" rel="noopener noreferrer" aria-label="Partilhar no X (Twitter)">
                        <i class='bx bxl-twitter'></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $enc }}" target="_blank" rel="noopener noreferrer" aria-label="Partilhar no LinkedIn">
                        <i class='bx bxl-linkedin'></i>
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/?text={{ $text }}%20{{ $enc }}" target="_blank" rel="noopener noreferrer" aria-label="Partilhar no WhatsApp">
                        <i class='bx bxl-whatsapp'></i>
                    </a>
                </li>
                <li>
                    <button type="button" id="copyLink" aria-label="Copiar link">
                        <i class='bx bx-link'></i>
                    </button>
                </li>
            </ul>
        </aside>

        <div class="article__main">
            {{-- Conteúdo em HTML (só de fontes de confiança, ex: o teu painel de admin) --}}
            <div class="article__body prose">
                {!! $body !!}
            </div>

            {{-- Autor --}}
            <div class="author">
                <span class="author__avatar" aria-hidden="true">CW</span>
                <div>
                    <h3>{{ $authorName }}</h3>
                    <p>Empresa angolana de tecnologia, sediada em Cabinda, especializada no desenvolvimento de soluções digitais inovadoras.</p>
                    <a href="{{ url('/about-us') }}" class="author__link">
                        Conhecer a Ceedwork <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>

{{-- Relacionadas --}}
@if($related->count())
    <section class="related">
        <div class="container">
            <header class="related__head" data-reveal>
                <span class="eyebrow">Continue a ler</span>
                <h2 class="related__title">Notícias relacionadas</h2>
            </header>

            <ul class="news-grid">
                @foreach($related as $item)
                    @php $rd = $item->published_at ?? $item->created_at; @endphp

                    <li class="news-item" data-reveal style="--reveal-delay:{{ $loop->index * 100 }}ms">
                        <article class="news-card">
                            <a href="{{ $postUrl($item) }}" class="news-card__media">
                                <img src="{{ $item->cover_url }}" alt="{{ $item->title }}" loading="lazy">

                                <time class="news-card__date" datetime="{{ $rd->toDateString() }}">
                                    <small>{{ ucfirst($rd->locale('pt')->translatedFormat('M')) }}</small>
                                    <strong>{{ $rd->format('d') }}</strong>
                                    <small>{{ $rd->format('Y') }}</small>
                                </time>
                            </a>

                            <div class="news-card__body">
                                <span class="news-tag">{{ $item->category?->name ?? 'Sem categoria' }}</span>
                                <h3 class="news-card__title">
                                    <a href="{{ $postUrl($item) }}">{{ $item->title }}</a>
                                </h3>
                                <p class="news-card__excerpt">{{ $item->excerpt }}</p>
                                <a href="{{ $postUrl($item) }}" class="btn btn--outline">Ler mais</a>
                            </div>
                        </article>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

<span class="copy-toast" id="copyToast" role="status">Link copiado!</span>

<script>
    (() => {
        // ---- barra de progresso de leitura ----
        const bar     = document.getElementById('readingProgress');
        const content = document.querySelector('.article__body');

        const update = () => {
            const top   = content.getBoundingClientRect().top + window.scrollY;
            const range = content.offsetHeight - window.innerHeight * 0.5;
            const p     = range > 0 ? (window.scrollY - top + window.innerHeight * 0.3) / range : 1;
            bar.style.transform = `scaleX(${Math.min(Math.max(p, 0), 1)})`;
        };

        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        update();

        // ---- copiar link ----
        const copy  = document.getElementById('copyLink');
        const toast = document.getElementById('copyToast');

        copy.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(window.location.href);
            } catch (e) {
                const input = document.createElement('input');
                input.value = window.location.href;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                input.remove();
            }

            toast.classList.add('is-visible');
            setTimeout(() => toast.classList.remove('is-visible'), 2000);
        });
    })();
</script>
@endsection