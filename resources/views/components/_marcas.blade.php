@php
    $brands = $pageContent->get('home', 'brands', 'items', []);
@endphp

<section class="brands" aria-label="Áreas de negócio">
    <ul class="container brands__list">
        @foreach($brands as $brand)
            @php
                $url = $brand['url'] ?? '';
                $href = $url !== '' ? url($url) : '#';
            @endphp

            <li class="brands__item" data-reveal="zoom" style="--reveal-delay:{{ $loop->index * 120 }}ms">
                <a href="{{ $href }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="brands__link"
                   title="{{ $brand['name'] ?? '' }}">
                    <img src="{{ \App\Support\ImageUrl::for($brand['image'] ?? null) }}"
                         alt="{{ $brand['name'] ?? '' }}" loading="lazy">
                </a>
            </li>
        @endforeach
    </ul>
</section>
