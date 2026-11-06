@php
    $title  = $title  ?? 'Soluções de tecnologia que impulsionam o seu negócio.';
    $text   = $text   ?? 'Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.';
    $image  = $image  ?? 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80';
    $button = $button ?? 'Saber mais';
    $link   = $link   ?? '/sobre-nos';
@endphp

<section class="hero">
    <div class="hero__container">

        <div class="hero__media">
            <img src="{{ asset('assets/images/herosection.png') }}" alt="Equipa da Ceedwork a trabalhar" loading="eager" fetchpriority="high">
        </div>

        <div class="hero__content">
            <h1 class="hero__title">{{ $title }}</h1>

            @if($text)
                <p class="hero__text">{{ $text }}</p>
            @endif

            <div class="hero__actions">
                <a href="{{ url($link) }}" class="btn">
                    {{ $button }} <i class='bx bx-right-arrow-alt'></i>
                </a>
                <a href="{{ url('/contactos') }}" class="btn btn--ghost-light">
                    Fale connosco
                </a>
            </div>
        </div>
    </div>

    <span class="hero__curve" aria-hidden="true"></span>
</section>