<x-app-layout>
    <x-slot name="title">Novo serviço</x-slot>
    <x-slot name="pageTitle">Novo serviço</x-slot>
    <x-slot name="pageDescription">Adicionar um serviço ao website</x-slot>

    <x-admin-page-header
        title="Novo serviço"
        description="Preencha a informação, os itens e a imagem do serviço."
        icon="bx bx-plus-circle"
    >
        <a href="{{ route('admin.services.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
            <i class="bx bx-arrow-back text-lg"></i>
            Voltar
        </a>
    </x-admin-page-header>

    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="mt-6">
        @csrf

        @include('admin.services._form', ['service' => $service])

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('admin.services.index') }}"
               class="rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
                <i class="bx bx-save text-lg"></i>
                Guardar serviço
            </button>
        </div>
    </form>
</x-app-layout>
