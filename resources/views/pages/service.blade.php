@extends('layouts.main')

@section('title', 'Serviços | Ceedwork')
@section('description', 'Conheça as soluções tecnológicas da Ceedwork-Solutions: softwares de gestão, plataformas digitais, websites, aplicativos móveis, redes, segurança informática e transformação digital.')

@php
    $header = $pageContent->get('services', 'header', null, []);
    $cta = $pageContent->get('services', 'cta', null, []);
@endphp

@section('herosection')
    @include('components._page-header', [
        'title' => $header['title'] ?? 'Serviços',
        'image' => \App\Support\ImageUrl::for($header['image'] ?? null),
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Serviços'],
        ],
    ])
@endsection

@section('content')
@php
    $iconClass = fn (?string $icon): string => trim((string) preg_replace('/^bx\s+/', '', (string) $icon)) ?: 'bx-code-alt';
@endphp

{{-- Introdução + atalhos --}}
<section class="services-intro">
    <div class="container">
        <div class="services-intro__body" data-reveal>
            @if(! empty($header['intro_eyebrow']))
                <span class="eyebrow">{{ $header['intro_eyebrow'] }}</span>
            @endif

            <h2 class="services-intro__title">
                {{ $header['intro_title'] ?? 'Tecnologia e inovação para transformar instituições' }}
            </h2>

            <div>{!! $header['intro'] ?? '' !!}</div>

            <ul class="services-nav" aria-label="Ir para um serviço">
                @foreach($services as $service)
                    <li>
                        <a href="#{{ $service->slug }}">
                            <i class='bx {{ $iconClass($service->icon) }}' aria-hidden="true"></i>
                            {{ $service->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- Blocos de serviços --}}
@foreach($services as $service)
    @php
        $even = $loop->even;
        $eyebrow = 'Serviço '.str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
    @endphp

    <section
        class="service {{ $even ? 'service--alt' : '' }}"
        id="{{ $service->slug }}"
    >
        <div class="container service__inner">

            <div
                class="service__media"
                data-reveal="{{ $even ? 'right' : 'left' }}"
            >
                <img
                    src="{{ $service->image_url }}"
                    alt="{{ $service->title }}"
                    loading="lazy"
                >

                <span class="service__badge" aria-hidden="true">
                    <i class='bx {{ $iconClass($service->icon) }}'></i>
                </span>
            </div>

            <div
                class="service__content"
                data-reveal="{{ $even ? 'left' : 'right' }}"
                style="--reveal-delay:150ms"
            >
                <span class="eyebrow">
                    {{ $eyebrow }}
                </span>

                <h2 class="service__title">
                    {{ $service->title }}
                </h2>

                <p>{{ $service->summary }}</p>

                <ul class="service__list">
                    @foreach($service->items as $item)
                        <li>
                            <i class='bx bx-check-circle' aria-hidden="true"></i>
                            <span>{{ $item->title }}</span>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ url('/contacts') }}" class="btn">
                    Pedir orçamento
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

        </div>
    </section>
@endforeach

{{-- Chamada final --}}
<section class="services-cta">
    <div class="container">
        <div class="services-cta__box" data-reveal="zoom">

            <div class="services-cta__text">
                <span class="eyebrow">{{ $cta['eyebrow'] ?? 'Vamos conversar' }}</span>

                <h2>{{ $cta['title'] ?? 'Tem um projeto em mente?' }}</h2>

                <p>{{ $cta['text'] ?? 'Seja uma empresa, instituição pública ou privada, estamos preparados para ajudar a transformar as suas necessidades em soluções tecnológicas.' }}</p>
            </div>

            <div class="services-cta__actions">
                <a href="{{ url($cta['button_link'] ?? '/contact') }}" class="btn">
                    {{ $cta['button_label'] ?? 'Fale connosco' }}
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

        </div>
    </div>
</section>
@endsection