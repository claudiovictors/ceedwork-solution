@extends('layouts.main')

@section('title', 'Contactos | Ceedwork')
@section('description', 'Fale com a Ceedwork-Solutions: telefones, emails, localização em Cabinda, formulário de contacto e perguntas frequentes.')

@section('content')
@php
    // ---- Dados de contacto (troca pelos reais) ----
    $phones = [
        ['label' => '+244 900 000 000', 'href' => 'tel:+244900000000'],
    ];

    $emails = [
        ['label' => 'info@ceedwork-solutions.com',     'href' => 'mailto:info@ceedwork-solutions.com'],
    ];

    $whatsapp = 'https://wa.me/244900000000';
    $mapUrl   = 'https://maps.app.goo.gl/g9L8ig8PieojeWMT8';

    // ---- Perguntas frequentes (exemplos: confirma e ajusta as respostas) ----
    $faqs = [
        [
            'q' => 'Que tipos de projetos a Ceedwork desenvolve?',
            'a' => 'Desenvolvemos software à medida, sistemas web, aplicativos mobile e sites institucionais, sempre adaptados às necessidades de cada cliente.',
        ],
        [
            'q' => 'Como posso pedir um orçamento?',
            'a' => 'Preencha o formulário desta página, escreva-nos por email ou ligue. Depois de entendermos o que precisa, enviamos uma proposta com prazos e valores.',
        ],
        [
            'q' => 'Quanto tempo leva a desenvolver um projeto?',
            'a' => 'Depende da complexidade e do âmbito. Um site institucional costuma ser mais rápido do que um sistema de gestão completo. O cronograma é definido na proposta.',
        ],
        [
            'q' => 'Oferecem suporte depois da entrega?',
            'a' => 'Sim, acompanhamos os projetos após a entrega, com suporte técnico e manutenção. Os detalhes do acompanhamento são combinados em cada projeto.',
        ],
        [
            'q' => 'Atendem clientes fora de Cabinda?',
            'a' => 'Estamos sediados em Cabinda e servimos clientes em toda a região. O acompanhamento pode ser feito presencialmente ou à distância.',
        ],
        [
            'q' => 'Posso ver exemplos de trabalhos anteriores?',
            'a' => 'Claro! Consulte a página de portfólio ou peça-nos exemplos relacionados com o seu sector.',
        ],
        [
            'q' => 'Como falo com o suporte técnico?',
            'a' => 'Use o email de suporte ou o WhatsApp indicados nesta página, ou escolha o assunto "Suporte técnico" no formulário.',
        ],
    ];
@endphp

@section('herosection')
    @include('components._page-header', [
        'title'  => 'Contactos',
        'crumbs' => [
            ['label' => 'Início', 'url' => '/'],
            ['label' => 'Contactos'],
        ],
    ])
@endsection

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
                <li>Angola - Cabinda</li>
                <li><a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">Ver no mapa</a></li>
            </ul>
        </article>

        <article class="contact-card" data-reveal style="--reveal-delay:300ms">
            <span class="contact-card__icon" aria-hidden="true"><i class='bx bxs-time-five'></i></span>
            <h3>Horário</h3>
            <ul>
                <li>Segunda a sexta</li>
                <li>08h - 17h</li>
            </ul>
        </article>
    </div>
</section>

{{-- Formulário + apoio rápido --}}
<section class="contact-main">
    <div class="container contact-main__inner">

        <div class="contact-intro" data-reveal="left">
            <span class="eyebrow">Fale connosco</span>
            <h2 class="contact-title">Envie-nos uma mensagem</h2>
            <p>
                Tem um projeto em mente, uma dúvida ou precisa de ajuda? Preencha o formulário e a nossa equipe responde o mais breve possível.
            </p>

            <ul class="contact-quick">
                <li>
                    <i class='bx bx-time-five' aria-hidden="true"></i>
                    <span>Respondemos nos dias úteis, dentro do horário de atendimento.</span>
                </li>
                <li>
                    <i class='bx bx-support' aria-hidden="true"></i>
                    <span>Suporte técnico: <a href="mailto:suporte@ceedwork.co.ao">suporte@ceedwork.co.ao</a></span>
                </li>
            </ul>

            <a href="{{ $whatsapp }}" class="btn" target="_blank" rel="noopener noreferrer">
                <i class='bx bxl-whatsapp'></i> Falar no WhatsApp
            </a>

            <ul class="contact-social" aria-label="Redes sociais">
                <li><a href="#" aria-label="Facebook"><i class='bx bxl-facebook'></i></a></li>
                <li><a href="#" aria-label="Instagram"><i class='bx bxl-instagram'></i></a></li>
                <li><a href="#" aria-label="LinkedIn"><i class='bx bxl-linkedin'></i></a></li>
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
            <span class="eyebrow">Dúvidas</span>
            <h2 class="faq__title">Perguntas frequentes</h2>
        </header>

        <div class="faq__list">
            @foreach($faqs as $faq)
                <details class="faq__item" name="faq" data-reveal style="--reveal-delay:{{ $loop->index * 60 }}ms">
                    <summary>
                        <span>{{ $faq['q'] }}</span>
                        <i class='bx bx-chevron-down' aria-hidden="true"></i>
                    </summary>
                    <div class="faq__answer">
                        <p>{{ $faq['a'] }}</p>
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