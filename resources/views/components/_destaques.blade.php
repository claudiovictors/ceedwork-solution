@php
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    $posts = $posts ?? [
        [
            'title'   => 'Ceedwork lança nova plataforma de gestão',
            'excerpt' => 'A Ceedwork apresentou a sua nova solução pensada para as necessidades das empresas angolanas, com foco em simplicidade e segurança.',
            'image'   => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=75',
            'date'    => '2026-07-01',
            'url'     => '/noticias/1',
        ],
        [
            'title'   => 'Presença marcante na feira de tecnologia',
            'excerpt' => 'A equipa participou na edição deste ano, partilhando casos de sucesso e novas tendências em transformação digital.',
            'image'   => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=75',
            'date'    => '2026-06-15',
            'url'     => '/noticias/2',
        ],
        [
            'title'   => 'Nova parceria reforça infraestrutura',
            'excerpt' => 'Um novo acordo estratégico vai ampliar a capacidade de resposta e o suporte aos clientes em todo o país.',
            'image'   => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=75',
            'date'    => '2026-05-05',
            'url'     => '/noticias/3',
        ],
        [
            'title'   => 'Workshop de segurança digital',
            'excerpt' => 'Realizámos um workshop prático sobre boas práticas de cibersegurança para pequenas e médias empresas.',
            'image'   => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=75',
            'date'    => '2026-04-20',
            'url'     => '/noticias/4',
        ],
        [
            'title'   => 'Equipa cresce com novos talentos',
            'excerpt' => 'Damos as boas-vindas a novos profissionais que vão reforçar as áreas de desenvolvimento e suporte técnico.',
            'image'   => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=800&q=75',
            'date'    => '2026-03-10',
            'url'     => '/noticias/5',
        ],
    ];
@endphp

<section class="highlights">
    <div class="container">

        <header class="highlights__head" data-reveal>
            <span class="eyebrow">Nossos Serviços</span>
            <h2 class="highlights__title">Destaques</h2>
        </header>

        <div class="highlights__slider" data-reveal style="--reveal-delay:150ms">

            <button type="button" class="slider-btn slider-btn--prev" id="hlPrev" aria-label="Anterior">
                <i class='bx bx-chevron-left'></i>
            </button>

            <div class="highlights__track" id="hlTrack">
                @foreach($posts as $post)
                    @php $date = \Carbon\Carbon::parse($post['date'])->locale('pt'); @endphp

                    <article class="post">
                        <a href="{{ url($post['url']) }}" class="post__media">
                            <img src="{{ $src($post['image']) }}" alt="{{ $post['title'] }}" loading="lazy">

                            <time class="post__date" datetime="{{ $date->toDateString() }}">
                                <small>{{ ucfirst($date->translatedFormat('M')) }}</small>
                                <strong>{{ $date->format('d') }}</strong>
                                <small>{{ $date->format('Y') }}</small>
                            </time>
                        </a>

                        <div class="post__body">
                            <h3 class="post__title">{{ $post['title'] }}</h3>
                            <p class="post__excerpt">{{ $post['excerpt'] }}</p>
                            <a href="{{ url($post['url']) }}" class="btn btn--outline">Ler mais</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <button type="button" class="slider-btn slider-btn--next" id="hlNext" aria-label="Seguinte">
                <i class='bx bx-chevron-right'></i>
            </button>
        </div>
    </div>
</section>

<script>
    (() => {
        const slider = document.querySelector('.highlights__slider');
        const track  = document.getElementById('hlTrack');
        const prev   = document.getElementById('hlPrev');
        const next   = document.getElementById('hlNext');

        const DELAY = 4500;
        const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
        let timer = null;

        const gap     = () => parseFloat(getComputedStyle(track).columnGap) || 24;
        const step    = () => track.querySelector('.post').offsetWidth + gap();
        const atStart = () => track.scrollLeft <= 4;
        const atEnd   = () => track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;

        // Dá a volta: no fim volta ao início, e vice-versa
        const goNext = () => atEnd()
            ? track.scrollTo({ left: 0, behavior: 'smooth' })
            : track.scrollBy({ left: step(), behavior: 'smooth' });

        const goPrev = () => atStart()
            ? track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' })
            : track.scrollBy({ left: -step(), behavior: 'smooth' });

        const stop  = () => { clearInterval(timer); timer = null; };
        const start = () => { if (reduced) return; stop(); timer = setInterval(goNext, DELAY); };

        // Esconde setas se todos os cards já cabem no ecrã
        const checkControls = () => {
            const needed = track.scrollWidth > track.clientWidth + 4;
            prev.hidden = next.hidden = !needed;
            needed ? start() : stop();
        };

        // Manual: clique reinicia o contador do autoplay
        next.addEventListener('click', () => { goNext(); start(); });
        prev.addEventListener('click', () => { goPrev(); start(); });

        // Pausa quando o utilizador interage
        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
        slider.addEventListener('focusin', stop);
        slider.addEventListener('focusout', start);
        slider.addEventListener('touchstart', stop, { passive: true });
        slider.addEventListener('touchend', start, { passive: true });

        // Não gasta recursos com a aba escondida
        document.addEventListener('visibilitychange', () => document.hidden ? stop() : start());

        window.addEventListener('resize', checkControls);
        checkControls();
    })();
</script>