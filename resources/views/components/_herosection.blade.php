<section class="hero" style="--hero-bg: url('{{ $data [ 'banners' ][ 'herosection' ] }}')">
    <div class="hero__container">

        <div class="hero__media">
            <img src="{{ $data [ 'banners' ][ 'herosection' ] }}" alt="Equipa da Ceedwork a trabalhar" loading="eager" fetchpriority="high">
        </div>

        <div class="hero__content">
            <h1 class="hero__title">Soluções de tecnologia que impulsionam o seu negócio.</h1>

            <p class="hero__text">Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.</p>

            <div class="hero__actions">
                <a href="{{ route('about') }}" class="btn">
                    Saber mais <i class='bx bx-right-arrow-alt'></i>
                </a>
                <a href="{{ route('contact') }}" class="btn btn--ghost-light">
                    Fale connosco
                </a>
            </div>
        </div>
    </div>

    <span class="hero__curve" aria-hidden="true"></span>
</section>