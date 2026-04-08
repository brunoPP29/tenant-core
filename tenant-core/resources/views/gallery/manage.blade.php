<x-layouts::app :title="__('Gerenciar Galeria')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid gap-6">
        <!-- Form de Adição -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Adicionar Foto à Galeria
            </h2>
            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Preencha as informações para enviar uma nova imagem para a sua galeria.
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
            
            <form method="POST" action="{{ route('modulesCompany.galleryStore') }}" enctype="multipart/form-data" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                @csrf
                <input type="hidden" name="user_id" value="{{ $companyIdCheck }}">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Título da Foto
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Texto Alternativo (Acessibilidade)
                        </label>
                        <input type="text" name="alt_text" value="{{ old('alt_text') }}"
                            class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @error('alt_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            Selecionar Imagem
                        </label>
                        <input type="file" name="photo" accept="image/*" required
                            class="mt-1 w-full text-sm text-neutral-600 dark:text-neutral-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-neutral-900 file:text-white hover:file:bg-neutral-700 dark:file:bg-neutral-100 dark:file:text-neutral-900">
                        @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                            Salvar na Galeria
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Lista de Fotos -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">
                Fotos na Galeria
            </h2>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($photos as $photo)
                    <div class="group relative overflow-hidden rounded-lg border border-neutral-200 dark:border-neutral-700">
                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->alt_text }}" class="h-48 w-full object-cover transition-transform group-hover:scale-105">

                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                            <div class="flex gap-2">
                                <a href="{{ route('modulesCompany.galleryEdit', $photo->id) }}?module_id={{ $id }}" class="rounded-full bg-white p-2 text-neutral-900 hover:bg-neutral-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </a>
                                <form action="{{ route('modulesCompany.galleryDestroy', $photo->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta foto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full bg-red-600 p-2 text-white hover:bg-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>
                            <span class="mt-2 text-xs font-medium text-white px-2 text-center">{{ $photo->title }}</span>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-neutral-500 py-10">Nenhuma foto encontrada na galeria.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

</x-layouts::app>