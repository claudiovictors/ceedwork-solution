<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Página não encontrada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
                <p class="text-6xl font-black text-[#13397c]">404</p>
                <h1 class="mt-4 text-2xl font-bold text-[#031b3a]">Página não encontrada</h1>
                <p class="mt-2 text-sm text-slate-600">
                    O recurso que procura não existe ou foi removido da área administrativa.
                </p>
                <a href="{{ route('dashboard') }}"
                   class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#13397c] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#031b3a]">
                    <i class="bx bx-arrow-back text-lg"></i>
                    Voltar ao dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
