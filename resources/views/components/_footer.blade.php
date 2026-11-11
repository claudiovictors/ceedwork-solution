@php
    $siteName = (string) $site->get('general.site_name', 'Ceedwork');
    $tagline = in_array('institutional', $pageContent->customized('footer'), true)
        ? (string) $pageContent->get('footer', 'institutional', 'text')
        : (string) $site->get('general.tagline', 'Soluções de tecnologia para o seu negócio crescer.');
    $logoWhite = $site->get('general.logo_white', $data['core']['logo_white'] ?? $data['core']['logo'] ?? null);
    $phones = $site->get('contact.phones', []);
    $emails = $site->get('contact.emails', []);
    $address = $site->get('contact.address');
    $hours = $site->get('contact.hours');
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
@endphp

<footer class="footer">
    <div class="footer__container">

        <div class="footer__grid">

            {{-- Coluna 1: marca + newsletter --}}
            <div class="footer__col footer__col--brand" data-reveal>
                <a href="{{ route('home') }}" class="footer__logo">
                    <img src="{{ \App\Support\ImageUrl::for($logoWhite) }}" alt="{{ $siteName }}">
                </a>

                <p>{{ $tagline }}</p>
                <p>{{ $address ?: 'Cabinda, Angola' }}</p>

                <h3 class="footer__title footer__title--sm">Subscreva a nossa Newsletter</h3>

                <form action="#" method="POST" class="footer__newsletter">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required aria-label="Email">
                    <button type="submit">Subscrever</button>
                </form>
            </div>

            {{-- Coluna 2: links --}}
            <div class="footer__col" data-reveal style="--reveal-delay:120ms">
                <h3 class="footer__title">Serviços</h3>
                <ul class="footer__links">
                    <li><a href="{{ route('services')}}">Desenvolvimento de Software</a></li>
                    <li><a href="{{ route('services')}}">Infraestrutura e Redes</a></li>
                    <li><a href="{{ route('services')}}">Consultoria</a></li>
                </ul>

                <h3 class="footer__title">Empresa</h3>
                <ul class="footer__links">
                    <li><a href="{{ route('about') }}">Sobre nós</a></li>
                    <li><a href="{{ route('portfolio') }}">Portfólio</a></li>
                    <li><a href="{{ route('news') }}">Blog</a></li>
                    <li><a href="{{ route('news') }}">Notícias</a></li>
                </ul>
            </div>

            {{-- Coluna 3: contactos --}}
            <div class="footer__col" data-reveal style="--reveal-delay:240ms">
                <ul class="footer__contacts">
                    <li>
                        <i class='bx bxs-map'></i>
                        <div>
                            <h3 class="footer__title">Endereço</h3>
                            <p>{{ $address ?: 'Cabinda, Angola' }}</p>
                        </div>
                    </li>
                    <li>
                        <i class='bx bxs-time-five'></i>
                        <div>
                            <h3 class="footer__title">Horário</h3>
                            <p>{{ $hours ?: 'Seg-Sex: 08h-17h' }}</p>
                        </div>
                    </li>
                    <li>
                        <i class='bx bxs-phone'></i>
                        <div>
                            <h3 class="footer__title">Telefone</h3>
                            <p>
                                @forelse($phones as $phone)
                                    <a href="{{ $phone['href'] ?? '#' }}">{{ $phone['label'] ?? '' }}</a>@if(! $loop->last)<br>@endif
                                @empty
                                    <span>—</span>
                                @endforelse
                            </p>
                        </div>
                    </li>
                    <li>
                        <i class='bx bx-envelope'></i>
                        <div>
                            <h3 class="footer__title">Email</h3>
                            <p>
                                @forelse($emails as $email)
                                    <a href="mailto:{{ $email['email'] ?? '' }}">{{ $email['email'] ?? '' }}</a>@if(! $loop->last)<br>@endif
                                @empty
                                    <span>—</span>
                                @endforelse
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Redes sociais --}}
        <ul class="footer__social">
            @foreach($socialLinks as $link)
                @php
                    $network = $link['network'] ?? '';
                    $icon = $socialIcons[$network] ?? 'bxl-'.$network;
                @endphp

                @if($network !== '' && ! empty($link['url']))
                    <li>
                        <a href="{{ $link['url'] }}" aria-label="{{ ucfirst($network) }}" target="_blank" rel="noopener noreferrer">
                            <i class='bx {{ $icon }}'></i>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        <p class="footer__copy">
            <strong>{{ $siteName }}</strong>, todos os direitos reservados &copy; {{ date('Y') }}.
        </p>
    </div>

    <a href="#" class="footer__top" id="backToTop" aria-label="Voltar ao topo">
        <i class='bx bx-chevron-up'></i>
    </a>

    @if($site->get('assistant.enabled', true))
        @include('components._assistant')
    @endif

</footer>

<script>
    (() => {
        const btn = document.getElementById('backToTop');
        const toggle = () => btn.classList.toggle('is-visible', window.scrollY > 400);
        window.addEventListener('scroll', toggle, { passive: true });
        toggle();

        btn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    })();
</script>