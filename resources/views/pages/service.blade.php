@extends('layouts.main')

@section('title', 'Serviços | Ceedwork')
@section('description', 'Desenvolvimento de software sob medida, aplicações mobile e soluções web: conheça os serviços da Ceedwork-Solutions, em Cabinda.')

@section('herosection')
    @include('components._page-header', [
        'title'  => 'Serviços',
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Serviços'],
        ],
    ])
@endsection

@section('content')
@php
    // Aceita URL externa (Unsplash) ou ficheiro local em public/assets/images
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    // Para adicionar/editar um serviço, mexe só neste array
    $services = [
        [
            'id'      => 'software',
            'icon'    => 'bx-code-alt',
            'short'   => 'Software',
            'eyebrow' => 'Serviço 01',
            'title'   => 'Desenvolvimento de Software',
            'text'    => 'Soluções feitas à medida das necessidades do seu negócio.',
            'image'   => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Desenvolvimento de software sob medida',
                'Sistemas de gestão empresarial (ERP)',
            ],
        ],
        [
            'id'      => 'mobile',
            'icon'    => 'bx-mobile-alt',
            'short'   => 'Mobile',
            'eyebrow' => 'Serviço 02',
            'title'   => 'Desenvolvimento Mobile',
            'text'    => 'Aplicações para os dispositivos que os seus clientes usam todos os dias.',
            'image'   => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Aplicações Android',
                'Aplicações iOS',
                'Aplicações híbridas (Flutter / React Native)',
            ],
        ],
        [
            'id'      => 'web',
            'icon'    => 'bx-globe',
            'short'   => 'Web',
            'eyebrow' => 'Serviço 03',
            'title'   => 'Desenvolvimento Web',
            'text'    => 'A presença digital da sua empresa, do site institucional à loja online.',
            'image'   => 'https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Criação de websites institucionais',
                'Desenvolvimento de lojas online (E-commerce)',
                'Portais corporativos',
            ],
        ],
    ];
@endphp

{{-- Introdução + atalhos --}}
<section class="services-intro">
    <div class="container">
        <div class="services-intro__body" data-reveal>
            <span class="eyebrow">O que fazemos</span>
            <h2 class="services-intro__title">Soluções digitais sob medida</h2>
            <p>
                Da ideia ao produto final, desenvolvemos software, aplicações mobile e soluções web pensadas para as necessidades do seu negócio.
            </p>

            <ul class="services-nav" aria-label="Ir para um serviço">
                @foreach($services as $service)
                    <li>
                        <a href="#{{ $service['id'] }}">
                            <i class='bx {{ $service['icon'] }}' aria-hidden="true"></i> {{ $service['short'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- Blocos de serviço (alternam o lado e o fundo) --}}
@foreach($services as $service)
    @php $even = $loop->even; @endphp

    <section class="service {{ $even ? 'service--alt' : '' }}" id="{{ $service['id'] }}">
        <div class="container service__inner">

            <div class="service__media" data-reveal="{{ $even ? 'right' : 'left' }}">
                <img src="{{ $src($service['image']) }}" alt="{{ $service['title'] }}" loading="lazy">
                <span class="service__badge" aria-hidden="true"><i class='bx {{ $service['icon'] }}'></i></span>
            </div>

            <div class="service__content" data-reveal="{{ $even ? 'left' : 'right' }}" style="--reveal-delay:150ms">
                <span class="eyebrow">{{ $service['eyebrow'] }}</span>
                <h2 class="service__title">{{ $service['title'] }}</h2>

                @if(!empty($service['text']))
                    <p>{{ $service['text'] }}</p>
                @endif

                <ul class="service__list">
                    @foreach($service['items'] as $item)
                        <li>
                            <i class='bx bx-check-circle' aria-hidden="true"></i>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ url('/contacts') }}" class="btn">
                    Pedir orçamento <i class='bx bx-right-arrow-alt'></i>
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
                <span class="eyebrow">Vamos conversar</span>
                <h2>Tem um projeto em mente?</h2>
                <p>Fale connosco e receba uma proposta adaptada às suas necessidades.</p>
            </div>

            <div class="services-cta__actions">
                <a href="{{ url('/contacts') }}" class="btn">
                    Fale connosco <i class='bx bx-right-arrow-alt'></i>
                </a>
                <a href="tel:+244900000000" class="services-cta__phone">
                    <i class='bx bx-phone-call' aria-hidden="true"></i> ou ligue +244 900 000 000
                </a>
            </div>
        </div>
    </div>
</section>
@endsection