<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    @php
        $routePageTitles = [
            'profile.edit' => 'Meu perfil',
        ];

        $currentRouteName = request()->route()?->getName() ?? '';

        $resolvedPageTitle = isset($pageTitle)
            ? trim(strip_tags((string) $pageTitle))
            : ($routePageTitles[$currentRouteName] ?? 'Dashboard');

        $resolvedPageDescription = isset($pageDescription)
            ? trim(strip_tags((string) $pageDescription))
            : null;

        $documentTitle = isset($title)
            ? trim(strip_tags((string) $title))
            : trim(strip_tags(View::yieldContent('title', $resolvedPageTitle)));
    @endphp

    <title>{{ $documentTitle }} | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="shortcut icon"
          href="{{ asset($data['core']['favicon'] ?? 'assets/images/core/favicon.ico') }}"
          type="image/x-icon">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-[#f4f7fb] font-sans text-[#1f2a3d] antialiased">

<div
    x-data="{ sidebarOpen: false, sidebarCollapsed: false, userMenu: false }"
    @resize.window="if (window.innerWidth < 1024) { sidebarCollapsed = false; }"
    class="min-h-screen"
>

    <!-- Mobile overlay -->
    <div
        x-show="sidebarOpen"
        x-cloak
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-[#010414]/60 lg:hidden"
    ></div>

    <!-- Sidebar -->
    <x-admin-sidebar />

    <!-- Main area -->
    <div
        :class="sidebarCollapsed ? 'lg:ml-[76px]' : 'lg:ml-[260px]'"
        class="flex min-h-screen flex-col transition-[margin] duration-300"
    >

        <!-- Topbar -->
        <x-admin-header
            :page-title="$resolvedPageTitle"
            :page-description="$resolvedPageDescription"
        />

        <!-- Main page -->
        <main class="mx-auto w-full max-w-[1600px] flex-1 p-4 sm:p-6 lg:p-8">

            @isset($header)
                <div class="mb-6">
                    {{ $header }}
                </div>
            @endisset

            <x-admin-flash />

            {{ $slot }}

        </main>

        <!-- Footer -->
        <footer class="border-t border-[#e6edf7] bg-white/60 px-4 py-4 text-center text-xs text-[#4a5568]/70 sm:px-6 lg:px-8">
            &copy; {{ date('Y') }} Ceedwork-Solutions. Todos os direitos reservados.
        </footer>

    </div>

</div>

<x-admin-confirm />

</body>

</html>
