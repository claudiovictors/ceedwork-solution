{{-- resources/views/portfolio.blade.php --}}
@extends('layouts.main')

@section('title', 'Portfólio | Ceedwork')
@section('description', 'Conheça alguns dos projetos desenvolvidos pela Ceedwork-Solutions para empresas e instituições.')

@php
    $header = $pageContent->get('portfolio', 'header', null, []);
@endphp

@section('herosection')
    @include('components._page-header', [
        'title' => $header['title'] ?? 'Portfólio',
        'image' => \App\Support\ImageUrl::for($header['image'] ?? null),
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Portfólio'],
        ],
    ])
@endsection

@section('content')
<section class="news">
    <div class="container">

        @if(! empty($header['intro']))
            <div class="services-intro__body" data-reveal>
                <div>{!! $header['intro'] !!}</div>
            </div>
        @endif

        <ul class="news-grid">
            @forelse($projects as $project)
                <li class="news-item" data-reveal style="--reveal-delay:{{ ($loop->index % 3) * 100 }}ms">
                    <article class="news-card">
                        @if($project->url)
                            <a href="{{ $project->url }}" class="news-card__media" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $project->image_url }}" alt="{{ $project->name }}" loading="lazy">
                            </a>
                        @else
                            <div class="news-card__media">
                                <img src="{{ $project->image_url }}" alt="{{ $project->name }}" loading="lazy">
                            </div>
                        @endif

                        <div class="news-card__body">
                            @if($project->category)
                                <span class="news-tag">{{ $project->category }}</span>
                            @endif

                            <h3 class="news-card__title">{{ $project->name }}</h3>

                            @if($project->summary)
                                <p class="news-card__excerpt">{{ $project->summary }}</p>
                            @endif

                            @if($project->url)
                                <a href="{{ $project->url }}" class="btn btn--outline" target="_blank" rel="noopener noreferrer">
                                    Ver projeto
                                </a>
                            @endif
                        </div>
                    </article>
                </li>
            @empty
                <li class="news-empty">
                    <i class='bx bx-folder-open' aria-hidden="true"></i>
                    <h3>Ainda não há projetos publicados</h3>
                    <p>Volte em breve para conhecer os nossos trabalhos.</p>
                </li>
            @endforelse
        </ul>

        @if($projects->hasPages())
            <nav class="news-more" aria-label="Paginação do portfólio">
                @if($projects->previousPageUrl())
                    <a href="{{ $projects->previousPageUrl() }}" class="btn btn--outline">
                        <i class='bx bx-left-arrow-alt'></i> Anteriores
                    </a>
                @endif

                @if($projects->nextPageUrl())
                    <a href="{{ $projects->nextPageUrl() }}" class="btn btn--outline">
                        Seguintes <i class='bx bx-right-arrow-alt'></i>
                    </a>
                @endif
            </nav>
        @endif
    </div>
</section>
@endsection
