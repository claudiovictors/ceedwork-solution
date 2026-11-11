<x-app-layout>
    <x-slot name="title">Páginas</x-slot>
    <x-slot name="pageTitle">Páginas</x-slot>
    <x-slot name="pageDescription">Conteúdo editável das páginas do website</x-slot>

    <x-admin-page-header
        title="Páginas"
        description="Edite os textos, imagens e listas apresentados em cada página pública."
        icon="bx bx-file"
    />

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($pages as $pageKey => $pageDefinition)
            @php
                $sectionCount = count($pageDefinition['sections'] ?? []);
                $customCount = $customized[$pageKey] ?? 0;
            @endphp

            <a href="{{ route('admin.pages.edit', $pageKey) }}"
               class="group flex flex-col rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm transition hover:border-[#cfe0f4] hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-[#eef4fb] text-[#13397c]">
                        <i class="bx {{ $pageDefinition['icon'] ?? 'bx-file' }} text-2xl"></i>
                    </span>

                    <x-admin-status-badge
                        :tone="$customCount > 0 ? 'teal' : 'slate'"
                        :label="$customCount > 0 ? 'Personalizada' : 'Original'"
                    />
                </div>

                <h2 class="mt-4 text-base font-semibold text-[#031b3a] group-hover:text-[#13397c]">
                    {{ $pageDefinition['label'] }}
                </h2>

                <p class="mt-1 text-sm text-[#4a5568]">
                    {{ $sectionCount }} {{ $sectionCount === 1 ? 'secção' : 'secções' }}
                    @if($customCount > 0)
                        &middot; {{ $customCount }} personalizada(s)
                    @endif
                </p>

                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-[#13397c]">
                    Editar conteúdo
                    <i class="bx bx-right-arrow-alt text-lg transition group-hover:translate-x-0.5"></i>
                </span>
            </a>
        @endforeach
    </div>
</x-app-layout>
