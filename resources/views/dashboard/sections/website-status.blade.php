@php
    $environment = app()->environment();

    $environmentLabel = match ($environment) {
        'production' => 'Produção',
        'local' => 'Local',
        'staging' => 'Staging',
        default => ucfirst($environment),
    };

    $environmentClasses = match ($environment) {
        'production' => 'bg-[#e7f6f3] text-[#0d5c52]',
        'local' => 'bg-[#e8f4f9] text-[#2f96bf]',
        default => 'bg-[#f4f7fb] text-[#4a5568]',
    };

    $administrator = auth()->user()?->name ?? 'Administrador';
@endphp

<section class="rounded-xl border border-[#e6edf7] bg-white shadow-sm" aria-labelledby="website-status-title">

    <div class="border-b border-[#eef2f8] px-5 py-4">
        <h3 id="website-status-title" class="font-semibold text-[#031b3a]">
            Estado do website
        </h3>

        <p class="mt-1 text-xs text-[#4a5568]">
            Informações gerais da plataforma.
        </p>
    </div>

    <div class="p-5">

        <dl class="space-y-4">

            <div class="flex items-center justify-between gap-4">
                <dt class="text-sm text-[#4a5568]">Nome do website</dt>
                <dd class="truncate text-sm font-semibold text-[#031b3a]">{{ config('app.name') }}</dd>
            </div>

            <div class="flex items-center justify-between gap-4">
                <dt class="text-sm text-[#4a5568]">Ambiente</dt>
                <dd>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $environmentClasses }}">
                        {{ $environmentLabel }}
                    </span>
                </dd>
            </div>

            <div class="flex items-center justify-between gap-4">
                <dt class="text-sm text-[#4a5568]">Administrador</dt>
                <dd class="truncate text-sm font-medium text-[#031b3a]">{{ $administrator }}</dd>
            </div>

            <div class="flex items-center justify-between gap-4">
                <dt class="text-sm text-[#4a5568]">Laravel</dt>
                <dd class="text-sm font-medium text-[#031b3a]">v{{ app()->version() }}</dd>
            </div>

            <div class="flex items-center justify-between gap-4">
                <dt class="text-sm text-[#4a5568]">PHP</dt>
                <dd class="text-sm font-medium text-[#031b3a]">v{{ PHP_VERSION }}</dd>
            </div>

        </dl>

        <div class="mt-5 flex flex-col gap-2 border-t border-[#eef2f8] pt-4">

            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center justify-between rounded-lg text-sm font-semibold text-[#13397c] transition hover:text-[#031b3a]"
            >
                Gerir conta e perfil
                <i class="bx bx-right-arrow-alt text-lg"></i>
            </a>

            <a
                href="{{ route('home') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex items-center justify-between rounded-lg text-sm font-semibold text-[#4a5568] transition hover:text-[#031b3a]"
            >
                Abrir website público
                <i class="bx bx-link-external text-lg"></i>
            </a>

        </div>

    </div>

</section>
