{{-- resources/views/components/_marcas.blade.php --}}
@php
    // Aceita URL externa ou ficheiro local em public/assets/images
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    // Troca 'image' pelos teus PNG, ex: 'assets/images/logo-software.png'
    // 'external' => true abre o link noutro separador
    $brands = $brands ?? [
        [
            'name'  => 'Ceedwork Solution',
            'image' => 'https://placehold.co/280x90/ffffff/13397C/png?text=Ceedwork+Solution',
            'url'   => '/servicos/software',
        ],
        [
            'name'  => 'Ceedwork Wyza',
            'image' => 'https://placehold.co/280x90/ffffff/1BAA99/png?text=Ceedwork+Wyza',
            'url'   => '/servicos/infraestrutura',
        ],
    ];
@endphp

<section class="brands" aria-label="Áreas de negócio">
    <ul class="container brands__list">
        @foreach($brands as $brand)
            <li class="brands__item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * 120 }}ms">
                <a href="{{ url($brand['url']) }}"
                   class="brands__link"
                   title="{{ $brand['name'] }}"
                   @if(!empty($brand['external'])) target="_blank" rel="noopener noreferrer" @endif>
                    <img src="{{ $src($brand['image']) }}" alt="{{ $brand['name'] }}" loading="lazy">
                </a>
            </li>
        @endforeach
    </ul>
</section>