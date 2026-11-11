@php
    $posts = $recentPosts ?? [];
    $posts = is_countable($posts) ? collect($posts)->take(5) : collect();
    $hasPosts = $posts->isNotEmpty();
@endphp

<section class="overflow-hidden rounded-xl border border-[#e6edf7] bg-white shadow-sm xl:col-span-2" aria-labelledby="recent-posts-title">

    <div class="flex items-center justify-between gap-4 border-b border-[#eef2f8] px-5 py-4">

        <div class="min-w-0">
            <h3 id="recent-posts-title" class="font-semibold text-[#031b3a]">
                Artigos recentes
            </h3>

            <p class="mt-1 text-xs text-[#4a5568]">
                As últimas publicações do blog.
            </p>
        </div>

        <a
            href="{{ route('admin.news.index') }}"
            class="inline-flex shrink-0 items-center gap-1 text-xs font-semibold text-[#13397c] transition hover:text-[#031b3a]"
        >
            Ver todos <i class="bx bx-right-arrow-alt text-base"></i>
        </a>

    </div>

    @if($hasPosts)

        <div class="divide-y divide-[#eef2f8]">

            @foreach($posts as $post)
                @php
                    $title = data_get($post, 'title') ?: 'Sem título';
                    $status = data_get($post, 'status');
                    $createdAt = data_get($post, 'created_at');

                    try {
                        $date = $createdAt
                            ? \Illuminate\Support\Carbon::parse($createdAt)->format('d/m/Y')
                            : null;
                    } catch (\Throwable $exception) {
                        $date = null;
                    }

                    $statusLabel = match ($status) {
                        'published', 'publicado' => 'Publicado',
                        'draft', 'rascunho' => 'Rascunho',
                        default => null,
                    };

                    $statusClasses = match ($status) {
                        'published', 'publicado' => 'bg-[#e7f6f3] text-[#0d5c52]',
                        'draft', 'rascunho' => 'bg-[#fdf3e7] text-[#9a5b13]',
                        default => 'bg-[#f4f7fb] text-[#4a5568]',
                    };
                @endphp

                <div class="flex items-center gap-4 px-5 py-4">

                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[#e6edf7] text-[#13397c]">
                        <i class="bx bx-file-blank text-xl"></i>
                    </span>

                    <div class="min-w-0 flex-1">
                        <h4 class="truncate text-sm font-semibold text-[#031b3a]">
                            {{ $title }}
                        </h4>

                        @if($date)
                            <p class="mt-1 text-xs text-[#4a5568]">
                                {{ $date }}
                            </p>
                        @endif
                    </div>

                    @if($statusLabel)
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $statusClasses }}">
                            {{ $statusLabel }}
                        </span>
                    @endif

                </div>
            @endforeach

        </div>

    @else

        <div class="flex flex-col items-center justify-center px-6 py-12 text-center">

            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-[#f4f7fb] text-[#4a5568]">
                <i class="bx bx-news text-2xl"></i>
            </span>

            <h4 class="mt-4 text-sm font-semibold text-[#031b3a]">
                Ainda não existem artigos
            </h4>

            <p class="mt-1 max-w-xs text-xs leading-5 text-[#4a5568]">
                Crie um artigo para o ver listado aqui.
            </p>

            <a
                href="{{ route('admin.news.create') }}"
                class="mt-4 inline-flex items-center gap-2 rounded-lg border border-[#e6edf7] px-3 py-2 text-xs font-semibold text-[#13397c] transition hover:border-[#c3ebfa] hover:bg-[#f8fafd]"
            >
                <i class="bx bx-plus text-base"></i>
                Criar artigo
            </a>

        </div>

    @endif

</section>
