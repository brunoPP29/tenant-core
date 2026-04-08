<x-layouts::app :title="__('Editar Link')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative md:col-span-2 overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Editar Link
            </h2>

            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Atualize as informações do link.
            </p>

            <form method="POST" action="{{ route('modulesCompany.linksUpdate', $link->id) }}" class="mt-6 space-y-5">
                @csrf
                @method('PATCH')

                <input type="hidden" name="module_id" value="{{ request('module_id') }}">

                @if(session('error'))
                    <div class="p-3 rounded bg-red-100 text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Título do Link
                    </label>
                    <input type="text" name="title" value="{{ old('title', $link->title) }}" required
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        URL (Link)
                    </label>
                    <input type="url" name="url" value="{{ old('url', $link->url) }}" required
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                    @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Ícone (Opcional)
                    </label>
                    <input type="text" name="icon" value="{{ old('icon', $link->icon) }}"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Ordem
                    </label>
                    <input type="number" name="order" value="{{ old('order', $link->order) }}"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="rounded-lg bg-neutral-900 px-5 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                        Atualizar Link
                    </button>

                    <a href="{{ route('modulesCompany.linksManage', ['id' => request('module_id')]) }}"
                        class="rounded-lg border border-neutral-300 px-5 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</x-layouts::app>
