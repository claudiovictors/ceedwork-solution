@php
    $initialItems = collect(old('items', $service->items->pluck('title')->all()))
        ->map(fn (mixed $item): string => is_string($item) ? $item : '')
        ->values()
        ->all();

    if (count($initialItems) === 0) {
        $initialItems = [''];
    }

    $imageUrl = old('remove_image') ? null : ($service->image ? $service->image_url : null);
    $icon = old('icon', $service->icon ?? 'bx bx-code-alt');
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
            <h2 class="text-base font-semibold text-[#031b3a]">Informação do serviço</h2>
            <p class="mt-1 text-xs text-[#4a5568]">Conteúdo apresentado no cartão do serviço na página pública.</p>

            <div class="mt-5 space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-[#031b3a]">Título</label>
                    <input id="title" name="title" type="text" value="{{ old('title', $service->title) }}" required
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    @error('title')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-[#031b3a]">Slug</label>
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $service->slug) }}"
                           placeholder="gerado automaticamente a partir do título"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    @error('slug')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ icon: @js($icon) }">
                    <label for="icon" class="block text-sm font-medium text-[#031b3a]">Ícone Boxicons</label>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#eef4fb] text-[#13397c]">
                            <i :class="icon || 'bx bx-code-alt'" class="text-xl"></i>
                        </span>
                        <input id="icon" name="icon" type="text" x-model="icon" value="{{ $icon }}"
                               placeholder="bx bx-code-alt"
                               class="block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    </div>
                    <p class="mt-1 text-xs text-[#4a5568]/80">Use as classes do Boxicons, por exemplo <code>bx bx-mobile-alt</code>.</p>
                    @error('icon')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="summary" class="block text-sm font-medium text-[#031b3a]">Resumo</label>
                    <textarea id="summary" name="summary" rows="4" required
                              placeholder="Descrição breve do serviço."
                              class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">{{ old('summary', $service->summary) }}</textarea>
                    @error('summary')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section
            class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6"
            x-data="{
                items: @js($initialItems),
                addItem() {
                    this.items.push('');
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                moveUp(index) {
                    if (index === 0) {
                        return;
                    }

                    const item = this.items[index];
                    this.items[index] = this.items[index - 1];
                    this.items[index - 1] = item;
                },
                moveDown(index) {
                    if (index === this.items.length - 1) {
                        return;
                    }

                    const item = this.items[index];
                    this.items[index] = this.items[index + 1];
                    this.items[index + 1] = item;
                },
            }"
        >
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-base font-semibold text-[#031b3a]">Itens do serviço</h2>
                    <p class="mt-1 text-xs text-[#4a5568]">Cada item aparece como um benefício ou característica do serviço.</p>
                </div>

                <button type="button" @click="addItem()"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-[#cfe0f4] bg-[#f8fafd] px-3 py-2 text-xs font-semibold text-[#13397c] transition hover:bg-[#eef4fb]">
                    <i class="bx bx-plus text-base"></i>
                    Adicionar item
                </button>
            </div>

            <div class="mt-4 space-y-2">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex items-center gap-2">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#eef4fb] text-xs font-bold text-[#13397c]"
                              x-text="index + 1"></span>

                        <input
                            type="text"
                            :name="'items[' + index + ']'"
                            x-model="items[index]"
                            required
                            placeholder="Ex.: Websites e aplicações web"
                            class="block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]"
                        >

                        <button type="button" @click="moveUp(index)" :disabled="index === 0"
                                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-[#e6edf7] text-[#4a5568] transition hover:bg-[#f8fafd] disabled:cursor-not-allowed disabled:opacity-40"
                                title="Mover para cima">
                            <i class="bx bx-up-arrow-alt text-lg"></i>
                        </button>

                        <button type="button" @click="moveDown(index)" :disabled="index === items.length - 1"
                                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-[#e6edf7] text-[#4a5568] transition hover:bg-[#f8fafd] disabled:cursor-not-allowed disabled:opacity-40"
                                title="Mover para baixo">
                            <i class="bx bx-down-arrow-alt text-lg"></i>
                        </button>

                        <button type="button" @click="removeItem(index)" :disabled="items.length === 1"
                                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-40"
                                title="Remover item">
                            <i class="bx bx-trash text-base"></i>
                        </button>
                    </div>
                </template>
            </div>

            @error('items')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror

            @error('items.*')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </section>
    </div>

    <div class="space-y-6">
        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Publicação</h2>

            <div class="mt-5 space-y-4">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-[#031b3a]">Ordem</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" max="9999"
                           value="{{ old('sort_order', $service->sort_order ?? 0) }}"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <p class="mt-1 text-xs text-[#4a5568]/80">Números menores aparecem primeiro.</p>
                    @error('sort_order')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-start gap-3 rounded-lg border border-[#e6edf7] bg-[#f8fafd] p-3">
                    <input type="checkbox" name="is_active" value="1"
                           @checked(old('is_active', $service->is_active))
                           class="mt-0.5 rounded border-[#cfe0f4] text-[#13397c] focus:ring-[#2f96bf]">
                    <span>
                        <span class="block text-sm font-medium text-[#031b3a]">Serviço ativo</span>
                        <span class="block text-xs text-[#4a5568]">Apenas serviços ativos aparecem no website.</span>
                    </span>
                </label>
            </div>
        </section>

        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Imagem</h2>

            <div class="mt-4">
                <x-admin-image-upload
                    name="image"
                    label="Imagem do serviço"
                    :current="$imageUrl"
                    remove-name="remove_image"
                    help="JPG, PNG ou WebP até 4 MB."
                />
            </div>
        </section>

        @if($service->exists)
            <section class="rounded-xl border border-[#e6edf7] bg-white p-5 text-xs text-[#4a5568] shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-[#031b3a]">Informação</h2>
                <dl class="mt-3 space-y-2">
                    <div class="flex justify-between gap-3">
                        <dt>Criado em</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $service->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt>Atualizado em</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $service->updated_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt>Itens</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $service->items->count() }}</dd>
                    </div>
                </dl>
            </section>
        @endif
    </div>
</div>
