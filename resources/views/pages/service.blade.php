@extends('layouts.main')

@section('title', 'Serviços | Ceedwork')
@section('description', 'Conheça as soluções tecnológicas da Ceedwork-Solutions: softwares de gestão, plataformas digitais, websites, aplicativos móveis, redes, segurança informática e transformação digital.')

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
    // Aceita imagens externas ou ficheiros locais em public/
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://'])
        ? $p
        : asset($p);

    // Catálogo de serviços da Ceedwork-Solutions
    $services = [
        [
            'id'      => 'software',
            'icon'    => 'bx-code-alt',
            'short'   => 'Softwares',
            'eyebrow' => 'Serviço 01',
            'title'   => 'Desenvolvimento de Softwares de Gestão',
            'text'    => 'Desenvolvemos sistemas inteligentes e personalizados para otimizar processos, melhorar a gestão e aumentar a eficiência das instituições públicas e privadas.',
            'image'   => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Sistemas de gestão hospitalar',
                'Sistemas de gestão escolar',
                'Sistemas de faturação empresarial',
                'Sistemas de gestão administrativa',
                'Softwares personalizados para instituições públicas e privadas',
            ],
        ],
        [
            'id'      => 'plataformas',
            'icon'    => 'bx-layer',
            'short'   => 'Plataformas',
            'eyebrow' => 'Serviço 02',
            'title'   => 'Desenvolvimento de Plataformas Digitais',
            'text'    => 'Criamos plataformas digitais que aproximam instituições dos cidadãos, simplificam processos e tornam os serviços mais acessíveis.',
            'image'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Plataformas institucionais para administrações públicas',
                'Portais digitais de serviços ao cidadão',
                'Plataformas de gestão administrativa',
                'Sistemas de atendimento digital',
            ],
        ],
        [
            'id'      => 'websites',
            'icon'    => 'bx-globe',
            'short'   => 'Websites',
            'eyebrow' => 'Serviço 03',
            'title'   => 'Criação de Websites Institucionais',
            'text'    => 'Desenvolvemos websites modernos e profissionais que fortalecem a presença digital e facilitam a comunicação das instituições com o público.',
            'image'   => 'https://images.unsplash.com/photo-1547658719-da2b51169166?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Websites governamentais',
                'Websites empresariais',
                'Portais de informação institucional',
                'Portais de divulgação de projetos e serviços',
            ],
        ],
        [
            'id'      => 'mobile',
            'icon'    => 'bx-mobile-alt',
            'short'   => 'Aplicativos',
            'eyebrow' => 'Serviço 04',
            'title'   => 'Desenvolvimento de Aplicativos Móveis',
            'text'    => 'Transformamos ideias em aplicações móveis funcionais, permitindo que instituições e empresas disponibilizem os seus serviços diretamente aos utilizadores.',
            'image'   => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Aplicativos institucionais',
                'Aplicativos de serviços públicos',
                'Aplicativos empresariais',
                'Desenvolvimento para Android e iOS',
            ],
        ],
        [
            'id'      => 'infraestrutura',
            'icon'    => 'bx-network-chart',
            'short'   => 'Infraestrutura',
            'eyebrow' => 'Serviço 05',
            'title'   => 'Infraestrutura Tecnológica e Redes',
            'text'    => 'Implementamos e estruturamos infraestruturas tecnológicas para garantir conectividade, estabilidade e comunicação eficiente entre os equipamentos e sistemas.',
            'image'   => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Instalação e configuração de redes informáticas',
                'Estruturação de redes institucionais',
            ],
        ],
        [
            'id'      => 'suporte',
            'icon'    => 'bx-wrench',
            'short'   => 'Suporte técnico',
            'eyebrow' => 'Serviço 06',
            'title'   => 'Manutenção e Suporte Técnico',
            'text'    => 'Prestamos assistência técnica especializada para manter os equipamentos e sistemas em pleno funcionamento, reduzindo falhas e interrupções.',
            'image'   => 'https://images.unsplash.com/photo-1581092921461-eab62e97a780?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Assistência técnica informática',
                'Manutenção de computadores',
                'Manutenção preventiva e corretiva de sistemas',
            ],
        ],
        [
            'id'      => 'seguranca',
            'icon'    => 'bx-shield-quarter',
            'short'   => 'Segurança',
            'eyebrow' => 'Serviço 07',
            'title'   => 'Segurança Informática',
            'text'    => 'Protegemos os ativos digitais das instituições através de soluções e práticas de segurança que ajudam a preservar a integridade, confidencialidade e disponibilidade dos dados.',
            'image'   => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Implementação de políticas de segurança digital',
                'Proteção de sistemas e dados institucionais',
                'Monitoramento de segurança informática',
            ],
        ],
        [
            'id'      => 'transformacao',
            'icon'    => 'bx-transfer-alt',
            'short'   => 'Transformação',
            'eyebrow' => 'Serviço 08',
            'title'   => 'Transformação Digital',
            'text'    => 'Ajudamos instituições a modernizar as suas operações através da digitalização, automatização e implementação de soluções tecnológicas.',
            'image'   => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Digitalização de processos administrativos',
                'Implementação de sistemas eletrónicos de gestão documental',
                'Automatização de serviços administrativos',
            ],
        ],
        [
            'id'      => 'corporativos',
            'icon'    => 'bx-briefcase-alt-2',
            'short'   => 'Corporativos',
            'eyebrow' => 'Serviço 09',
            'title'   => 'Serviços Corporativos',
            'text'    => 'Disponibilizamos soluções e consultoria tecnológica para apoiar a organização, comunicação e gestão dos recursos digitais das instituições.',
            'image'   => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1000&q=75',
            'items'   => [
                'Criação de e-mails institucionais e corporativos',
                'Gestão de plataformas digitais',
                'Consultoria tecnológica para instituições públicas e privadas',
            ],
        ],
    ];
@endphp

{{-- Introdução + atalhos --}}
<section class="services-intro">
    <div class="container">
        <div class="services-intro__body" data-reveal>
            <span class="eyebrow">O que fazemos</span>

            <h2 class="services-intro__title">
                Tecnologia e inovação para transformar instituições
            </h2>

            <p>
                A Ceedwork-Solutions disponibiliza um conjunto de soluções
                tecnológicas desenvolvidas para responder às necessidades
                de empresas, instituições públicas e privadas.
                Da criação de softwares à transformação digital,
                trabalhamos para tornar os processos mais simples,
                eficientes e seguros.
            </p>

            <ul class="services-nav" aria-label="Ir para um serviço">
                @foreach($services as $service)
                    <li>
                        <a href="#{{ $service['id'] }}">
                            <i class='bx {{ $service['icon'] }}' aria-hidden="true"></i>
                            {{ $service['short'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- Blocos de serviços --}}
@foreach($services as $service)
    @php $even = $loop->even; @endphp

    <section
        class="service {{ $even ? 'service--alt' : '' }}"
        id="{{ $service['id'] }}"
    >
        <div class="container service__inner">

            <div
                class="service__media"
                data-reveal="{{ $even ? 'right' : 'left' }}"
            >
                <img
                    src="{{ $src($service['image']) }}"
                    alt="{{ $service['title'] }}"
                    loading="lazy"
                >

                <span class="service__badge" aria-hidden="true">
                    <i class='bx {{ $service['icon'] }}'></i>
                </span>
            </div>

            <div
                class="service__content"
                data-reveal="{{ $even ? 'left' : 'right' }}"
                style="--reveal-delay:150ms"
            >
                <span class="eyebrow">
                    {{ $service['eyebrow'] }}
                </span>

                <h2 class="service__title">
                    {{ $service['title'] }}
                </h2>

                <p>{{ $service['text'] }}</p>

                <ul class="service__list">
                    @foreach($service['items'] as $item)
                        <li>
                            <i class='bx bx-check-circle' aria-hidden="true"></i>
                            <span>{{ $item }}</span>
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
                <span class="eyebrow">Vamos conversar</span>

                <h2>Tem um projeto em mente?</h2>

                <p>
                    Seja uma empresa, instituição pública ou privada,
                    estamos preparados para ajudar a transformar
                    as suas necessidades em soluções tecnológicas.
                </p>
            </div>

            <div class="services-cta__actions">
                <a href="{{ url('/contacts') }}" class="btn">
                    Fale connosco
                    <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

        </div>
    </div>
</section>
@endsection