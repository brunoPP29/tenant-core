<x-layouts::app :title="__('Módulos')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl" x-data="{ openModal: null }">
        
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @foreach(['Vendas'] as $index => $title)
                @php $id = $index + 1; @endphp
                
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm transition-all dark:border-neutral-700 dark:bg-neutral-800 flex flex-col justify-between">
                    <div class="z-10">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-neutral-100">{{ $title }}</h3>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Gerencie as configurações deste módulo.</p>
                    </div>

                    <div class="z-10 mt-4 flex gap-2">
                        <button @click="openModal = {{ $id }}" class="flex-1 rounded-lg bg-neutral-900 px-3 py-2 text-xs font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                            Detalhes
                        </button>
                        <form method="POST" action="/modules/{{$id}}/activate">
                            @csrf
                            <button type="submit" class="flex-1 rounded-lg border border-neutral-200 px-3 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 transition-all active:scale-95">
                                Ativar
                            </button>
                        </form>
                    </div>
                </div>

                <template x-teleport="body">
                    <div 
                        x-show="openModal === {{ $id }}" 
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacit1y-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-100 flex items-center justify-center p-4 bg-neutral-950/40 backdrop-blur-sm"
                        x-cloak
                    >
                        <div 
                            @click.away="openModal = null"
                            x-show="openModal === {{ $id }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            class="w-full max-w-lg overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-2xl dark:border-neutral-800 dark:bg-neutral-900"
                        >
                            <div class="p-8">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-50">{{ $title }}</h2>
                                    <button @click="openModal = null" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200">
                                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="mt-6 space-y-4 text-neutral-600 dark:text-neutral-400">
                                    <p>Ative seu módulo e acesse seu site com funcionalidades do módulo de: <strong>{{ $title }}</strong></p>
                                    <a href="/modules/{{ $title }}">Saiba mais</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>ive' => true
                </template>
            @endforeach
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-neutral-50/50 dark:bg-neutral-800/20">
             <x-placeholder-pattern class="absolute inset-0 size-full stroke-neutral-900/10 dark:stroke-neutral-100/10" />
        </div>
    </div>
</x-layouts::app>

<style>
    [x-cloak] { display: none !important; }
</style>