import { Editor } from '@tiptap/core';
import Image from '@tiptap/extension-image';
import StarterKit from '@tiptap/starter-kit';
import '../css/admin-editor.css';

const escapeHtml = (value) =>
    value.replace(/[&<>"']/g, (character) => {
        const entities = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        };

        return entities[character];
    });

const initEditor = () => {
    const root = document.querySelector('[data-editor]');

    if (!root) {
        return;
    }

    const textarea = root.querySelector('[data-editor-input]');
    const surface = root.querySelector('[data-editor-surface]');
    const toolbar = root.querySelector('[data-editor-toolbar]');
    const fileInput = root.querySelector('[data-editor-file]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    if (!textarea || !surface) {
        return;
    }

    const editor = new Editor({
        element: surface,
        extensions: [
            StarterKit.configure({
                heading: {
                    levels: [2, 3],
                },
                link: {
                    openOnClick: false,
                    autolink: true,
                    linkOnPaste: true,
                },
            }),
            Image.configure({
                inline: false,
                allowBase64: false,
            }),
        ],
        content: textarea.value || '<p></p>',
        editorProps: {
            attributes: {
                class: 'focus:outline-none',
            },
        },
        onUpdate: ({ editor }) => {
            textarea.value = editor.getHTML();
        },
    });

    const insertLink = () => {
        const previousUrl = editor.getAttributes('link').href ?? '';
        let url = window.prompt('URL do link', previousUrl || 'https://');

        if (url === null) {
            return;
        }

        url = url.trim();

        if (url === '') {
            editor.chain().focus().extendMarkRange('link').unsetLink().run();

            return;
        }

        if (!/^(https?:\/\/|mailto:|tel:|\/)/i.test(url)) {
            url = `https://${url}`;
        }

        if (editor.state.selection.empty) {
            const safeUrl = escapeHtml(url);

            editor
                .chain()
                .focus()
                .insertContent(
                    `<a href="${safeUrl}" target="_blank" rel="noopener noreferrer">${safeUrl}</a>`
                )
                .run();

            return;
        }

        editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
    };

    const uploadImage = async (file) => {
        const data = new FormData();
        data.append('image', file);

        const response = await fetch(root.dataset.uploadUrl, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: data,
        });

        if (!response.ok) {
            const payload = await response.json().catch(() => null);
            throw new Error(payload?.message ?? 'Não foi possível carregar a imagem.');
        }

        const payload = await response.json();

        if (!payload?.url) {
            throw new Error('O servidor devolveu uma resposta inválida.');
        }

        editor.chain().focus().setImage({ src: payload.url, alt: file.name }).run();
    };

    toolbar?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-action]');

        if (!button) {
            return;
        }

        event.preventDefault();

        switch (button.dataset.action) {
            case 'h2':
                editor.chain().focus().toggleHeading({ level: 2 }).run();
                break;
            case 'h3':
                editor.chain().focus().toggleHeading({ level: 3 }).run();
                break;
            case 'bold':
                editor.chain().focus().toggleBold().run();
                break;
            case 'italic':
                editor.chain().focus().toggleItalic().run();
                break;
            case 'link':
                insertLink();
                break;
            case 'bullet-list':
                editor.chain().focus().toggleBulletList().run();
                break;
            case 'ordered-list':
                editor.chain().focus().toggleOrderedList().run();
                break;
            case 'blockquote':
                editor.chain().focus().toggleBlockquote().run();
                break;
            case 'code-block':
                editor.chain().focus().toggleCodeBlock().run();
                break;
            case 'horizontal-rule':
                editor.chain().focus().setHorizontalRule().run();
                break;
            case 'image':
                fileInput?.click();
                break;
            case 'undo':
                editor.chain().focus().undo().run();
                break;
            case 'redo':
                editor.chain().focus().redo().run();
                break;
        }
    });

    fileInput?.addEventListener('change', async () => {
        const file = fileInput.files?.[0];

        if (!file) {
            return;
        }

        try {
            await uploadImage(file);
        } catch (error) {
            window.alert(error.message || 'Não foi possível carregar a imagem.');
        } finally {
            fileInput.value = '';
        }
    });

    const activeStates = {
        h2: () => editor.isActive('heading', { level: 2 }),
        h3: () => editor.isActive('heading', { level: 3 }),
        bold: () => editor.isActive('bold'),
        italic: () => editor.isActive('italic'),
        link: () => editor.isActive('link'),
        'bullet-list': () => editor.isActive('bulletList'),
        'ordered-list': () => editor.isActive('orderedList'),
        blockquote: () => editor.isActive('blockquote'),
        'code-block': () => editor.isActive('codeBlock'),
    };

    const syncToolbar = () => {
        toolbar?.querySelectorAll('[data-action]').forEach((button) => {
            const action = button.dataset.action;

            if (action === 'undo' || action === 'redo') {
                button.disabled = action === 'undo' ? !editor.can().undo() : !editor.can().redo();

                return;
            }

            if (activeStates[action]) {
                button.classList.toggle('is-active', activeStates[action]());
            }
        });
    };

    editor.on('selectionUpdate', syncToolbar);
    editor.on('transaction', syncToolbar);
    syncToolbar();

    textarea.form?.addEventListener('submit', () => {
        textarea.value = editor.getHTML();
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEditor);
} else {
    initEditor();
}
