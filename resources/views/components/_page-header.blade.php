{{-- resources/views/components/_page-header.blade.php --}}
{{-- Banner reutilizável para páginas internas (Sobre nós, Serviços, Blog...) --}}
@php
    // Aceita URL externa ou ficheiro local em public/assets/images
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    $title  = $title  ?? 'Página';
    $image  = $image  ?? 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1600&q=70';
    $crumbs = $crumbs ?? [];
@endphp

<section class="page-header" style="--ph-image: url('{{ $src($image) }}')">
    <div class="container page-header__inner">

        @if(count($crumbs))
            <nav aria-label="Breadcrumb">
                <ol class="page-header__crumbs">
                    @foreach($crumbs as $crumb)
                        <li>
                            @if(!empty($crumb['url']) && !$loop->last)
                                <a href="{{ url($crumb['url']) }}">{{ $crumb['label'] }}</a>
                            @else
                                <span aria-current="page">{{ $crumb['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif

        <h1 class="page-header__title">{{ $title }}</h1>
    </div>
</section>