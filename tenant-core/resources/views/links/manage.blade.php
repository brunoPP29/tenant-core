<x-layouts::app :title="__('Gerenciar Links')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid gap-6">
        <!-- Form de Adição -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Adicionar Link
            </h2>
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Cadastre um novo link para sua página.
            </p>

            @if(session('success'))
                <div class="mt-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 p-3 rounded bg-red-100 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('modulesCompany.linksStore') }}" class="mt-6 space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Título do Link
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Ex: Siga no Instagram"
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            URL (Link)
                        </label>
                        <input type="url" name="url" value="{{ old('url') }}" required placeholder="https://..."
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Ícone (Opcional)
                        </label>
                        <input type="text" name="icon" value="{{ old('icon') }}" placeholder="Ex: instagram, facebook, etc"
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Ordem
                        </label>
                        <input type="number" name="order" value="{{ old('order', 0) }}"
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="rounded-lg bg-neutral-900 px-5 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                        Salvar Link
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Links -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Links Ativos
            </h2>

            <div class="mt-6 space-y-3">
                @forelse($links as $link)
                    <div class="flex items-center justify-between p-4 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-neutral-900 dark:text-neutral-100">{{ $link->title }}</h4>
                                <p class="text-xs text-neutral-500 truncate max-w-xs">{{ $link->url }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('modulesCompany.linksEdit', $link->id) }}?module_id={{ $id }}" class="rounded-lg border border-neutral-300 p-2 text-neutral-700 hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            </a>
                            <form action="{{ route('modulesCompany.linksDestroy', $link->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este link?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg bg-red-600 p-2 text-white hover:bg-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-neutral-500 py-10">Nenhum link cadastrado.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

</x-layouts::app>
