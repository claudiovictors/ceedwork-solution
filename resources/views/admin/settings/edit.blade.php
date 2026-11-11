<x-app-layout>
    <x-slot name="title">Configurações</x-slot>
    <x-slot name="pageTitle">Configurações</x-slot>
    <x-slot name="pageDescription">Identidade, contactos e aparência do website</x-slot>

    <x-admin-page-header
        title="Configurações"
        description="Gerir a identidade do site, contactos, redes sociais, aparência e assistente virtual."
        icon="bx bx-cog"
    />

    <nav class="mt-6 flex flex-wrap gap-2" aria-label="Grupos de configurações">
        @foreach($groups as $groupKey => $groupDefinition)
            @php $isActive = $groupKey === $group; @endphp

            <a href="{{ route('admin.settings.edit', ['group' => $groupKey]) }}"
               @if($isActive) aria-current="page" @endif
               class="inline-flex items-center gap-2 rounded-lg border px-3.5 py-2 text-sm font-semibold transition
               {{ $isActive
                    ? 'border-[#13397c] bg-[#13397c] text-white'
                    : 'border-[#e6edf7] bg-white text-[#4a5568] hover:bg-[#f8fafd] hover:text-[#031b3a]' }}">
                <i class="bx {{ $groupDefinition['icon'] ?? 'bx-cog' }} text-base"></i>
                {{ $groupDefinition['label'] }}
            </a>
        @endforeach
    </nav>

    <form method="POST" action="{{ route('admin.settings.update', $group) }}" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <div class="border-b border-[#e6edf7] pb-4">
                <h2 class="text-base font-semibold text-[#031b3a]">
                    {{ $groups[$group]['label'] }}
                </h2>

                @if(! empty($groups[$group]['description']))
                    <p class="mt-1 text-sm text-[#4a5568]">{{ $groups[$group]['description'] }}</p>
                @endif
            </div>

            <div class="mt-5">
                @include('admin.content._fields', [
                    'fields' => $fields,
                    'values' => $values,
                    'prefix' => '',
                ])
            </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('admin.settings.edit', ['group' => $group]) }}"
               class="rounded-lg border border-[#e6edf7] bg-white px-4 py-2.5 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f8fafd] hover:text-[#031b3a]">
                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#13397c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2f96bf] focus-visible:ring-offset-2">
                <i class="bx bx-save text-lg"></i>
                Guardar configurações
            </button>
        </div>
    </form>
</x-app-layout>
