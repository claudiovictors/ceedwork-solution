<x-app-layout>

    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="pageTitle">Visão geral</x-slot>
    <x-slot name="pageDescription">Acompanhe e gira artigos, serviços e projetos do website</x-slot>

    @include('dashboard.sections.overview', [
        'stats' => $stats ?? [],
    ])

    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">

        @include('dashboard.sections.recent-posts', [
            'recentPosts' => $recentPosts ?? [],
        ])

        <x-admin-quick-actions />

    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

        @include('dashboard.sections.recent-activity', [
            'activities' => $activities ?? [],
        ])

        @include('dashboard.sections.website-status')

    </div>

</x-app-layout>
