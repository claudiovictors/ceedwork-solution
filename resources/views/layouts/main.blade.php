<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Desenvolvimento de software, infraestrutura e consultoria para empresas que querem crescer com segurança e inovação.')">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="shortcut icon" href="{{ $data['core']['favicon'] }}" type="image/x-icon">
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