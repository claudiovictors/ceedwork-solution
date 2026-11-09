<x-app-layout>
    <x-slot name="title">Novo projeto</x-slot>
    <x-slot name="pageTitle">Novo projeto</x-slot>
    <x-slot name="pageDescription">Adicionar um projeto ao portfólio</x-slot>

    <x-admin-page-header
        title="Novo projeto"
        description="Preencha a informação, as tecnologias e as imagens do projeto."
        icon="bx bx-plus-circle"
    >
        <a href="{{ route('admin.portfolio.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
            <i class="bx bx-arrow-back text-lg"></i>
            Voltar
        </a>
    </x-admin-page-header>

    <form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data" class="mt-6">
        @csrf

        @include('admin.portfolio._form', ['project' => $project])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('admin.portfolio.index') }}"
               class="rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
                <i class="bx bx-save text-lg"></i>
                Guardar projeto
            </button>
        </div>
    </form>
</x-app-layout>
