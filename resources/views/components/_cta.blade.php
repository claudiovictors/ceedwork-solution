{{-- resources/views/components/_cta.blade.php --}}
{{-- Chamada final reutilizável. Todas as variáveis são opcionais. --}}
@php
    $eyebrow = $eyebrow ?? 'Vamos conversar';
    $title   = $title   ?? 'Tem um projeto em mente?';
    $text    = $text    ?? 'Fale connosco e receba uma proposta adaptada às suas necessidades.';
    $button  = $button  ?? 'Fale connosco';
    $link    = $link    ?? '/contactos';
    // Passa 'phone' => false para esconder a linha do telefone
    $phone   = $phone   ?? ['label' => '+244 900 000 000', 'href' => 'tel:+244900000000'];
@endphp

<section class="cta">
    <div class="container">
        <div class="cta__box" data-reveal="zoom">
            <div class="cta__text">
                <span class="eyebrow">{{ $eyebrow }}</span>
                <h2>{{ $title }}</h2>
                <p>{{ $text }}</p>
            </div>

            <div class="cta__actions">
                <a href="{{ url($link) }}" class="btn">
                    {{ $button }} <i class='bx bx-right-arrow-alt'></i>
                </a>

                @if($phone)
                    <a href="{{ $phone['href'] }}" class="cta__phone">
                        <i class='bx bx-phone-call' aria-hidden="true"></i> ou ligue {{ $phone['label'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>