@php
    $src = fn ($p) => Illuminate\Support\Str::startsWith($p, ['http://', 'https://']) ? $p : asset($p);

    $partners = $partners ?? [
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/13397C/png?text=Parceiro+1', 'url' => null],
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/1BAA99/png?text=Parceiro+1', 'url' => null],
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/031B3A/png?text=Parceiro+1', 'url' => null],
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/475593/png?text=Parceiro+1', 'url' => null],
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/2F96BF/png?text=Parceiro+1', 'url' => null],
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/13397C/png?text=Parceiro+1', 'url' => null],
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/1BAA99/png?text=Parceiro+1', 'url' => null],
        ['name' => 'Parceiro 1', 'image' => 'https://placehold.co/220x80/ffffff/031B3A/png?text=Parceiro+1', 'url' => null],
    ];
@endphp

<section class="partners" aria-label="Parceiros estratégicos">
    <div class="container">

        <header class="partners__head" data-reveal>
            <span class="eyebrow">Parcerias</span>
            <h2 class="partners__title">Os nossos parceiros</h2>
        </header>

        <div data-reveal style="--reveal-delay:150ms">
            <ul class="partners__track" id="partnersTrack">
                @foreach($partners as $partner)
                    <li class="partners__item">
                        @if(!empty($partner['url']))
                            <a href="{{ $partner['url'] }}" title="{{ $partner['name'] }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $src($partner['image']) }}" alt="{{ $partner['name'] }}" loading="lazy">
                            </a>
                        @else
                            <img src="{{ $src($partner['image']) }}" alt="{{ $partner['name'] }}" loading="lazy">
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="partners__dots" id="partnersDots"></div>
        </div>
    </div>
</section>

<script>
    (() => {
        const track   = document.getElementById('partnersTrack');
        const dotsBox = document.getElementById('partnersDots');
        const root    = track.closest('.partners');
        const items   = track.querySelectorAll('.partners__item');

        const DELAY = 3500;
        const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
        let page = 0, pages = 1, timer = null;

        const cols       = () => parseInt(getComputedStyle(track).getPropertyValue('--cols')) || 4;
        const gap        = () => parseFloat(getComputedStyle(track).columnGap) || 0;
        const pageWidth  = () => track.clientWidth + gap();
        const maxScroll  = () => track.scrollWidth - track.clientWidth;

        const goTo = (i) => track.scrollTo({ left: Math.min(i * pageWidth(), maxScroll()), behavior: 'smooth' });
        const next = () => goTo((page + 1) % pages); // dá a volta no fim

        const markActive = () => {
            const atEnd = track.scrollLeft >= maxScroll() - 4;
            page = atEnd ? pages - 1 : Math.min(pages - 1, Math.round(track.scrollLeft / pageWidth()));

            dotsBox.querySelectorAll('button').forEach((b, i) => {
                b.classList.toggle('is-active', i === page);
                i === page ? b.setAttribute('aria-current', 'true') : b.removeAttribute('aria-current');
            });
        };

        const stop  = () => { clearInterval(timer); timer = null; };
        const start = () => { stop(); if (!reduced && pages > 1) timer = setInterval(next, DELAY); };

        const build = () => {
            pages = Math.max(1, Math.ceil(items.length / cols()));
            dotsBox.innerHTML = '';
            dotsBox.hidden = pages <= 1;

            for (let i = 0; i < pages; i++) {
                const b = document.createElement('button');
                b.type = 'button';
                b.setAttribute('aria-label', `Ir para o grupo ${i + 1}`);
                b.addEventListener('click', () => { goTo(i); start(); });
                dotsBox.appendChild(b);
            }

            markActive();
            start();
        };

        track.addEventListener('scroll', markActive, { passive: true });

        // Pausa quando o utilizador interage
        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', start);
        root.addEventListener('focusin', stop);
        root.addEventListener('focusout', start);
        root.addEventListener('touchstart', stop, { passive: true });
        root.addEventListener('touchend', start, { passive: true });
        document.addEventListener('visibilitychange', () => document.hidden ? stop() : start());

        window.addEventListener('resize', build);
        build();
    })();
</script>