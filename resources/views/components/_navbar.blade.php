{{-- resources/views/components/_navbar.blade.php --}}
<header class="site-header">

    {{-- Barra superior --}}
    <div class="topbar">
        <div class="topbar__inner">
            <a href="tel:+244900000000" class="topbar__item">
                <i class='bx bx-phone-call'></i> +244 900 000 000
            </a>

            <span class="topbar__item topbar__item--address">
                <i class='bx bx-map'></i> Cabinda, Angola
            </span>

            <a href="{{ url('/suporte') }}" class="topbar__pill">
                <i class='bx bx-support'></i> Suporte
            </a>
        </div>
    </div>

    {{-- Barra principal --}}
    <nav class="navbar" aria-label="Navegação principal">

        <div class="navbar__panel navbar__panel--brand">
            <a href="{{ url('/') }}" class="navbar__brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Ceedwork">
            </a>
        </div>

        <button class="navbar__toggle" id="navbarToggle"
                aria-label="Abrir menu" aria-expanded="false" aria-controls="navbarMenu">
            <i class='bx bx-menu'></i>
        </button>

        <div class="navbar__panel navbar__panel--menu" id="navbarMenu">
            <ul class="navbar__links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Início</a></li>
                <li><a href="{{ url('/blog') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a></li>
                <li><a href="{{ url('/about-us') }}" class="{{ request()->is('about-us') ? 'active' : '' }}">Sobre nós</a></li>
                <li><a href="{{ url('/services') }}" class="{{ request()->is('services*') ? 'active' : '' }}">Serviços</a></li>
                <li><a href="{{ url('/portfolio') }}" class="{{ request()->is('portfolio*') ? 'active' : '' }}">Portfólio</a></li>
                <li><a href="{{ url('/noticias') }}" class="{{ request()->is('noticias*') ? 'active' : '' }}">Notícias</a></li>
                <li><a href="{{ url('/contacts') }}" class="{{ request()->is('contacts') ? 'active' : '' }}">Contactos</a></li>
            </ul>
        </div>
    </nav>
</header>

<script>
    (() => {
        const toggle = document.getElementById('navbarToggle');
        const menu = document.getElementById('navbarMenu');
        const icon = toggle.querySelector('i');

        const setOpen = (open) => {
            menu.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open);
            icon.className = open ? 'bx bx-x' : 'bx bx-menu';
        };

        toggle.addEventListener('click', () => setOpen(!menu.classList.contains('is-open')));
        menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setOpen(false)));
        window.addEventListener('resize', () => window.innerWidth > 1024 && setOpen(false));
    })();
</script>