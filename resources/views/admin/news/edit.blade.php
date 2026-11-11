<x-app-layout>
    <x-slot name="title">Editar notícia</x-slot>
    <x-slot name="pageTitle">Editar notícia</x-slot>
    <x-slot name="pageDescription">Atualizar o conteúdo e a publicação da notícia</x-slot>

    <x-admin-page-header
        title="Editar notícia"
        description="Atualize o conteúdo, a imagem de capa ou o estado de publicação."
        icon="bx bx-news"
    >
        <a href="{{ route('admin.news.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
            <i class="bx bx-arrow-back text-lg"></i>
            Voltar
        </a>
    </x-admin-page-header>

    <form method="POST" action="{{ route('admin.news.update', $post) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        @include('admin.news._form', [
            'post' => $post,
            'categories' => $categories,
            'statuses' => $statuses,
        ])

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
                <i class="bx bx-save text-lg"></i>
                Guardar alterações
            </button>

            <a href="{{ route('admin.news.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-5 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                Cancelar
            </a>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.news.destroy', $post) }}"
          data-confirm="Eliminar esta notícia? Esta ação não pode ser revertida no painel."
          data-confirm-title="Eliminar notícia"
          data-confirm-button="Eliminar"
          class="mt-6 border-t border-[#e6edf7] pt-6">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">
            <i class="bx bx-trash text-lg"></i>
            Eliminar notícia
        </button>
    </form>
</x-app-layout>
