{{-- resources/views/components/_assistant.blade.php --}}
{{-- Assistente virtual: botão flutuante + janela de chat. Inclui no footer ou no layout. --}}
<div class="assistant" id="assistant"
     data-endpoint="{{ route('assistant.chat') }}"
     data-token="{{ csrf_token() }}">

    <button type="button" class="assistant__toggle" id="assistantToggle"
            aria-label="Abrir assistente virtual" aria-expanded="false" aria-controls="assistantPanel">
        <i class='bx bx-message-square-dots' aria-hidden="true"></i>
    </button>

    <section class="assistant__panel" id="assistantPanel" role="dialog" aria-label="Assistente virtual da Ceedwork">

        <header class="assistant__head">
            <span class="assistant__avatar" aria-hidden="true"><i class='bx bx-bot'></i></span>
            <div class="assistant__title">
                <strong>Assistente Ceedwork</strong>
                <small><span class="assistant__dot" aria-hidden="true"></span> Online</small>
            </div>
            <button type="button" class="assistant__close" id="assistantClose" aria-label="Fechar assistente">
                <i class='bx bx-x' aria-hidden="true"></i>
            </button>
        </header>

        <div class="assistant__messages" id="assistantMessages" role="log" aria-live="polite"></div>

        <div class="assistant__chips" id="assistantChips">
            <button type="button">Que serviços oferecem?</button>
            <button type="button">Como peço um orçamento?</button>
            <button type="button">Onde ficam localizados?</button>
        </div>

        <form class="assistant__form" id="assistantForm" autocomplete="off">
            <input type="text" id="assistantInput" placeholder="Escreva a sua pergunta..."
                   maxlength="500" aria-label="A sua mensagem" required>
            <button type="submit" aria-label="Enviar mensagem"><i class='bx bx-send' aria-hidden="true"></i></button>
        </form>

        <p class="assistant__note">Respostas geradas por IA. Para assuntos importantes, fale com a equipa.</p>
    </section>
</div>

<script>
    (() => {
        const root     = document.getElementById('assistant');
        const toggle   = document.getElementById('assistantToggle');
        const closeBtn = document.getElementById('assistantClose');
        const list     = document.getElementById('assistantMessages');
        const chips    = document.getElementById('assistantChips');
        const form     = document.getElementById('assistantForm');
        const input    = document.getElementById('assistantInput');
        const icon     = toggle.querySelector('i');

        const endpoint = root.dataset.endpoint;
        const token    = root.dataset.token;
        const STORAGE  = 'ceedwork-assistant';
        const GREETING = 'Olá! Sou o assistente virtual da Ceedwork. Como posso ajudar?';

        let history = [];   // [{ role: 'user' | 'model', text }]
        let busy = false;
        let typingEl = null;

        // ---------- texto seguro (escapa HTML e aceita **negrito**, listas e links) ----------
        const esc = (s) => s.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

        const inline = (s) => s
            .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
            .replace(/(https?:\/\/[^\s<]+)/g, '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>');

        const format = (text) => {
            let out = '';
            let inList = false;

            for (const raw of esc(text).split('\n')) {
                const line = raw.trim();
                const item = line.match(/^[*-]\s+(.*)$/);

                if (item) {
                    if (!inList) { out += '<ul>'; inList = true; }
                    out += `<li>${inline(item[1])}</li>`;
                    continue;
                }

                if (inList) { out += '</ul>'; inList = false; }
                if (line) out += `<p>${inline(line)}</p>`;
            }

            return inList ? out + '</ul>' : out;
        };

        // ---------- mensagens ----------
        const scrollDown = () => { list.scrollTop = list.scrollHeight; };

        const addMessage = (role, text, isError = false) => {
            const row    = document.createElement('div');
            const bubble = document.createElement('div');

            row.className = `msg msg--${role}`;
            bubble.className = 'msg__bubble' + (isError ? ' msg__bubble--error' : '');

            if (role === 'user') bubble.textContent = text;
            else bubble.innerHTML = format(text);

            row.appendChild(bubble);
            list.appendChild(row);
            scrollDown();
        };

        const showTyping = () => {
            typingEl = document.createElement('div');
            typingEl.className = 'msg msg--model';
            typingEl.innerHTML = '<div class="msg__bubble typing" aria-label="A escrever"><span></span><span></span><span></span></div>';
            list.appendChild(typingEl);
            scrollDown();
        };

        const hideTyping = () => { typingEl?.remove(); typingEl = null; };

        const save = () => {
            try { sessionStorage.setItem(STORAGE, JSON.stringify(history)); } catch (e) { /* sem storage */ }
        };

        // ---------- abrir / fechar ----------
        const setOpen = (open) => {
            root.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open);
            toggle.setAttribute('aria-label', open ? 'Fechar assistente virtual' : 'Abrir assistente virtual');
            icon.className = open ? 'bx bx-chevron-down' : 'bx bx-message-square-dots';

            if (open) {
                scrollDown();
                setTimeout(() => input.focus(), 150);
            } else {
                toggle.focus();
            }
        };

        // ---------- enviar ----------
        const send = async (text) => {
            text = text.trim();
            if (busy || !text) return;

            busy = true;
            input.value = '';
            chips.hidden = true;

            addMessage('user', text);
            history.push({ role: 'user', text });
            showTyping();

            try {
                const res = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ messages: history.slice(-10) }),
                });

                const data = await res.json().catch(() => ({}));
                hideTyping();

                if (!res.ok) {
                    const fallback = {
                        419: 'A sessão expirou. Atualize a página e tente novamente.',
                        429: 'Muitas mensagens seguidas. Aguarde um minuto e tente de novo.',
                    }[res.status] || 'Não foi possível responder agora. Tente novamente.';

                    throw new Error(data.message || fallback);
                }

                addMessage('model', data.reply);
                history.push({ role: 'model', text: data.reply });
            } catch (err) {
                hideTyping();
                history.pop(); // a pergunta falhada não entra no histórico
                addMessage('model', err.message || 'Não foi possível responder agora.', true);
            } finally {
                busy = false;
                save();
                input.focus();
            }
        };

        // ---------- eventos ----------
        toggle.addEventListener('click', () => setOpen(!root.classList.contains('is-open')));
        closeBtn.addEventListener('click', () => setOpen(false));

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && root.classList.contains('is-open')) setOpen(false);
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            send(input.value);
        });

        chips.querySelectorAll('button').forEach((chip) => {
            chip.addEventListener('click', () => send(chip.textContent));
        });

        // ---------- arranque: saudação + conversa guardada nesta sessão ----------
        addMessage('model', GREETING);

        try { history = JSON.parse(sessionStorage.getItem(STORAGE)) || []; } catch (e) { history = []; }

        history.forEach((m) => addMessage(m.role, m.text));
        chips.hidden = history.length > 0;
    })();
</script>