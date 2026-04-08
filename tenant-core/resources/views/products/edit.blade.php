<x-layouts::app :title="__('Editar Produto')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative md:col-span-2 overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Editar Produto
            </h2>

            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Atualize as informações do produto.
            </p>

            <form method="POST" action="{{ route('modulesCompany.productsUpdate', $product->id) }}" enctype="multipart/form-data" class="mt-6 space-y-5">
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
                        Nome do Produto
                    </label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Descrição
                    </label>
                    <textarea name="description" rows="3"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                        Preço
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-start gap-4">
                    <div class="shrink-0">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-24 w-24 rounded-lg object-cover border border-neutral-200 dark:border-neutral-700">
                        @else
                            <div class="h-24 w-24 rounded-lg bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center border border-neutral-200 dark:border-neutral-700">
                                <span class="text-neutral-400 text-xs">Sem imagem</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Alterar Imagem (Opcional)
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="mt-1 w-full text-sm text-neutral-600 dark:text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-neutral-900 file:text-white hover:file:bg-neutral-700 dark:file:bg-neutral-100 dark:file:text-neutral-900">
                        @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="rounded-lg bg-neutral-900 px-5 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                        Atualizar Produto
                    </button>

                    <a href="{{ route('modulesCompany.productsManage', ['id' => request('module_id')]) }}"
                        class="rounded-lg border border-neutral-300 px-5 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700 transition-all">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</x-layouts::app>
