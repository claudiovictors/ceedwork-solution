<div id="adminConfirm"
     class="fixed inset-0 z-[100] hidden"
     role="dialog"
     aria-modal="true"
     aria-labelledby="adminConfirmTitle"
     aria-describedby="adminConfirmMessage">

    <div class="fixed inset-0 bg-[#010414]/60 backdrop-blur-sm" data-confirm-backdrop></div>

    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="w-full max-w-md overflow-hidden rounded-xl border border-[#dbe5f1] bg-white shadow-2xl" role="document">

            <div class="flex items-start justify-between gap-4 border-b border-[#e6edf7] px-5 py-4">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
                        <i class="bx bx-error text-xl" aria-hidden="true"></i>
                    </span>

                    <div>
                        <h2 id="adminConfirmTitle" class="text-base font-semibold text-[#031b3a]">
                            Confirmar ação
                        </h2>
                        <p class="mt-0.5 text-xs text-[#8a97a8]">Esta ação pode não ser reversível.</p>
                    </div>
                </div>

                <button type="button"
                        data-confirm-cancel
                        class="rounded-lg p-1.5 text-[#8a97a8] transition hover:bg-[#f4f7fb] hover:text-[#031b3a]"
                        aria-label="Fechar">
                    <i class="bx bx-x text-xl" aria-hidden="true"></i>
                </button>
            </div>

            <div class="px-5 py-4">
                <p id="adminConfirmMessage" class="text-sm leading-relaxed text-[#4a5568]">
                    Tem a certeza de que quer continuar?
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-2 border-t border-[#e6edf7] bg-[#f8fafd] px-5 py-3">
                <button type="button"
                        data-confirm-cancel
                        class="rounded-lg border border-[#e6edf7] bg-white px-4 py-2 text-sm font-semibold text-[#4a5568] transition hover:bg-[#f4f7fb] hover:text-[#031b3a]">
                    Cancelar
                </button>

                <button type="button"
                        data-confirm-submit
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        const modal = document.getElementById('adminConfirm');

        if (!modal || modal.dataset.ready === '1') {
            return;
        }

        modal.dataset.ready = '1';

        const title = modal.querySelector('#adminConfirmTitle');
        const message = modal.querySelector('#adminConfirmMessage');
        const submitButton = modal.querySelector('[data-confirm-submit]');
        const cancelButtons = modal.querySelectorAll('[data-confirm-cancel]');
        const backdrop = modal.querySelector('[data-confirm-backdrop]');

        let pendingForm = null;
        let bypassConfirmation = false;

        const close = () => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            pendingForm = null;
        };

        const open = (form) => {
            pendingForm = form;
            title.textContent = form.dataset.confirmTitle || 'Confirmar ação';
            message.textContent = form.dataset.confirmMessage || form.dataset.confirm || 'Tem a certeza de que quer continuar?';
            submitButton.textContent = form.dataset.confirmButton || 'Confirmar';

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            submitButton.focus();
        };

        document.addEventListener('submit', (event) => {
            const form = event.target.closest('form[data-confirm]');

            if (!form || bypassConfirmation) {
                return;
            }

            event.preventDefault();
            open(form);
        }, true);

        cancelButtons.forEach((button) => button.addEventListener('click', close));
        backdrop.addEventListener('click', close);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                close();
            }
        });

        submitButton.addEventListener('click', () => {
            if (!pendingForm) {
                return;
            }

            const form = pendingForm;
            close();
            bypassConfirmation = true;
            form.requestSubmit();
            setTimeout(() => { bypassConfirmation = false; }, 0);
        });
    })();
</script>
