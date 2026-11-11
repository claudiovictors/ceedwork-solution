{{-- resources/views/sobre.blade.php --}}
@extends('layouts.main')

@section('title', 'Sobre nós | Ceedwork')
@section('description', 'Conheça a Ceedwork-Solutions, empresa angolana de tecnologia sediada em Cabinda, especializada em soluções digitais inovadoras.')

@php
    $banner = $pageContent->get('about', 'banner', null, []);
    $intro = $pageContent->get('about', 'intro', null, []);
    $images = $pageContent->get('about', 'images', null, []);
    $mission = $pageContent->get('about', 'mission', null, []);
    $vision = $pageContent->get('about', 'vision', null, []);
    $values = $pageContent->get('about', 'values', null, []);
    $location = $pageContent->get('about', 'location', null, []);

    $mapUrl = $site->get('contact.map_url');
    $mapEmbed = $site->get('contact.map_embed_url');

    $valueItems = $values['items'] ?? [];
@endphp

@section('herosection')
    @include('components._page-header', [
        'title' => $banner['title'] ?? 'Quem somos',
        'image' => \App\Support\ImageUrl::for($banner['image'] ?? null),
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Sobre nós'],
        ],
    ])
@endsection

@section('content')
{{-- Quem somos --}}
<section class="about-block">
    <div class="container about-block__inner">

        <div class="collage" data-reveal="left">
            <img src="{{ \App\Support\ImageUrl::for($images['collage_1'] ?? null) }}"
                 alt="{{ $images['collage_1_alt'] ?? '' }}" loading="lazy" style="--i:0">
            <img src="{{ \App\Support\ImageUrl::for($images['collage_2'] ?? null) }}"
                 alt="{{ $images['collage_2_alt'] ?? '' }}" loading="lazy" style="--i:1">
        </div>

        <div class="about-block__content" data-reveal="right" style="--reveal-delay:150ms">
            <div class="about-block__lead">
                {!! $intro['paragraph_1'] ?? '' !!}
            </div>
            <div>
                {!! $intro['paragraph_2'] ?? '' !!}
            </div>
        </div>
    </div>
</section>

{{-- Missão --}}
<section class="about-block about-block--reverse">
    <div class="container about-block__inner">

        <div class="about-photo" data-reveal="right">
            <img src="{{ \App\Support\ImageUrl::for($images['mission_image'] ?? null) }}"
                 alt="{{ $images['mission_image_alt'] ?? '' }}" loading="lazy">
        </div>

        <div class="about-block__content" data-reveal="left" style="--reveal-delay:150ms">
            <h2 class="about-block__title">{{ $mission['title'] ?? 'Nossa missão' }}</h2>
            <div>{!! $mission['body'] ?? '' !!}</div>
        </div>
    </div>
</section>

{{-- Visão --}}
<section class="about-block">
    <div class="container about-block__inner">

        <div class="collage" data-reveal="left">
            <img src="{{ \App\Support\ImageUrl::for($images['vision_1'] ?? null) }}"
                 alt="{{ $images['vision_1_alt'] ?? '' }}" loading="lazy" style="--i:0">
            <img src="{{ \App\Support\ImageUrl::for($images['vision_2'] ?? null) }}"
                 alt="{{ $images['vision_2_alt'] ?? '' }}" loading="lazy" style="--i:1">
        </div>

        <div class="about-block__content" data-reveal="right" style="--reveal-delay:150ms">
            <h2 class="about-block__title">{{ $vision['title'] ?? 'Nossa visão' }}</h2>
            <div>{!! $vision['body'] ?? '' !!}</div>
        </div>
    </div>
</section>

{{-- Valores --}}
<section class="values">
    <div class="container">
        <header class="values__head" data-reveal>
            <h2 class="about-block__title">{{ $values['title'] ?? 'Nossos valores' }}</h2>
        </header>

        <ul class="values__grid">
            @foreach($valueItems as $value)
                <li class="value" data-reveal style="--reveal-delay:{{ $loop->index * 100 }}ms">
                    <span class="value__icon" aria-hidden="true"><i class='bx {{ $value['icon'] ?? 'bx-star' }}'></i></span>
                    <h3>{{ $value['title'] ?? '' }}</h3>
                    <p>{{ $value['text'] ?? '' }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- Localização --}}
<section class="location">
    <div class="container">
        <header class="location__head" data-reveal>
            <h2 class="about-block__title">{{ $location['title'] ?? 'Nossa localização' }}</h2>
        </header>

        <div class="location__grid">
            <article class="info-card" data-reveal>
                <span class="info-card__icon" aria-hidden="true"><i class='bx bxs-map'></i></span>
                <div>
                    <h3>{{ $location['card_1_title'] ?? 'Angola - Cabinda' }}</h3>
                    <p>{{ $location['card_1_text'] ?? '' }}</p>
                    @if($mapUrl)
                        <a href="{{ $mapUrl }}"
                           class="btn btn--outline" target="_blank" rel="noopener noreferrer">
                            Ver no mapa <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    @endif
                </div>
            </article>

            <article class="info-card" data-reveal style="--reveal-delay:120ms">
                <span class="info-card__icon" aria-hidden="true"><i class='bx bx-globe'></i></span>
                <div>
                    <h3>{{ $location['card_2_title'] ?? 'Presença regional' }}</h3>
                    <p>{{ $location['card_2_text'] ?? '' }}</p>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- MAPA --}}
@if($mapEmbed)
    <iframe src="{{ $mapEmbed }}" width="100%" style="margin-bottom: 50px; border:0;" height="450" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
@endif
@endsection
