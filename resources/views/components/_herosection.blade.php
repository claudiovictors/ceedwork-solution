@php
    $hero = $pageContent->get('home', 'hero', null, []);
    $heroBackground = \App\Support\ImageUrl::for($hero['background_image'] ?? null, asset('assets/images/banners/herosection.png'));
    $heroFeatured = \App\Support\ImageUrl::for($hero['featured_image'] ?? null, asset('assets/images/banners/herosection.png'));
    $heroFeaturedAlt = $hero['featured_image_alt'] ?? 'Equipa da Ceedwork a trabalhar';
    $showFeatured = filter_var($hero['show_featured'] ?? true, FILTER_VALIDATE_BOOLEAN);
@endphp

<section class="hero" style="--hero-bg: url('{{ $heroBackground }}')">
    <div class="hero__container">

        @if($showFeatured)
            <div class="hero__media">
                <img src="{{ $heroFeatured }}" alt="{{ $heroFeaturedAlt }}" loading="eager" fetchpriority="high">
            </div>
        @endif

        <div class="hero__content">
            <h1 class="hero__title">{{ $hero['title'] ?? 'Soluções de tecnologia que impulsionam o seu negócio.' }}</h1>

            <p class="hero__text">{{ $hero['text'] ?? 'Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.' }}</p>

            <div class="hero__actions">
                <a href="{{ url($hero['primary_link'] ?? '/about-us') }}" class="btn">
                    {{ $hero['primary_label'] ?? 'Saber mais' }} <i class='bx bx-right-arrow-alt'></i>
                </a>
                <a href="{{ url($hero['secondary_link'] ?? '/contact') }}" class="btn btn--ghost-light">
                    {{ $hero['secondary_label'] ?? 'Fale connosco' }}
                </a>
            </div>
        </div>
    </div>

    <span class="hero__curve" aria-hidden="true"></span>
</section>