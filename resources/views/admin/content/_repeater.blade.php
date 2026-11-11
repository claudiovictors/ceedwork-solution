@props(['name', 'field', 'value' => []])

@php
    $items = old($name, $value);
    $items = is_array($items) ? array_values($items) : [];

    $subFields = $field['fields'] ?? [];
    $itemLabel = $field['item_label'] ?? 'Item';

    $blankItem = [];

    foreach ($subFields as $subKey => $subField) {
        $blankItem[$subKey] = $subField['default'] ?? '';
    }

    $repeaterErrors = collect($errors->getBag('default')->keys())
        ->filter(fn (string $key): bool => str_starts_with($key, $name.'.'))
        ->map(fn (string $key): string => $errors->first($key));
@endphp

<div x-data='{ items: @js($items) }' class="space-y-3">
    <template x-for="(item, index) in items" :key="index">
        <div class="rounded-xl border border-[#e6edf7] bg-[#f8fafd] p-4">
            <div class="flex items-center justify-between gap-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-[#4a5568]">
                    {{ $itemLabel }} <span x-text="index + 1"></span>
                </p>

                <button
                    type="button"
                    @click="items.splice(index, 1)"
                    class="inline-flex items-center gap-1 rounded-lg border border-red-200 px-2 py-1 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                >
                    <i class="bx bx-trash text-sm"></i>
                    Remover
                </button>
            </div>

            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                @foreach($subFields as $subKey => $subField)
                    @php
                        $subType = $subField['type'] ?? 'text';
                        $subClasses = 'mt-1 block w-full rounded-lg border-[#dbe5f1] bg-white text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]';
                    @endphp

                    <div class="{{ in_array($subType, ['textarea', 'rich'], true) ? 'sm:col-span-2' : '' }}">
                        <label class="block text-xs font-medium text-[#031b3a]">
                            {{ $subField['label'] ?? $subKey }}
                        </label>

                        @if($subType === 'select')
                            <select :name="`{{ $name }}[${index}][{{ $subKey }}]`" x-model="item.{{ $subKey }}" class="{{ $subClasses }}">
                                @foreach(($subField['options'] ?? []) as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif($subType === 'textarea' || $subType === 'rich')
                            <textarea :name="`{{ $name }}[${index}][{{ $subKey }}]`" x-model="item.{{ $subKey }}" rows="3" class="{{ $subClasses }}"></textarea>
                        @else
                            <input type="text" :name="`{{ $name }}[${index}][{{ $subKey }}]`" x-model="item.{{ $subKey }}" class="{{ $subClasses }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </template>

    <template x-if="items.length === 0">
        <p class="rounded-lg border border-dashed border-[#cfe0f4] bg-white px-4 py-3 text-sm text-[#8a97a8]">
            Ainda não existem itens.
        </p>
    </template>

    @if($repeaterErrors->isNotEmpty())
        <ul class="space-y-1 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
            @foreach($repeaterErrors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <button
        type="button"
        @click='items.push(@js($blankItem))'
        class="inline-flex items-center gap-2 rounded-lg border border-[#cfe0f4] bg-white px-3 py-2 text-sm font-semibold text-[#13397c] transition hover:bg-[#eef4fb]"
    >
        <i class="bx bx-plus text-base"></i>
        Adicionar {{ strtolower($itemLabel) }}
    </button>
</div>
