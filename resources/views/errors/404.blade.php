@extends('layouts.main')

@section('title', 'Página não encontrada | Ceedwork')

@section('content')
<section class="error-page">
    <div class="container error-page__inner">

        <div class="error-page__code" data-reveal="zoom" aria-hidden="true">
            <span>4</span>
            <span class="error-page__zero"><i class='bx bx-search-alt'></i></span>
            <span>4</span>
        </div>

        <div class="error-page__content" data-reveal="right" style="--reveal-delay:150ms">
            <span class="eyebrow">Erro 404</span>
            <h1 class="error-page__title">Página não encontrada</h1>
            <p>A página que procura não existe, mudou de endereço ou já não está disponível.</p>

            <div class="error-page__actions">
                <a href="{{ route('home') }}" class="btn">
                    <i class='bx bx-home-alt' aria-hidden="true"></i> Voltar ao início
                </a>
                <a href="{{ route('contact') }}" class="btn btn--outline">Fale connosco</a>
            </div>

            <p class="error-page__hint">Ou vá diretamente para:</p>

            <ul class="error-page__links">
                <li><a href="{{ route('home') }}">Início</a></li>
                <li><a href="{{ route('about') }}">Sobre nós</a></li>
                <li><a href="{{ route('services') }}">Serviços</a></li>
                <li><a href="{{ route('portfolio') }}">Portfólio</a></li>
                <li><a href="{{ route('news') }}">Notícias</a></li>
                <li><a href="{{ route('contact') }}">Contactos</a></li>
            </ul>
        </div>
    </div>
</section>
@endsection