@extends('layouts.main')

@section('title', 'Contactos | Ceedwork')
@section('description', 'Fale com a Ceedwork-Solutions: telefones, emails, localização em Cabinda, formulário de contacto e perguntas frequentes.')

@php
    $banner = $pageContent->get('contact', 'banner', null, []);
    $intro = $pageContent->get('contact', 'intro', null, []);
    $faq = $pageContent->get('contact', 'faq', null, []);
    $faqs = $faq['items'] ?? [];
    $subjects = collect($pageContent->get('contact', 'subjects', 'items', []))
        ->pluck('subject')
        ->filter()
        ->values()
        ->all();

    $phones = collect($site->get('contact.phones', []))
        ->map(fn (array $phone): array => [
            'label' => $phone['label'] ?? '',
            'href' => $phone['href'] ?? '#',
        ])
        ->filter(fn (array $phone): bool => $phone['label'] !== '')
        ->values()
        ->all();

    $emails = collect($site->get('contact.emails', []))
        ->map(fn (array $email): array => [
            'label' => $email['email'] ?? '',
            'href' => 'mailto:'.($email['email'] ?? ''),
            'type' => $email['type'] ?? '',
        ])
        ->filter(fn (array $email): bool => $email['label'] !== '')
        ->values()
        ->all();

    $support = collect($emails)->firstWhere('type', 'Suporte');
    $supportEmail = $support['label'] ?? ($emails[0]['label'] ?? null);
    $whatsapp = $site->get('contact.whatsapp_url');
    $mapUrl = $site->get('contact.map_url');
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

@section('herosection')
    @include('components._page-header', [
        'title' => $banner['title'] ?? 'Contactos',
        'image' => \App\Support\ImageUrl::for($banner['image'] ?? null),
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Contactos'],
        ],
    ])
@endsection

@section('content')
{{-- Cartões de contacto --}}
<section class="contact-cards">
    <div class="container contact-cards__grid">

        <article class="contact-card" data-reveal>
            <span class="contact-card__icon" aria-hidden="true"><i class='bx bxs-phone'></i></span>
            <h3>Telefone</h3>
            <ul>
                @foreach($phones as $phone)
                    <li><a href="{{ $phone['href'] }}">{{ $phone['label'] }}</a></li>
                @endforeach
            </ul>
        </article>

        <article class="contact-card" data-reveal style="--reveal-delay:100ms">
            <span class="contact-card__icon" aria-hidden="true"><i class='bx bx-envelope'></i></span>
            <h3>Email</h3>
            <ul>
                @foreach($emails as $email)
                    <li><a href="{{ $email['href'] }}">{{ $email['label'] }}</a></li>
                @endforeach
            </ul>
        </article>

        <article class="contact-card" data-reveal style="--reveal-delay:200ms">
            <span class="contact-card__icon" aria-hidden="true"><i class='bx bxs-map'></i></span>
            <h3>Localização</h3>
            <ul>
                <li>{{ $address ?: 'Angola - Cabinda' }}</li>
                @if($mapUrl)
                    <li><a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">Ver no mapa</a></li>
                @endif
            </ul>
        </article>

        <article class="contact-card" data-reveal style="--reveal-delay:300ms">
            <span class="contact-card__icon" aria-hidden="true"><i class='bx bxs-time-five'></i></span>
            <h3>Horário</h3>
            <ul>
                <li>{{ $hours ?: 'Segunda a sexta, 08h - 17h' }}</li>
            </ul>
        </article>
    </div>
</section>

{{-- Formulário + apoio rápido --}}
<section class="contact-main">
    <div class="container contact-main__inner">

        <div class="contact-intro" data-reveal="left">
            @if(! empty($intro['eyebrow']))
                <span class="eyebrow">{{ $intro['eyebrow'] }}</span>
            @endif
            <h2 class="contact-title">{{ $intro['title'] ?? 'Envie-nos uma mensagem' }}</h2>
            <p>{{ $intro['text'] ?? '' }}</p>

            <ul class="contact-quick">
                @if(! empty($intro['quick_1']))
                    <li>
                        <i class='bx bx-time-five' aria-hidden="true"></i>
                        <span>{{ $intro['quick_1'] }}</span>
                    </li>
                @endif
                @if(! empty($intro['quick_2']))
                    <li>
                        <i class='bx bx-support' aria-hidden="true"></i>
                        <span>{{ $intro['quick_2'] }}</span>
                    </li>
                @elseif($supportEmail)
                    <li>
                        <i class='bx bx-support' aria-hidden="true"></i>
                        <span>Suporte técnico: <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></span>
                    </li>
                @endif
            </ul>

            @if($whatsapp)
                <a href="{{ $whatsapp }}" class="btn" target="_blank" rel="noopener noreferrer">
                    <i class='bx bxl-whatsapp'></i> Falar no WhatsApp
                </a>
            @endif

            <ul class="contact-social" aria-label="Redes sociais">
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
        </div>

        <div class="form-card" id="formulario" data-reveal="right" style="--reveal-delay:150ms">

            @if(session('success'))
                <div class="alert alert--success" role="status">
                    <i class='bx bx-check-circle' aria-hidden="true"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert--error" role="alert">
                    <i class='bx bx-error-circle' aria-hidden="true"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" id="contactForm" novalidate>
                @csrf

                {{-- Honeypot anti-spam (escondido) --}}
                <div class="hp" aria-hidden="true">
                    <label for="website">Não preencha este campo</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="form__row">
                    <div class="field {{ $errors->has('name') ? 'field--error' : '' }}">
                        <label for="name">Nome *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               autocomplete="name" required aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                        @error('name') <span class="field__error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field {{ $errors->has('phone') ? 'field--error' : '' }}">
                        <label for="phone">Telefone</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               autocomplete="tel" placeholder="+244 ..." aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}">
                        @error('phone') <span class="field__error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="field {{ $errors->has('email') ? 'field--error' : '' }}">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           autocomplete="email" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                    @error('email') <span class="field__error">{{ $message }}</span> @enderror
                </div>

                <div class="field {{ $errors->has('subject') ? 'field--error' : '' }}">
                    <label for="subject">Assunto *</label>
                    <select id="subject" name="subject" required aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}">
                        <option value="" disabled @selected(!old('subject'))>Escolha um assunto</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" @selected(old('subject') === $subject)>{{ $subject }}</option>
                        @endforeach
                    </select>
                    @error('subject') <span class="field__error">{{ $message }}</span> @enderror
                </div>

                <div class="field {{ $errors->has('message') ? 'field--error' : '' }}">
                    <label for="message">Mensagem *</label>
                    <textarea id="message" name="message" rows="5" required
                              aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}">{{ old('message') }}</textarea>
                    @error('message') <span class="field__error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn" id="contactSubmit">
                    Enviar mensagem <i class='bx bx-send'></i>
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Perguntas frequentes --}}
<section class="faq">
    <div class="container">
        <header class="faq__head" data-reveal>
            @if(! empty($faq['eyebrow']))
                <span class="eyebrow">{{ $faq['eyebrow'] }}</span>
            @endif
            <h2 class="faq__title">{{ $faq['title'] ?? 'Perguntas frequentes' }}</h2>
        </header>

        <div class="faq__list">
            @foreach($faqs as $item)
                <details class="faq__item" name="faq" data-reveal style="--reveal-delay:{{ $loop->index * 60 }}ms">
                    <summary>
                        <span>{{ $item['question'] ?? '' }}</span>
                        <i class='bx bx-chevron-down' aria-hidden="true"></i>
                    </summary>
                    <div class="faq__answer">
                        <p>{{ $item['answer'] ?? '' }}</p>
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>

<script>
    (() => {
        const form = document.getElementById('contactForm');
        const btn  = document.getElementById('contactSubmit');

        // Evita envios duplicados
        form.addEventListener('submit', () => {
            btn.disabled = true;
            btn.innerHTML = 'A enviar… <i class="bx bx-loader-alt bx-spin"></i>';
        });

        // Depois de enviar (ou de erro de validação) leva o utilizador de volta ao formulário
        @if($errors->any() || session('success') || session('error'))
            document.getElementById('formulario').scrollIntoView({ behavior: 'smooth', block: 'center' });
        @endif
    })();
</script>
@endsection