{{-- resources/views/sobre.blade.php --}}
@extends('layouts.main')

@section('title', 'Sobre nós | Ceedwork')
@section('description', 'Conheça a Ceedwork-Solutions, empresa angolana de tecnologia sediada em Cabinda, especializada em soluções digitais inovadoras.')

@section('herosection')
    @include('components._page-header', [
    'title'  => 'Quem somos',
    'crumbs' => [
        ['label' => 'Início', 'url' => '/'],
        ['label' => 'Sobre nós'],
    ],
])
@endsection

@section('content')
@php
    // Aceita URL externa (Unsplash) ou ficheiro local em public/assets/images
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);
    $u   = fn ($id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=900&q=75";

    $values = [
        ['icon' => 'bx-medal',        'title' => 'Excelência',  'text' => 'Compromisso com a qualidade em todos os nossos serviços.'],
        ['icon' => 'bx-bulb',         'title' => 'Inovação',    'text' => 'Busca constante por soluções criativas e eficientes.'],
        ['icon' => 'bx-badge-check',  'title' => 'Compromisso', 'text' => 'Dedicação total para atender e superar as expectativas dos clientes.'],
        ['icon' => 'bx-shield-quarter','title' => 'Ética',      'text' => 'Conduta transparente e responsável em todas as nossas ações.'],
        ['icon' => 'bx-group',        'title' => 'Parceria',    'text' => 'Relacionamentos duradouros baseados na confiança e colaboração.'],
    ];
@endphp

{{-- Quem somos --}}
<section class="about-block">
    <div class="container about-block__inner">

        <div class="collage" data-reveal="left" aria-hidden="true">
            <img src="{{ $u('1552664730-d307ca884978') }}" alt="" loading="lazy" style="--i:0">
            <img src="{{ $u('1497366216548-37526070297c') }}" alt="" loading="lazy" style="--i:1">
        </div>

        <div class="about-block__content" data-reveal="right" style="--reveal-delay:150ms">
            <p class="about-block__lead">
                A Ceedwork-Solutions é uma empresa angolana de tecnologia especializada no desenvolvimento de soluções digitais inovadoras. Localizados na província de Cabinda, próxima Rua Da Polícia, estamos comprometidos em oferecer serviços de alta qualidade que atendam às necessidades específicas dos nossos clientes.
            </p>
            <p>
                Desde a nossa fundação, temos trabalhado incansavelmente para oferecer soluções tecnológicas que não apenas atendam às expectativas, mas que superem os padrões do mercado. Com uma equipe de profissionais experientes e dedicados, oferecemos soluções em <strong>desenvolvimento de software, sistemas web, aplicativos mobile e sites institucionais</strong>.
            </p>
        </div>
    </div>
</section>

{{-- Missão --}}
<section class="about-block about-block--reverse">
    <div class="container about-block__inner">

        <div class="about-photo" data-reveal="right">
            <img src="{{ $u('1558494949-ef010cbdcc31') }}" alt="" loading="lazy">
        </div>

        <div class="about-block__content" data-reveal="left" style="--reveal-delay:150ms">
            <h2 class="about-block__title">Nossa missão</h2>
            <p>
                Oferecer soluções tecnológicas inovadoras e personalizadas que impulsionem o crescimento e eficiência dos negócios dos nossos clientes, contribuindo para o desenvolvimento tecnológico de Angola e da região.
            </p>
        </div>
    </div>
</section>

{{-- Visão --}}
<section class="about-block">
    <div class="container about-block__inner">

        <div class="collage" data-reveal="left" aria-hidden="true">
            <img src="{{ $u('1497366811353-6870744d04b2') }}" alt="" loading="lazy" style="--i:0">
            <img src="{{ $u('1517048676732-d65bc937f952') }}" alt="" loading="lazy" style="--i:1">
        </div>

        <div class="about-block__content" data-reveal="right" style="--reveal-delay:150ms">
            <h2 class="about-block__title">Nossa visão</h2>
            <p>
                Ser reconhecida como a principal provedora de soluções tecnológicas em Angola, destacando-nos pela excelência, inovação e compromisso com os nossos clientes.
            </p>
        </div>
    </div>
</section>

{{-- Valores --}}
<section class="values">
    <div class="container">
        <header class="values__head" data-reveal>
            <h2 class="about-block__title">Nossos valores</h2>
        </header>

        <ul class="values__grid">
            @foreach($values as $value)
                <li class="value" data-reveal style="--reveal-delay:{{ $loop->index * 100 }}ms">
                    <span class="value__icon" aria-hidden="true"><i class='bx {{ $value['icon'] }}'></i></span>
                    <h3>{{ $value['title'] }}</h3>
                    <p>{{ $value['text'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- Localização --}}
<section class="location">
    <div class="container">
        <header class="location__head" data-reveal>
            <h2 class="about-block__title">Nossa localização</h2>
        </header>

        <div class="location__grid">
            <article class="info-card" data-reveal>
                <span class="info-card__icon" aria-hidden="true"><i class='bx bxs-map'></i></span>
                <div>
                    <h3>Angola - Cabinda</h3>
                    <p> Rua Da Polícia, Cabinda</p>
                    <a href="https://maps.app.goo.gl/g9L8ig8PieojeWMT8"
                       class="btn btn--outline" target="_blank" rel="noopener noreferrer">
                        Ver no mapa <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
            </article>

            <article class="info-card" data-reveal style="--reveal-delay:120ms">
                <span class="info-card__icon" aria-hidden="true"><i class='bx bx-globe'></i></span>
                <div>
                    <h3>Presença regional</h3>
                    <p>Servindo clientes em toda a região</p>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- MAPA --}}
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.0581698972233!2d12.188846399999997!3d-5.5583968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a5dd3f0bb5f797d%3A0xeeae68a407b38dfe!2sCeedwork-solution%2CLda!5e0!3m2!1spt-PT!2sao!4v1793964279518!5m2!1spt-PT!2sao" width="100%" style="margin-bottom: 50px;" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
@endsection