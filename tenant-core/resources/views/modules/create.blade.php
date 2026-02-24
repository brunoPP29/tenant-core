<x-layouts::app :title="__('Criar Módulo')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

    <div class="grid auto-rows-min gap-4 md:grid-cols-3">

        <div class="relative md:col-span-2 overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Novo Módulo
            </h2>

            
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Preencha as informações para cadastrar um novo módulo.
            </p>
            
            <form method="POST" action="{{ route('modules.store') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @if(session('success'))
                    <div class="p-3 rounded bg-green-100 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif
    
                @if(session('error'))
                    <div class="p-3 rounded bg-red-100 text-red-800">
                        {{ session('error') }}
                    </div>
                @endif
                @csrf
                
                <!-- Nome -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Nome
                    </label>
                    <input type="text" name="name" required
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Slug
                    </label>
                    <input type="text" name="slug" required
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                </div>

                <!-- Is Core -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_core" value="1"
                        class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900">
                    <label class="text-sm text-neutral-700 dark:text-neutral-300">
                        Módulo principal (core)
                    </label>
                </div>

                <!-- Upload JSON -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Arquivo JSON do módulo
                    </label>
                    <input type="file" name="module_file" accept=".json" required
                        class="mt-1 w-full text-sm text-neutral-600 dark:text-neutral-400">
                </div>

                <!-- Botão -->
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="rounded-lg bg-neutral-900 px-5 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                        Criar módulo
                    </button>

                    <a href="{{ route('modules.create') }}"
                        class="rounded-lg border border-neutral-300 px-5 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

</x-layouts::app>