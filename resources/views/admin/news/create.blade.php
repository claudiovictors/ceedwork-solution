<x-app-layout>
    <x-slot name="title">Nova notícia</x-slot>
    <x-slot name="pageTitle">Nova notícia</x-slot>
    <x-slot name="pageDescription">Criar um novo artigo para o website</x-slot>

    <x-admin-page-header
        title="Nova notícia"
        description="Preencha o conteúdo, escolha a categoria e defina o estado de publicação."
        icon="bx bx-news"
    >
        <a href="{{ route('admin.news.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
            <i class="bx bx-arrow-back text-lg"></i>
            Voltar
        </a>
    </x-admin-page-header>

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        @include('admin.news._form', [
            'post' => $post,
            'categories' => $categories,
            'statuses' => $statuses,
        ])

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
                <i class="bx bx-save text-lg"></i>
                Guardar notícia
            </button>

            <a href="{{ route('admin.news.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-5 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                Cancelar
            </a>
        </div>
    </form>
</x-app-layout>
