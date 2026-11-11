<x-app-layout>
    <x-slot name="title">Editar página</x-slot>
    <x-slot name="pageTitle">{{ $definition['label'] }}</x-slot>
    <x-slot name="pageDescription">Editar o conteúdo da página {{ $definition['label'] }}</x-slot>

    <x-admin-page-header
        title="Editar {{ $definition['label'] }}"
        description="Os valores originais são repostos automaticamente quando uma secção é reposta."
        icon="bx bx-edit-alt"
    >
        <a href="{{ route('admin.pages.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
            <i class="bx bx-arrow-back text-lg"></i>
            Voltar
        </a>
    </x-admin-page-header>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data" class="mt-6 space-y-5">
        @csrf
        @method('PUT')

        @foreach($sections as $sectionKey => $section)
            <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-3 border-b border-[#e6edf7] pb-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-[#031b3a]">
                            {{ $section['label'] ?? $sectionKey }}
                        </h2>

                        @if(! empty($section['description']))
                            <p class="mt-1 text-sm text-[#4a5568]">{{ $section['description'] }}</p>
                        @endif
                    </div>

                    <button type="submit"
                            form="restore-{{ $page }}-{{ $sectionKey }}"
                            class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-[#e6edf7] px-3 py-2 text-xs font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                        <i class="bx bx-reset text-base"></i>
                        Repor original
                    </button>
                </div>

                <div class="mt-5">
                    @include('admin.content._fields', [
                        'fields' => $section['fields'] ?? [],
                        'values' => $values[$sectionKey] ?? [],
                        'prefix' => $sectionKey,
                    ])
                </div>
            </section>
        @endforeach

        <div class="flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('admin.pages.index') }}"
               class="rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
                <i class="bx bx-save text-lg"></i>
                Guardar conteúdo
            </button>
        </div>
    </form>

    @foreach($sections as $sectionKey => $section)
        <form id="restore-{{ $page }}-{{ $sectionKey }}"
              method="POST"
              action="{{ route('admin.pages.restore', [$page, $sectionKey]) }}"
              data-confirm="Repor esta secção para o conteúdo original? As alterações guardadas serão eliminadas."
              data-confirm-title="Repor secção"
              data-confirm-button="Repor">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</x-app-layout>
