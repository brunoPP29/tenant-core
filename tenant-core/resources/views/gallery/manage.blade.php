<x-layouts::app :title="__('Gerenciar Galeria')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative md:col-span-2 overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Adicionar Foto à Galeria
            </h2>

            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Preencha as informações para enviar uma nova imagem para a sua galeria.
            </p>
            
            <form method="POST" action="{{ route('modulesCompany.galleryStore') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf

                <input type="hidden" name="user_id" value="{{ $companyIdCheck }}">

                @if(session('success'))
                    <div class="p-3 rounded bg-green-100 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif
    
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Título da Foto
                    </label>
                    <input type="text" name="title" 
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Descrição
                    </label>
                    <textarea name="description" rows="3"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Texto Alternativo (Acessibilidade)
                    </label>
                    <input type="text" name="alt_text"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Selecionar Imagem
                    </label>
                    <input type="file" name="photo" accept="image/*" required
                        class="mt-1 w-full text-sm text-neutral-600 dark:text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-neutral-900 file:text-white hover:file:bg-neutral-700 dark:file:bg-neutral-100 dark:file:text-neutral-900">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="rounded-lg bg-neutral-900 px-5 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                        Salvar na Galeria
                    </button>

                    <a href="{{ url()->previous() }}"
                        class="rounded-lg border border-neutral-300 px-5 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</x-layouts::app>