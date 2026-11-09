<footer class="footer">
    <div class="footer__container">

        <div class="footer__grid">

            {{-- Coluna 1: marca + newsletter --}}
            <div class="footer__col footer__col--brand" data-reveal>
                <a href="{{ route('home') }}" class="footer__logo">
                    <img src="{{ asset($data['core']['logo_white']) }}" alt="Ceedwork">
                </a>

                <p>Soluções de tecnologia para o seu negócio crescer.</p>
                <p>Cabinda, Angola</p>

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
                            <p> Rua Da Polícia, Cabinda</p>
                        </div>
                    </li>
                    <li>
                        <i class='bx bxs-time-five'></i>
                        <div>
                            <h3 class="footer__title">Horário</h3>
                            <p>Seg-Sex: 08h-17h</p>
                        </div>
                    </li>
                    <li>
                        <i class='bx bxs-phone'></i>
                        <div>
                            <h3 class="footer__title">Telefone</h3>
                            <p><a href="tel:+244 947 824 328">+244 947 824 328</a></p>
                        </div>
                    </li>
                    <li>
                        <i class='bx bx-envelope'></i>
                        <div>
                            <h3 class="footer__title">Email</h3>
                            <p><a href="mailto:info@ceedwork-solutions.com">info@ceedwork-solutions.com</a></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Redes sociais --}}
        <ul class="footer__social">
            <li><a href="{{  $data['social']['facebook'] }}" aria-label="Facebook" target="_blank"><i class='bx bxl-facebook'></i></a></li>
            <li><a href="{{  $data['social']['tiktok'] }}" aria-label="TikTok" target="_blank"><i class='bx bxl-tiktok'></i></a></li>
            <li><a href="{{  $data['social']['instagram'] }}" aria-label="Instagram" target="_blank"><i class='bx bxl-instagram'></i></a></li>
            <li><a href="{{  $data['social']['linkedin'] }}" aria-label="LinkedIn" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
            <li><a href="{{  $data['social']['whatsapp'] }}" aria-label="WhatsApp" target="_blank"><i class='bx bxl-whatsapp'></i></a></li>
        </ul>

        <p class="footer__copy">
            <strong>Ceedwork</strong>, todos os direitos reservados &copy; {{ date('Y') }}.
        </p>
    </div>

    <a href="#" class="footer__top" id="backToTop" aria-label="Voltar ao topo">
        <i class='bx bx-chevron-up'></i>
    </a>

    @include('components._assistant')

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