@props(['icon' => 'bx bx-info-circle', 'title' => 'Sem dados', 'description' => null])

<div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-[#cfe0f4] bg-white/70 p-10 text-center">
    <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#eef4fb] text-[#13397c]">
        <i class="{{ $icon }} text-3xl"></i>
    </span>

    <h2 class="mt-4 text-base font-semibold text-[#031b3a]">{{ $title }}</h2>

    @if($description)
        <p class="mt-1 max-w-md text-sm text-[#4a5568]">{{ $description }}</p>
    @endif

    @if(! $slot->isEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
