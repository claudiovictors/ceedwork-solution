@props(['tone' => 'slate', 'label' => null])

@php
    $classes = match ($tone) {
        'teal' => 'bg-[#e8f8f4] text-[#0f6b5f] ring-[#bde9e1]',
        'amber' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'red' => 'bg-red-50 text-red-700 ring-red-200',
        'blue' => 'bg-[#eef4fb] text-[#13397c] ring-[#cfe0f4]',
        default => 'bg-slate-50 text-slate-600 ring-slate-200',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {$classes}"]) }}>
    {{ $label ?? $slot }}
</span>
