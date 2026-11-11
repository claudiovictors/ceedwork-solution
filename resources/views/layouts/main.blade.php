<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@php
    $siteName = (string) $site->get('general.site_name', config('app.name'));
    $seoDescription = (string) $site->get('general.seo_description', 'Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.');
    $faviconUrl = \App\Support\ImageUrl::for($site->get('general.favicon'), asset('assets/images/core/favicon.ico'));
    $ogImageUrl = \App\Support\ImageUrl::for($site->get('general.og_image'), asset('assets/images/banners/herosection.png'));

    $theme = is_array($theme ?? null) ? $theme : [];
    $hex = fn (mixed $value, string $fallback): string => is_string($value) && preg_match('/^#[0-9a-fA-F]{6}$/', $value) === 1 ? $value : $fallback;
    $darken = function (string $color, int $percent): string {
        $color = ltrim($color, '#');
        $factor = max(0, 100 - $percent) / 100;

        return sprintf(
            '#%02x%02x%02x',
            (int) round(hexdec(substr($color, 0, 2)) * $factor),
            (int) round(hexdec(substr($color, 2, 2)) * $factor),
            (int) round(hexdec(substr($color, 4, 2)) * $factor)
        );
    };

    $themeVars = [
        '--color-primary' => $hex($theme['primary'] ?? null, '#031b3a'),
        '--color-secondary' => $hex($theme['secondary'] ?? null, '#13397c'),
        '--color-blue' => $hex($theme['blue'] ?? null, '#2f96bf'),
        '--color-purple' => $hex($theme['purple'] ?? null, '#475593'),
        '--color-teal' => $hex($theme['accent'] ?? null, '#1baa99'),
        '--color-aqua' => $hex($theme['aqua'] ?? null, '#5eb3bb'),
        '--color-light-blue' => $hex($theme['light_blue'] ?? null, '#c3ebfa'),
        '--color-background' => $hex($theme['background'] ?? null, '#dae1f1'),
    ];

    $themeVars['--accent-hover'] = $darken($themeVars['--color-teal'], 12);
    $themeCss = '';

    foreach ($themeVars as $property => $value) {
        $themeCss .= "{$property}: {$value}; ";
    }
@endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', $seoDescription)">

    <title>@yield('title', $siteName)</title>

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="@yield('title', $siteName)">
    <meta property="og:description" content="@yield('description', $seoDescription)">
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="shortcut icon" href="{{ $faviconUrl }}" type="image/x-icon">

    <style>:root { {!! $themeCss !!} }</style>

    <script>document.documentElement.classList.add('js')</script>
</head>
<body>
    {{-- NavBar --}}
    @include('components._navbar')

    @yield('herosection')

    <main class="container">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components._footer')

    <script src="{{ asset('assets/js/reveal.js') }}" defer></script>
</body>
</html>