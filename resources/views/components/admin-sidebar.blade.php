@php
    $logo = $data['core']['logo_white'] ?? $data['core']['logo'] ?? null;
    $logoIcon = $data['core']['logo_icon'] ?? $logo;

    $navigation = [
        'Geral' => [
            [
                'label' => 'Dashboard',
                'icon' => 'bx-grid-alt',
                'route' => 'dashboard',
                'active' => 'dashboard',
            ],
        ],
        'Conteúdos' => [
            [
                'label' => 'Artigos / Blog',
                'icon' => 'bx-news',
                'route' => 'admin.news.index',
                'active' => ['admin.news.index', 'admin.news.edit'],
            ],
            [
                'label' => 'Novo artigo',
                'icon' => 'bx-plus-circle',
                'route' => 'admin.news.create',
                'active' => 'admin.news.create',
            ],
            [
                'label' => 'Serviços',
                'icon' => 'bx-briefcase',
                'route' => 'admin.services.index',
                'active' => ['admin.services.index', 'admin.services.edit'],
            ],
            [
                'label' => 'Novo serviço',
                'icon' => 'bx-plus-circle',
                'route' => 'admin.services.create',
                'active' => 'admin.services.create',
            ],
            [
                'label' => 'Portfólio',
                'icon' => 'bx-folder-open',
                'route' => 'admin.portfolio.index',
                'active' => ['admin.portfolio.index', 'admin.portfolio.edit'],
            ],
            [
                'label' => 'Novo projeto',
                'icon' => 'bx-plus-circle',
                'route' => 'admin.portfolio.create',
                'active' => 'admin.portfolio.create',
            ],
        ],
        'Website' => [
            [
                'label' => 'Configurações',
                'icon' => 'bx-cog',
                'route' => 'admin.settings.edit',
                'active' => 'admin.settings.*',
            ],
            [
                'label' => 'Páginas',
                'icon' => 'bx-file',
                'route' => 'admin.pages.index',
                'active' => ['admin.pages.index', 'admin.pages.edit'],
            ],
        ],
        'Sistema' => [
            [
                'label' => 'Meu perfil',
                'icon' => 'bx-user-circle',
                'route' => 'profile.edit',
                'active' => 'profile.*',
            ],
        ],
    ];
@endphp

<aside
    :class="{
        'translate-x-0': sidebarOpen,
        '-translate-x-full': !sidebarOpen,
        'lg:w-[76px]': sidebarCollapsed,
        'lg:w-[260px]': !sidebarCollapsed
    }"
    class="fixed inset-y-0 left-0 z-50 flex w-[260px] -translate-x-full flex-col bg-[#031b3a] text-white shadow-2xl shadow-[#010414]/20 transition-all duration-300 lg:translate-x-0"
>

    <!-- Brand -->
    <div
        :class="sidebarCollapsed ? 'lg:justify-center lg:px-0' : ''"
        class="flex h-16 shrink-0 items-center justify-between gap-2 border-b border-white/10 px-4 lg:h-20 lg:px-5"
    >

        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3" title="Dashboard">
            @if($logo)
                <img
                    x-show="!sidebarCollapsed"
                    src="{{ asset($logo) }}"
                    alt="{{ config('app.name') }}"
                    class="h-9 w-auto max-w-[150px] object-contain object-left"
                >

                @if($logoIcon)
                    <img
                        x-show="sidebarCollapsed"
                        x-cloak
                        src="{{ asset($logoIcon) }}"
                        alt="{{ config('app.name') }}"
                        class="h-9 w-9 object-contain"
                    >
                @endif
            @else
                <span class="text-lg font-semibold tracking-wide">
                    Ceedwork
                </span>
            @endif
        </a>

        <button
            type="button"
            @click="sidebarOpen = false"
            class="rounded-lg p-1.5 text-white/50 transition hover:bg-white/10 hover:text-white lg:hidden"
            aria-label="Fechar menu"
        >
            <i class="bx bx-x text-2xl"></i>
        </button>

    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-5" aria-label="Navegação administrativa">

        @foreach($navigation as $group => $items)
            <div>
                <p
                    x-show="!sidebarCollapsed"
                    class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[1.6px] text-white/35"
                >
                    {{ $group }}
                </p>

                <div class="space-y-1">
                    @foreach($items as $item)
                        @php
                            $hasRoute = ! empty($item['route']);
                            $isActive = $hasRoute && isset($item['active']) && request()->routeIs(...(array) $item['active']);
                        @endphp

                        <a
                            href="{{ $hasRoute ? route($item['route']) : '#' }}"
                            title="{{ $hasRoute ? $item['label'] : $item['label'] . ' — disponível em breve' }}"
                            @if(! $hasRoute) aria-disabled="true" @click.prevent @endif
                            @if($isActive) aria-current="page" @endif
                            :class="sidebarCollapsed ? 'lg:justify-center lg:px-0' : ''"
                            class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                            {{ $isActive
                                ? 'bg-[#13397c] text-white shadow-sm shadow-[#010414]/20'
                                : ($hasRoute
                                    ? 'text-white/70 hover:bg-white/10 hover:text-white'
                                    : 'cursor-not-allowed text-white/40 hover:bg-white/5 hover:text-white/55') }}"
                        >
                            <i class="bx {{ $item['icon'] }} shrink-0 text-xl"></i>

                            <span x-show="!sidebarCollapsed" class="truncate">
                                {{ $item['label'] }}
                            </span>

                            @if(! $hasRoute)
                                <span
                                    x-show="!sidebarCollapsed"
                                    class="ml-auto rounded-full bg-white/5 px-1.5 py-0.5 text-[9px] font-semibold uppercase tracking-wide text-white/35"
                                >
                                    Breve
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

    </nav>

    <!-- Footer -->
    <div class="mt-auto border-t border-white/10 p-3">

        <a
            href="{{ route('home') }}"
            target="_blank"
            rel="noopener noreferrer"
            title="Visitar website"
            :class="sidebarCollapsed ? 'lg:justify-center lg:px-0' : ''"
            class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-white/70 transition hover:bg-white/10 hover:text-white"
        >
            <i class="bx bx-globe shrink-0 text-xl"></i>
            <span x-show="!sidebarCollapsed">Visitar website</span>
            <i x-show="!sidebarCollapsed" class="bx bx-link-external ml-auto text-base"></i>
        </a>

        <button
            type="button"
            @click="sidebarCollapsed = ! sidebarCollapsed"
            title="Recolher ou expandir menu"
            :class="sidebarCollapsed ? 'lg:justify-center lg:px-0' : ''"
            class="mt-1 hidden w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-white/45 transition hover:bg-white/10 hover:text-white lg:flex"
        >
            <i class="bx shrink-0 text-xl" :class="sidebarCollapsed ? 'bx-chevrons-right' : 'bx-chevrons-left'"></i>
            <span x-show="!sidebarCollapsed">Recolher menu</span>
        </button>

    </div>

</aside>
