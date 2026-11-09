@php
    $technologies = old('technologies', $project->technologies ?? []);

    if (is_array($technologies)) {
        $technologies = implode(', ', $technologies);
    }

    $logoUrl = old('remove_logo') ? null : ($project->logo ? $project->logo_url : null);
    $imageUrl = old('remove_image') ? null : ($project->image ? $project->image_url : null);
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
            <h2 class="text-base font-semibold text-[#031b3a]">Informação do projeto</h2>
            <p class="mt-1 text-xs text-[#4a5568]">Dados apresentados no cartão e na página do portfólio.</p>

            <div class="mt-5 space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-[#031b3a]">Nome</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $project->name) }}" required
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    @error('name')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-[#031b3a]">Slug</label>
                    <input id="slug" name="slug" type="text" value="{{ old('slug', $project->slug) }}"
                           placeholder="gerado automaticamente a partir do nome"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    @error('slug')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-[#031b3a]">Categoria</label>
                    <input id="category" name="category" type="text" list="project-categories"
                           value="{{ old('category', $project->category) }}"
                           placeholder="Ex.: Saúde, Educação, Tecnologia"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <datalist id="project-categories">
                        @foreach($categories as $category)
                            <option value="{{ $category }}"></option>
                        @endforeach
                    </datalist>
                    @error('category')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="summary" class="block text-sm font-medium text-[#031b3a]">Resumo</label>
                    <textarea id="summary" name="summary" rows="3" required
                              placeholder="Descrição breve do projeto."
                              class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">{{ old('summary', $project->summary) }}</textarea>
                    @error('summary')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-[#031b3a]">Descrição</label>
                    <textarea id="description" name="description" rows="8"
                              placeholder="Detalhes do projeto, contexto, objetivos e resultados."
                              class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="technologies" class="block text-sm font-medium text-[#031b3a]">Tecnologias</label>
                    <input id="technologies" name="technologies" type="text" value="{{ $technologies }}"
                           placeholder="Laravel, PHP, MySQL, Tailwind"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <p class="mt-1 text-xs text-[#4a5568]/80">Separe as tecnologias por vírgulas.</p>
                    @error('technologies.*')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>
    </div>

    <div class="space-y-6">
        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Publicação</h2>

            <div class="mt-5 space-y-4">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-[#031b3a]">Ordem</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" max="9999"
                           value="{{ old('sort_order', $project->sort_order ?? 0) }}"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <p class="mt-1 text-xs text-[#4a5568]/80">Números menores aparecem primeiro.</p>
                    @error('sort_order')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-start gap-3 rounded-lg border border-[#e6edf7] bg-[#f8fafd] p-3">
                    <input type="checkbox" name="is_published" value="1"
                           @checked(old('is_published', $project->is_published))
                           class="mt-0.5 rounded border-[#cfe0f4] text-[#13397c] focus:ring-[#2f96bf]">
                    <span>
                        <span class="block text-sm font-medium text-[#031b3a]">Projeto publicado</span>
                        <span class="block text-xs text-[#4a5568]">Apenas projetos publicados aparecem no website.</span>
                    </span>
                </label>

                <div>
                    <label for="url" class="block text-sm font-medium text-[#031b3a]">Ligação externa</label>
                    <input id="url" name="url" type="url" value="{{ old('url', $project->url) }}"
                           placeholder="https://exemplo.com"
                           class="mt-1 block w-full rounded-lg border-[#dbe5f1] text-sm text-[#1f2a3d] shadow-sm focus:border-[#2f96bf] focus:ring-[#2f96bf]">
                    <p class="mt-1 text-xs text-[#4a5568]/80">Opcional. Endereço do projeto ou estudo de caso.</p>
                    @error('url')
                        <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Imagem de capa</h2>

            <div class="mt-4">
                <x-admin-image-upload
                    name="image"
                    label="Imagem do projeto"
                    :current="$imageUrl"
                    remove-name="remove_image"
                    help="JPG, PNG ou WebP até 4 MB."
                />
            </div>
        </section>

        <section class="rounded-xl border border-[#e6edf7] bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-semibold text-[#031b3a]">Logótipo</h2>

            <div class="mt-4">
                <x-admin-image-upload
                    name="logo"
                    label="Logótipo do projeto"
                    :current="$logoUrl"
                    remove-name="remove_logo"
                    help="JPG, PNG ou WebP até 4 MB."
                />
            </div>
        </section>

        @if($project->exists)
            <section class="rounded-xl border border-[#e6edf7] bg-white p-5 text-xs text-[#4a5568] shadow-sm sm:p-6">
                <h2 class="text-base font-semibold text-[#031b3a]">Informação</h2>
                <dl class="mt-3 space-y-2">
                    <div class="flex justify-between gap-3">
                        <dt>Criado em</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $project->created_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt>Atualizado em</dt>
                        <dd class="font-medium text-[#031b3a]">{{ $project->updated_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                    </div>
                </dl>
            </section>
        @endif
    </div>
</div>
