@props(['name' => 'body', 'value' => ''])

@once
    @vite('resources/js/admin-editor.js')
@endonce

<div class="admin-editor" data-editor data-upload-url="{{ route('admin.uploads.editor') }}">
    <div class="admin-editor__toolbar" data-editor-toolbar role="toolbar" aria-label="Formatação do conteúdo">
        <button type="button" class="admin-editor__button" data-action="h2" title="Título 2">H2</button>
        <button type="button" class="admin-editor__button" data-action="h3" title="Título 3">H3</button>

        <span class="admin-editor__separator"></span>

        <button type="button" class="admin-editor__button" data-action="bold" title="Negrito">
            <i class="bx bx-bold text-base"></i>
        </button>
        <button type="button" class="admin-editor__button" data-action="italic" title="Itálico">
            <i class="bx bx-italic text-base"></i>
        </button>
        <button type="button" class="admin-editor__button" data-action="link" title="Link">
            <i class="bx bx-link text-base"></i>
        </button>

        <span class="admin-editor__separator"></span>

        <button type="button" class="admin-editor__button" data-action="bullet-list" title="Lista com marcas">
            <i class="bx bx-list-ul text-base"></i>
        </button>
        <button type="button" class="admin-editor__button" data-action="ordered-list" title="Lista numerada">
            <i class="bx bx-list-ol text-base"></i>
        </button>
        <button type="button" class="admin-editor__button" data-action="blockquote" title="Citação">&ldquo;</button>
        <button type="button" class="admin-editor__button" data-action="code-block" title="Bloco de código">
            <i class="bx bx-code-alt text-base"></i>
        </button>
        <button type="button" class="admin-editor__button" data-action="horizontal-rule" title="Linha horizontal">HR</button>

        <span class="admin-editor__separator"></span>

        <button type="button" class="admin-editor__button" data-action="image" title="Inserir imagem">
            <i class="bx bx-image-add text-base"></i>
        </button>
        <button type="button" class="admin-editor__button" data-action="undo" title="Desfazer">
            <i class="bx bx-undo text-base"></i>
        </button>
        <button type="button" class="admin-editor__button" data-action="redo" title="Refazer">
            <i class="bx bx-redo text-base"></i>
        </button>
    </div>

    <div class="admin-editor__surface" data-editor-surface></div>

    <textarea name="{{ $name }}" id="{{ $name }}" data-editor-input class="hidden">{{ old($name, $value) }}</textarea>

    <input type="file" accept="image/jpeg,image/png,image/webp" data-editor-file class="hidden">
</div>

@error($name)
    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
@enderror
