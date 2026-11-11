@php
    $services = $pageContent->get('home', 'services', 'items', []);
@endphp

@if(! empty($services))
    <section class="areas">
        @foreach($services as $service)
            @php
                $even = $loop->even;
                $images = preg_split('/\R+/', trim((string) ($service['images'] ?? ''))) ?: [];
            @endphp

            {{-- ímpares: fundo branco | pares: fundo tintado --}}
            <div class="area {{ $even ? 'area--alt' : '' }}">
                <div class="container area__inner">

                    <div class="mosaic" data-reveal="{{ $even ? 'right' : 'left' }}" aria-hidden="true">
                        @foreach($images as $img)
                            @continue(trim($img) === '')
                            <img src="{{ \App\Support\ImageUrl::for(trim($img)) }}" alt="" loading="lazy" style="--i:{{ $loop->index }}">
                        @endforeach
                    </div>

                    <div class="area__content" data-reveal="{{ $even ? 'left' : 'right' }}" style="--reveal-delay:150ms">
                        <span class="eyebrow">{{ $service['eyebrow'] ?? '' }}</span>
                        <h2 class="area__title">{{ $service['title'] ?? '' }}</h2>
                        <p>{!! $service['text'] ?? '' !!}</p>
                        <a href="{{ url($service['link'] ?? '/servicos') }}" class="btn">Saber mais</a>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endif
