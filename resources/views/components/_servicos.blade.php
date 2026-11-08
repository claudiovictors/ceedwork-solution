@php
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    $u = fn ($id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=600&q=75";

    $services = $services ?? [
        [
            'eyebrow' => 'Desenvolvimento',
            'title'   => 'Software à medida',
            'text'    => 'Criamos <strong>sistemas web e mobile</strong> pensados para o seu negócio: gestão, vendas, faturação e muito mais. Soluções seguras, escaláveis e prontas para crescer consigo.',
            'link'    => '/servicos',
            'images'  => [
                $u('1498050108023-c5249f4df085'),
                $u('1461749280684-dccba630e2f6'),
                $u('1517694712202-14dd9538aa97'),
                $u('1555066931-4365d14bab8c'),
                $u('1526374965328-7f61d4dc18c5'),
                $u('1531297484001-80022131f5a1'),
            ],
        ],
        [
            'eyebrow' => 'Infraestrutura',
            'title'   => 'Equipamentos prontos para servir',
            'text'    => 'Projetamos e instalamos a infraestrutura tecnológica da sua empresa, com <strong>acompanhamento e suporte contínuo</strong> para que o seu negócio nunca pare.',
            'link'    => '/servicos',
            'images'  => [
                $u('1558494949-ef010cbdcc31'),
                $u('1544197150-b99a580bb7a8'),
                $u('1451187580459-43490279c0fa'),
                $u('1518770660439-4636190af475'),
                $u('1563986768609-322da13575f3'),
                $u('1550751827-4bd374c3f58b'),
            ],
        ],
    ];
@endphp

<section class="areas">
    @foreach($services as $service)
        @php $even = $loop->even; @endphp

        {{-- ímpares: fundo branco | pares: fundo tintado --}}
        <div class="area {{ $even ? 'area--alt' : '' }}">
            <div class="container area__inner">

                <div class="mosaic" data-reveal="{{ $even ? 'right' : 'left' }}" aria-hidden="true">
                    @foreach($service['images'] as $img)
                        <img src="{{ $src($img) }}" alt="" loading="lazy" style="--i:{{ $loop->index }}">
                    @endforeach
                </div>

                <div class="area__content" data-reveal="{{ $even ? 'left' : 'right' }}" style="--reveal-delay:150ms">
                    <span class="eyebrow">{{ $service['eyebrow'] }}</span>
                    <h2 class="area__title">{{ $service['title'] }}</h2>
                    <p>{!! $service['text'] !!}</p>
                    <a href="{{ url($service['link']) }}" class="btn">Saber mais</a>
                </div>
            </div>
        </div>
    @endforeach
</section>