@props(['title', 'description' => null, 'icon' => null])

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div class="min-w-0">
        <div class="flex items-center gap-2">
            @if($icon)
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef4fb] text-[#13397c]">
                    <i class="{{ $icon }} text-xl"></i>
                </span>
            @endif

            <h1 class="truncate text-xl font-semibold tracking-tight text-[#031b3a] sm:text-2xl">
                {{ $title }}
            </h1>
        </div>

        @if($description)
            <p class="mt-1 text-sm text-[#4a5568]">{{ $description }}</p>
        @endif
    </div>

    @if(! $slot->isEmpty())
        <div class="flex flex-wrap items-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
