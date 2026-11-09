@props([
    'pageTitle' => 'Dashboard',
    'pageDescription' => null,
])

@php
    $user = auth()->user();
    $userName = $user?->name ?? 'Administrador';
    $userEmail = $user?->email;

    $initials = collect(preg_split('/\s+/', trim($userName)) ?: [])
        ->filter()
        ->map(fn (string $part): string => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');

    $initials = mb_strtoupper($initials !== '' ? $initials : 'C');
@endphp

<header class="sticky top-0 z-30 border-b border-[#e6edf7] bg-white/95 backdrop-blur">

    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:h-20 lg:px-8">

        <div class="flex min-w-0 items-center gap-3">

            <button
                type="button"
                @click="sidebarOpen = true"
                class="rounded-lg p-2 text-[#4a5568] transition hover:bg-[#f4f7fb] hover:text-[#031b3a] lg:hidden"
                aria-label="Abrir menu"
            >
                <i class="bx bx-menu text-2xl"></i>
            </button>

            <div class="min-w-0">
                <div class="flex items-center gap-1.5 text-[11px] font-medium text-[#4a5568]/70">
                    <span class="hidden sm:inline">Administração</span>
                    <i class="bx bx-chevron-right hidden text-sm sm:inline"></i>
                    <span class="truncate text-[#0d5c52]">{{ $pageTitle }}</span>
                </div>

                <h1 class="truncate text-lg font-semibold tracking-tight text-[#031b3a] lg:text-xl">
                    {{ $pageTitle }}
                </h1>

                @if($pageDescription)
                    <p class="hidden truncate text-xs text-[#4a5568] sm:block">
                        {{ $pageDescription }}
                    </p>
                @endif
            </div>

        </div>

        <div class="flex shrink-0 items-center gap-1.5 sm:gap-3">

            <!-- Public website -->
            <a
                href="{{ route('home') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="hidden items-center gap-2 rounded-lg border border-[#e6edf7] px-3 py-2 text-xs font-semibold text-[#4a5568] transition hover:border-[#c3ebfa] hover:bg-[#f8fafd] hover:text-[#031b3a] sm:inline-flex"
            >
                <i class="bx bx-globe text-base"></i>
                Ver website
            </a>

            <!-- Notifications -->
            <div
                x-data="{ notificationsOpen: false }"
                @click.outside="notificationsOpen = false"
                class="relative"
            >
                <button
                    type="button"
                    @click="notificationsOpen = ! notificationsOpen"
                    :aria-expanded="notificationsOpen"
                    class="relative rounded-lg p-2 text-[#4a5568] transition hover:bg-[#f4f7fb] hover:text-[#031b3a]"
                    aria-label="Notificações"
                >
                    <i class="bx bx-bell text-xl"></i>
                </button>

                <div
                    x-show="notificationsOpen"
                    x-cloak
                    x-transition
                    class="absolute right-0 z-50 mt-3 w-72 overflow-hidden rounded-xl border border-[#e6edf7] bg-white shadow-xl shadow-[#031b3a]/10"
                >
                    <div class="border-b border-[#eef2f8] px-4 py-3">
                        <p class="text-sm font-semibold text-[#031b3a]">Notificações</p>
                        <p class="mt-0.5 text-xs text-[#4a5568]">Atividade recente da administração</p>
                    </div>

                    <div class="flex flex-col items-center px-5 py-8 text-center">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#f4f7fb] text-[#4a5568]">
                            <i class="bx bx-bell-off text-xl"></i>
                        </span>
                        <p class="mt-3 text-sm font-medium text-[#031b3a]">Sem notificações</p>
                        <p class="mt-1 text-xs leading-5 text-[#4a5568]">
                            As notificações do sistema aparecerão aqui.
                        </p>
                    </div>
                </div>
            </div>

            <!-- User menu -->
            <div class="relative" @click.outside="userMenu = false">

                <button
                    type="button"
                    @click="userMenu = ! userMenu"
                    :aria-expanded="userMenu"
                    class="flex items-center gap-2 rounded-lg p-1.5 transition hover:bg-[#f4f7fb] sm:gap-3"
                    aria-label="Menu do utilizador"
                >
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#e7f6f3] text-xs font-bold text-[#0d5c52] ring-1 ring-[#1baa99]/20">
                        {{ $initials }}
                    </span>

                    <span class="hidden min-w-0 text-left sm:block">
                        <span class="block max-w-[160px] truncate text-xs font-semibold text-[#031b3a]">
                            {{ $userName }}
                        </span>
                        <span class="block text-[11px] text-[#4a5568]">
                            Administrador
                        </span>
                    </span>

                    <i class="bx bx-chevron-down hidden text-[#4a5568] sm:inline"></i>
                </button>

                <div
                    x-show="userMenu"
                    x-cloak
                    x-transition
                    class="absolute right-0 z-50 mt-3 w-60 overflow-hidden rounded-xl border border-[#e6edf7] bg-white p-2 shadow-xl shadow-[#031b3a]/10"
                >
                    <div class="border-b border-[#eef2f8] px-3 py-3">
                        <p class="truncate text-sm font-semibold text-[#031b3a]">{{ $userName }}</p>
                        @if($userEmail)
                            <p class="mt-1 truncate text-xs text-[#4a5568]">{{ $userEmail }}</p>
                        @endif
                    </div>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="mt-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]"
                    >
                        <i class="bx bx-user text-lg"></i>
                        Meu perfil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-[#B42318] transition hover:bg-[#FDECEA] hover:text-[#7A1A12]"
                        >
                            <i class="bx bx-log-out text-lg"></i>
                            Terminar sessão
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>

</header>
