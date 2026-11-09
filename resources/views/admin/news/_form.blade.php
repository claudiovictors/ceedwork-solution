@php
    $selectedStatus = old('status', $post->status instanceof \App\Enums\PostStatus ? $post->status->value : 'draft');
    $coverUrl = old('remove_cover') ? null : ($post->cover_image ? $post->cover_url : null);
@endphp

@if($errors->any())
    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
        <p class="font-semibold">Corrija os erros abaixo antes de guardar.</p>
        <ul class="mt-1 list-inside list-disc space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Conteúdo</h2>
            <p class="mt-1 text-xs text-[#4a5568]">Informação principal apresentada na listagem e na página da notícia.</p>

            <div class="mt-5 space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-[#031b3a]">Título</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" required
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    @error('title')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-[#031b3a]">Slug</label>
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $post->slug) }}"
                           placeholder="gerado automaticamente a partir do título"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <p class="mt-1 text-xs text-[#4a5568]/80">Endereço público: /news/{{ old('slug', $post->slug ?: 'slug-da-noticia') }}</p>

                    @if($post->exists && $post->status === \App\Enums\PostStatus::Published)
                        <p class="mt-2 flex items-start gap-2 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-700">
                            <i class="bx bx-error mt-0.5 text-base"></i>
                            <span>Esta notícia já está publicada. Alterar o slug pode quebrar links existentes.</span>
                        </p>
                    @endif

                    @error('slug')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-medium text-[#031b3a]">Resumo</label>
                    <textarea id="excerpt" name="excerpt" rows="3"
                              placeholder="Breve descrição apresentada nas listagens e nos resultados de pesquisa."
                              class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">{{ old('excerpt', $post->excerpt) }}</textarea>
                    <p class="mt-1 text-xs text-[#4a5568]/80">Se ficar vazio, será gerado a partir do conteúdo.</p>
                    @error('excerpt')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <span class="block text-sm font-medium text-[#031b3a]">Conteúdo da notícia</span>
                    <div class="mt-1">
                        <x-admin-editor name="body" :value="old('body', $post->body)" />
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="space-y-6">
        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Publicação</h2>

            <div class="mt-5 space-y-4">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-[#031b3a]">Categoria</label>
                    <select id="category_id" name="category_id" required
                            class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id', $post->category_id) === (string) $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-[#031b3a]">Estado</label>
                    <select id="status" name="status" required
                            class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" @selected($selectedStatus === $status->value)>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-[#4a5568]/80">Rascunhos não aparecem no website.</p>
                    @error('status')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-[#031b3a]">Data de publicação</label>
                    <input id="published_at" name="published_at" type="datetime-local"
                           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <p class="mt-1 text-xs text-[#4a5568]/80">Ao publicar sem data, será usada a data e hora atuais. Uma data futura agenda a publicação.</p>
                    @error('published_at')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-start gap-3 rounded-lg border border-[#e6edf7] bg-[#f8fafd] p-3">
                    <input type="checkbox" name="is_featured" value="1"
                           @checked(old('is_featured', $post->is_featured))
                           class="mt-0.5 rounded border-[#cfe0f4] text-[#13397c] focus:ring-[#2f96bf]">
                    <span>
                        <span class="block text-sm font-medium text-[#031b3a]">Destacar na página inicial</span>
                        <span class="block text-xs text-[#4a5568]">As notícias destacadas aparecem primeiro no website.</span>
                    </span>
                </label>
            </div>
        </section>

        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Imagem de capa</h2>

            <div class="mt-4">
                <x-admin-image-upload
                    name="cover_image"
                    label="Imagem de capa"
                    :current="$coverUrl"
                    remove-name="remove_cover"
                    help="JPG, PNG ou WebP até 4 MB. Recomendado: 1200 × 630 px."
                />
            </div>
        </section>

        @if($post->exists)
            <section class="rounded-xl border border-[#e6edf7] bg-white p-5 text-xs text-[#4a5568] shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-[#031b3a]">Informação</h2>
                <dl class="mt-3 space-y-2">
                    <div class="flex justify-between gap-3">
                        <dt>Criada em</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $post->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt>Atualizada em</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $post->updated_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt>Autor</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $post->author?->name ?? '—' }}</dd>
                    </div>
                </dl>
            </section>
        @endif
    </div>
</div>
