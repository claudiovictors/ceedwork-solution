@if(session('status') || session('error'))
    <div class="mb-5 space-y-2">
        @if(session('status'))
            <div class="flex items-start gap-3 rounded-xl border border-[#bde9e1] bg-[#effbf8] px-4 py-3 text-sm text-[#0f6b5f]" role="status">
                <i class="bx bx-check-circle mt-0.5 text-lg"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                <i class="bx bx-error-circle mt-0.5 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>
@endif
