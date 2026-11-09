@props([
    'label',
    'value',
    'description' => null,
    'icon' => 'bx-news',
    'tone' => 'blue',
])

@php
    $tones = [
        'blue' => [
            'background' => 'bg-[#e6edf7]',
            'text' => 'text-[#13397c]',
        ],
        'teal' => [
            'background' => 'bg-[#e7f6f3]',
            'text' => 'text-[#0d5c52]',
        ],
        'sky' => [
            'background' => 'bg-[#e8f4f9]',
            'text' => 'text-[#2f96bf]',
        ],
        'amber' => [
            'background' => 'bg-[#fdf3e7]',
            'text' => 'text-[#9a5b13]',
        ],
    ];

    $style = $tones[$tone] ?? $tones['blue'];
@endphp

<div class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm transition hover:border-[#c3ebfa] hover:shadow-md hover:shadow-[#031b3a]/5">

    <div class="flex items-start justify-between gap-4">

        <div class="min-w-0">
            <p class="truncate text-sm font-medium text-[#4a5568]">
                {{ $label }}
            </p>

            <p class="mt-3 text-3xl font-semibold tracking-tight text-[#031b3a]">
                {{ $value }}
            </p>
        </div>

        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $style['background'] }} {{ $style['text'] }}">
            <i class="bx {{ $icon }} text-2xl"></i>
        </span>

    </div>

    @if($description)
        <p class="mt-4 text-xs leading-5 text-[#4a5568]/80">
            {{ $description }}
        </p>
    @endif

</div>
