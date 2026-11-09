@php
    $activityItems = $activities ?? [];
    $activityItems = is_countable($activityItems) ? collect($activityItems)->take(6) : collect();
    $hasActivity = $activityItems->isNotEmpty();
@endphp

<section class="rounded-xl border border-[#e6edf7] bg-white shadow-sm" aria-labelledby="recent-activity-title">

    <div class="border-b border-[#eef2f8] px-5 py-4">
        <h3 id="recent-activity-title" class="font-semibold text-[#031b3a]">
            Atividade recente
        </h3>

        <p class="mt-1 text-xs text-[#4a5568]">
            Últimas ações realizadas na administração.
        </p>
    </div>

    @if($hasActivity)

        <div class="divide-y divide-[#eef2f8]">
            @foreach($activityItems as $activity)
                @php
                    $description = data_get($activity, 'description') ?: data_get($activity, 'title');
                    $author = data_get($activity, 'user.name') ?: data_get($activity, 'author');
                    $createdAt = data_get($activity, 'created_at');

                    try {
                        $time = $createdAt
                            ? \Illuminate\Support\Carbon::parse($createdAt)->diffForHumans()
                            : null;
                    } catch (\Throwable $exception) {
                        $time = null;
                    }
                @endphp

                <div class="flex items-start gap-3 px-5 py-4">

                    <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#e8f4f9] text-[#2f96bf]">
                        <i class="bx bx-history text-lg"></i>
                    </span>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-[#031b3a]">
                            {{ $description ?: 'Atividade registada' }}
                        </p>

                        <p class="mt-1 text-xs text-[#4a5568]">
                            {{ collect([$author, $time])->filter()->implode(' · ') ?: 'Sem detalhes adicionais' }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>

    @else

        <div class="flex flex-col items-center justify-center px-6 py-12 text-center">

            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-[#f4f7fb] text-[#4a5568]">
                <i class="bx bx-history text-2xl"></i>
            </span>

            <h4 class="mt-4 text-sm font-semibold text-[#031b3a]">
                Sem atividade recente
            </h4>

            <p class="mt-1 max-w-xs text-xs leading-5 text-[#4a5568]">
                As ações de gestão de conteúdo aparecerão aqui quando começarem a ser registadas.
            </p>

        </div>

    @endif

</section>
