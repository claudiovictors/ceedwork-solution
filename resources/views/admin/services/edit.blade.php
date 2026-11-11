<x-app-layout>
    <x-slot name="title">Editar serviço</x-slot>
    <x-slot name="pageTitle">Editar serviço</x-slot>
    <x-slot name="pageDescription">Atualizar {{ $service->title }}</x-slot>

    <x-admin-page-header
        title="Editar serviço"
        :description="$service->title"
        icon="bx bx-edit-alt"
    >
        <a href="{{ route('admin.services.index') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
            <i class="bx bx-arrow-back text-lg"></i>
            Voltar
        </a>
    </x-admin-page-header>

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        @include('admin.services._form', ['service' => $service])

        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
            <button type="submit" form="delete-service-form"
                    class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                <i class="bx bx-trash text-lg"></i>
                Eliminar serviço
            </button>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.services.index') }}"
                   class="rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                    Cancelar
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
                    <i class="bx bx-save text-lg"></i>
                    Guardar alterações
                </button>
            </div>
        </div>
    </form>

    <form id="delete-service-form" method="POST" action="{{ route('admin.services.destroy', $service) }}"
          data-confirm="Eliminar este serviço e todos os seus itens?"
          data-confirm-title="Eliminar serviço"
          data-confirm-button="Eliminar">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>
