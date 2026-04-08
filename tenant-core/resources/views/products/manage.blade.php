<x-layouts::app :title="__('Gerenciar Catálogo de Produtos')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid gap-6">
        <!-- Form de Adição -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Adicionar Produto
            </h2>
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Cadastre um novo produto no seu catálogo.
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

            <form method="POST" action="{{ route('modulesCompany.productsStore') }}" enctype="multipart/form-data" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Nome do Produto
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Preço (Opcional)
                        </label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Imagem do Produto
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="mt-1 w-full text-sm text-neutral-600 dark:text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-neutral-900 file:text-white hover:file:bg-neutral-700 dark:file:bg-neutral-100 dark:file:text-neutral-900">
                        @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Descrição
                        </label>
                        <textarea name="description" rows="5"
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="rounded-lg bg-neutral-900 px-5 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                            Salvar Produto
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de Produtos -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Produtos no Catálogo
            </h2>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($products as $product)
                    <div class="group relative overflow-hidden rounded-lg border border-neutral-200 dark:border-neutral-700">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover transition-transform group-hover:scale-105">
                        @else
                            <div class="h-48 w-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center">
                                <span class="text-neutral-400">Sem imagem</span>
                            </div>
                        @endif

                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                            <div class="flex gap-2">
                                <a href="{{ route('modulesCompany.productsEdit', $product->id) }}?module_id={{ $id }}" class="rounded-full bg-white p-2 text-neutral-900 hover:bg-neutral-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </a>
                                <form action="{{ route('modulesCompany.productsDestroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full bg-red-600 p-2 text-white hover:bg-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                            <span class="mt-2 text-xs font-medium text-white px-2 text-center">{{ $product->name }}</span>
                            @if($product->price)
                                <span class="text-xs text-white">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-neutral-500 py-10">Nenhum produto encontrado no catálogo.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

</x-layouts::app>
