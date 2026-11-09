@props(['head', 'body'])

<div class="overflow-hidden rounded-xl border border-[#e6edf7] bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[#e6edf7] text-left text-sm">
            <thead class="bg-[#f8fafd] text-xs uppercase tracking-wide text-[#4a5568]">
                <tr>
                    {{ $head }}
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e6edf7]">
                {{ $body }}
            </tbody>
        </table>
    </div>
</div>
