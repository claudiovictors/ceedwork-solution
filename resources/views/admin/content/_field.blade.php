@props(['name', 'field', 'value' => null])

@php
    $type = $field['type'] ?? 'text';
    $label = $field['label'] ?? $name;
    $help = $field['help'] ?? null;
    $required = in_array('required', $field['rules'] ?? [], true);
    $inputClasses = 'mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]';
@endphp

@if($type === 'image')
    <x-admin-image-upload
        :name="$name"
        :label="$label"
        :current="$value ? \App\Support\ImageUrl::for($value) : null"
        :remove-name="'remove_'.$name"
        :accept="! empty($field['allow_ico']) ? 'image/x-icon,image/vnd.microsoft.icon,image/png,image/jpeg,image/webp' : 'image/jpeg,image/png,image/webp'"
        :help="$help"
    />
@else
    <div>
        <label for="{{ $name }}" class="block text-sm font-medium text-[#031b3a]">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>

        @if($type === 'rich')
            <div class="mt-2">
                <x-admin-editor :name="$name" :value="(string) $value" />
            </div>
        @elseif($type === 'textarea')
            <textarea
                id="{{ $name }}"
                name="{{ $name }}"
                rows="4"
                class="{{ $inputClasses }}"
            >{{ old($name, $value) }}</textarea>
        @elseif($type === 'select')
            <select id="{{ $name }}" name="{{ $name }}" class="{{ $inputClasses }}">
                @foreach(($field['options'] ?? []) as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected((string) old($name, $value) === (string) $optionValue)>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
        @elseif($type === 'toggle')
            <div class="mt-2">
                <input type="hidden" name="{{ $name }}" value="0">
                <label class="inline-flex items-center gap-2 text-sm text-[#4a5568]">
                    <input
                        type="checkbox"
                        name="{{ $name }}"
                        value="1"
                        class="rounded border-[#cfe0f4] text-[#13397c] focus:ring-[#2f96bf]"
                        @checked((bool) old($name, $value))
                    >
                    Ativo
                </label>
            </div>
        @elseif($type === 'color')
            <div x-data="{ color: @js(old($name, $value ?: '#000000')) }" class="mt-2 flex items-center gap-3">
                <input
                    type="color"
                    x-model="color"
                    class="h-10 w-14 cursor-pointer rounded-lg border border-[#dbe5f1] bg-white p-1"
                    aria-label="Selecionar {{ $label }}"
                >

                <input
                    id="{{ $name }}"
                    name="{{ $name }}"
                    type="text"
                    x-model="color"
                    maxlength="7"
                    class="{{ $inputClasses }} mt-0 max-w-[140px] font-mono uppercase"
                >
            </div>
        @elseif($type === 'repeater')
            @include('admin.content._repeater', [
                'name' => $name,
                'field' => $field,
                'value' => $value,
            ])
        @else
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                type="text"
                value="{{ old($name, $value) }}"
                class="{{ $inputClasses }}"
            >
        @endif

        @if($help && $type !== 'image')
            <p class="mt-1 text-xs text-[#4a5568]/80">{{ $help }}</p>
        @endif

        @if($type !== 'rich')
            @error($name)
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        @endif
    </div>
@endif
