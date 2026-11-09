@php
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    $brands = $brands ?? [
        [
            'name'  => 'Ceedwork Solution',
            'image' => $data['core']['mark_ceedwork'],
            'url'   => route('services'),
        ],
        [
            'name'  => 'Ceedwork Wyza',
            'image' => $data['core']['mark_wiza'],
            'url'   => 'https://wyza.ceedwork-solution.com/',
        ],
        [
            'name'  => 'CANDONGA',
            'image' => $data['core']['mark_candonga'],
            'url'   => route('services'),
        ],
    ];
@endphp

<section class="brands" aria-label="Áreas de negócio">
    <ul class="container brands__list">
        @foreach($brands as $brand)
            <li class="brands__item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * 120 }}ms">
                <a href="{{ url($brand['url']) }}"
                   target="_blank"
                   class="brands__link"
                   title="{{ $brand['name'] }}"
                   @if(!empty($brand['external'])) target="_blank" rel="noopener noreferrer" @endif>
                    <img src="{{ $src($brand['image']) }}" alt="{{ $brand['name'] }}" loading="lazy">
                </a>
            </li>
        @endforeach
    </ul>
</section>