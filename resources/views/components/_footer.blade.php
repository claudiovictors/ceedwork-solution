<footer class="footer">
    <div class="footer__container">

        <div class="footer__grid">

            {{-- Coluna 1: marca + newsletter --}}
            <div class="footer__col footer__col--brand" data-reveal>
                <a href="{{ url('/') }}" class="footer__logo">
                    <img src="{{ asset('assets/images/logo-white.png') }}" alt="Ceedwork">
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
                    <li><a href="{{ url('/servicos') }}">Desenvolvimento de Software</a></li>
                    <li><a href="{{ url('/servicos') }}">Infraestrutura e Redes</a></li>
                    <li><a href="{{ url('/servicos') }}">Consultoria</a></li>
                </ul>

                <h3 class="footer__title">Empresa</h3>
                <ul class="footer__links">
                    <li><a href="{{ url('/sobre-nos') }}">Sobre nós</a></li>
                    <li><a href="{{ url('/portfolio') }}">Portfólio</a></li>
                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                    <li><a href="{{ url('/noticias') }}">Notícias</a></li>
                </ul>
            </div>

            {{-- Coluna 3: contactos --}}
            <div class="footer__col" data-reveal style="--reveal-delay:240ms">
                <ul class="footer__contacts">
                    <li>
                        <i class='bx bxs-map'></i>
                        <div>
                            <h3 class="footer__title">Endereço</h3>
                            <p>Rua Da Policia, Cabinda</p>
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
                            <p><a href="tel:+244900000000">+244 900 000 000</a></p>
                        </div>
                    </li>
                    <li>
                        <i class='bx bx-envelope'></i>
                        <div>
                            <h3 class="footer__title">Email</h3>
                            <p><a href="mailto:geral@ceedwork.co.ao">geral@ceedwork.co.ao</a></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Redes sociais --}}
        <ul class="footer__social">
            <li><a href="#" aria-label="Facebook"><i class='bx bxl-facebook'></i></a></li>
            <li><a href="#" aria-label="Instagram"><i class='bx bxl-instagram'></i></a></li>
            <li><a href="#" aria-label="LinkedIn"><i class='bx bxl-linkedin'></i></a></li>
            <li><a href="#" aria-label="WhatsApp"><i class='bx bxl-whatsapp'></i></a></li>
        </ul>

        <p class="footer__copy">
            <strong>Ceedwork</strong>, todos os direitos reservados &copy; {{ date('Y') }}.
        </p>
    </div>

    <a href="#" class="footer__top" id="backToTop" aria-label="Voltar ao topo">
        <i class='bx bx-chevron-up'></i>
    </a>
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