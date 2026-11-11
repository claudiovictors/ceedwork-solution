@php
    $siteName = (string) $site->get('general.site_name', 'Ceedwork');
    $logo = $site->get('general.logo', $data['core']['logo'] ?? null);
    $logoWhite = $site->get('general.logo_white', $data['core']['logo_white'] ?? $logo);
    $phones = $site->get('contact.phones', []);
    $emails = $site->get('contact.emails', []);
    $address = $site->get('contact.address');
    $socialLinks = $site->get('social.links', []);
    $socialIcons = [
        'facebook' => 'bxl-facebook',
        'instagram' => 'bxl-instagram',
        'linkedin' => 'bxl-linkedin',
        'tiktok' => 'bxl-tiktok',
        'whatsapp' => 'bxl-whatsapp',
        'youtube' => 'bxl-youtube',
        'x' => 'bxl-twitter',
        'github' => 'bxl-github',
    ];
    $primaryPhone = $phones[0] ?? null;
@endphp

<header class="site-header">

    {{-- Barra superior --}}
    <div class="topbar">
        <div class="topbar__inner">
            @if($primaryPhone)
                <a href="{{ $primaryPhone['href'] ?? '#' }}" class="topbar__item">
                    <i class='bx bx-phone-call'></i> {{ $primaryPhone['label'] ?? '' }}
                </a>
            @endif

            <span class="topbar__item topbar__item--address">
                <i class='bx bx-map'></i> {{ $address ?: 'Cabinda, Angola' }}
            </span>

            <a href="{{ route('contact') }}" class="topbar__pill">
                <i class='bx bx-support'></i> Suporte
            </a>
        </div>
    </div>

    {{-- Barra principal --}}
    <nav class="navbar" aria-label="Navegação principal">

        {{-- Botão hambúrguer (só aparece no mobile/tablet, à esquerda) --}}
        <button class="navbar__toggle" id="navbarToggle" aria-label="Abrir menu" aria-expanded="false"
            aria-controls="navbarMenu">
            <i class='bx bx-menu'></i>
        </button>

        <div class="navbar__panel navbar__panel--brand">
            <a href="{{ route('home') }}" class="navbar__brand">
                <img src="{{ \App\Support\ImageUrl::for($logo) }}" alt="{{ $siteName }}">
            </a>
        </div>

        {{-- Desktop: links na barra | Mobile: gaveta (drawer) à esquerda --}}
        <div class="navbar__panel navbar__panel--menu" id="navbarMenu">

            <div class="drawer__head">
                <a href="{{ route('home') }}" class="drawer__brand">
                    <img src="{{ \App\Support\ImageUrl::for($logoWhite) }}" alt="{{ $siteName }}">
                </a>
                <button type="button" class="drawer__close" id="navbarClose" aria-label="Fechar menu">
                    <i class='bx bx-x'></i>
                </button>
            </div>

            <span class="drawer__label">Navegação</span>

            <ul class="navbar__links">
                <li><a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Início</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->is('about-us') ? 'active' : '' }}">Sobre nós</a></li>
                <li><a href="{{ route('services') }}" class="{{ request()->is('services*') ? 'active' : '' }}">Serviços</a></li>
                <li><a href="{{ route('portfolio') }}" class="{{ request()->is('portfolio*') ? 'active' : '' }}">Portfólio</a></li>
                <li><a href="{{ route('news') }}" class="{{ request()->is('news*') ? 'active' : '' }}">Notícias</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->is('contacts') ? 'active' : '' }}">Contactos</a></li>
            </ul>

            <div class="drawer__extra">
                <span class="drawer__label">Contactos</span>

                <ul class="drawer__contacts">
                    @foreach($phones as $phone)
                        <li><a href="{{ $phone['href'] ?? '#' }}"><i class='bx bx-phone-call'></i> {{ $phone['label'] ?? '' }}</a></li>
                    @endforeach

                    @foreach($emails as $email)
                        <li><a href="mailto:{{ $email['email'] ?? '' }}"><i class='bx bx-envelope'></i> {{ $email['email'] ?? '' }}</a></li>
                    @endforeach

                    <li><span><i class='bx bx-map'></i> {{ $address ?: 'Cabinda, Angola' }}</span></li>
                    <li><a href="{{ route('contact') }}"><i class='bx bx-support'></i> Suporte</a></li>
                </ul>

                <span class="drawer__label">Redes sociais</span>

                <ul class="drawer__social" aria-label="Redes sociais">
                    @foreach($socialLinks as $link)
                        @php
                            $network = $link['network'] ?? '';
                            $icon = $socialIcons[$network] ?? 'bxl-'.$network;
                        @endphp

                        @if($network !== '' && ! empty($link['url']))
                            <li>
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($network) }}">
                                    <i class='bx {{ $icon }}'></i>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    {{-- Fundo escuro atrás da gaveta (só mobile) --}}
    <div class="navbar__overlay" id="navbarOverlay"></div>
</header>

<script>
    (() => {
        const toggle = document.getElementById('navbarToggle');
        const closeBtn = document.getElementById('navbarClose');
        const menu = document.getElementById('navbarMenu');
        const overlay = document.getElementById('navbarOverlay');

        const isOpen = () => menu.classList.contains('is-open');

        const setOpen = (open) => {
            menu.classList.toggle('is-open', open);
            overlay.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open);
            document.documentElement.classList.toggle('menu-open', open); // bloqueia o scroll da página
            (open ? closeBtn : toggle).focus();
        };

        toggle.addEventListener('click', () => setOpen(true));
        closeBtn.addEventListener('click', () => setOpen(false));
        overlay.addEventListener('click', () => setOpen(false));
        menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setOpen(false)));

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isOpen()) setOpen(false);
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024 && isOpen()) setOpen(false);
        });
    })();
</script>