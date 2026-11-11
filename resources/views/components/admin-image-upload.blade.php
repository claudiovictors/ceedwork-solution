@props([
    'name',
    'label',
    'current' => null,
    'removeName' => null,
    'urlName' => null,
    'urlValue' => null,
    'accept' => 'image/jpeg,image/png,image/webp',
    'help' => null,
])

@php
    $removeName = $removeName ?? 'remove_'.$name;
@endphp

<div
    x-data="{
        preview: @js($current),
        remove: @js((bool) old($removeName, false)),
        choose(event) {
            const file = event.target.files?.[0];

            if (! file) {
                return;
            }

            this.remove = false;
            this.preview = URL.createObjectURL(file);
        },
        toggleRemove() {
            this.preview = this.remove ? '' : @js($current);
        },
    }"
>
    <label for="{{ $name }}" class="block text-sm font-medium text-[#031b3a]">
        {{ $label }}
    </label>

    <div class="mt-2 flex flex-col gap-3 sm:flex-row sm:items-start">
        <div class="shrink-0">
            <template x-if="preview">
                <img :src="preview" alt="{{ $label }}" class="h-20 w-32 rounded-lg object-cover ring-1 ring-[#e6edf7]">
            </template>

            <template x-if="! preview">
                <div class="flex h-20 w-32 items-center justify-center rounded-lg border border-dashed border-[#cfe0f4] bg-[#f8fafd] text-[#8a97a8]">
                    <i class="bx bx-image text-2xl"></i>
                </div>
            </template>
        </div>

        <div class="min-w-0 flex-1">
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                type="file"
                accept="{{ $accept }}"
                class="block w-full cursor-pointer rounded-lg border border-[#dbe5f1] bg-white text-sm text-[#4a5568] file:mr-3 file:border-0 file:bg-[#eef4fb] file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#13397c] hover:file:bg-[#e0ecf9]"
                @change="choose($event)"
            >

            @if($urlName)
                <div class="mt-3">
                    <label for="{{ $urlName }}" class="block text-xs font-medium text-[#4a5568]">
                        Ou indique o URL da imagem
                    </label>

                    <input
                        id="{{ $urlName }}"
                        name="{{ $urlName }}"
                        type="text"
                        value="{{ old($urlName, $urlValue) }}"
                        placeholder="https://... ou assets/images/..."
                        class="mt-1 block w-full rounded-lg border border-[#dbe5f1] bg-white px-3 py-2 text-sm text-[#4a5568] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]"
                    >

                    @error($urlName)
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if($current)
                <label class="mt-2 inline-flex items-center gap-2 text-xs font-medium text-[#4a5568]">
                    <input
                        type="checkbox"
                        name="{{ $removeName }}"
                        value="1"
                        class="rounded border-[#cfe0f4] text-[#13397c] focus:ring-[#2f96bf]"
                        x-model="remove"
                        @change="toggleRemove()"
                    >
                    Remover imagem atual
                </label>
            @endif

            @if($help)
                <p class="mt-1 text-xs text-[#4a5568]/80">{{ $help }}</p>
            @endif

            @error($name)
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
