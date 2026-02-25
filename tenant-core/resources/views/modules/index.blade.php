<x-layouts::app :title="__('Módulos')">

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl" x-data="{ openModal: null }">
        
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">

            @foreach($modules as $module)
                
                <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm transition-all dark:border-neutral-700 dark:bg-neutral-800 flex flex-col justify-between">
                    
                    <div class="z-10">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-neutral-100">
                            {{ $module->name }}
                        </h3>

                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                            {{ $module->description ?? 'Gerencie as configurações deste módulo.' }}
                        </p>
                    </div>

                    <div class="z-10 mt-4 flex gap-2">
                        
                        <button 
                            @click="openModal = {{ $module->id }}"
                            class="flex-1 rounded-lg bg-neutral-900 px-3 py-2 text-xs font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                            Detalhes
                        </button>
                    @if(!$module->is_active)
                    {{-- ATIVAR --}}
                    <form method="POST" action="{{ route('modules.activate', $module->id) }}">
                                @csrf
                                <button type="submit"
                                    class="flex-1 rounded-lg border border-neutral-200 px-3 py-2 text-xs font-semibold text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 transition-all active:scale-95">
                                    Disponibilizar
                                </button>
                            </form>
                            @else
                            {{-- DESATIVAR --}}
                            <form method="POST" action="{{ route('modules.deactivate', $module->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                class="flex-1 rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900 transition-all active:scale-95">
                                Tirar do ar
                            </button>
                        </form>
                        @endif

                    </div>
                </div>

                <!-- MODAL -->
                <template x-teleport="body">
                    <div 
                        x-show="openModal === {{ $module->id }}"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-950/40 backdrop-blur-sm"
                        x-cloak
                    >
                        <div 
                            @click.away="openModal = null"
                            class="w-full max-w-lg overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-2xl dark:border-neutral-800 dark:bg-neutral-900"
                        >
                            <div class="p-8">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-50">
                                        {{ $module->name }}
                                    </h2>

                                    <button @click="openModal = null"
                                        class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200">
                                        ✕
                                    </button>
                                </div>

                                <div class="mt-6 space-y-4 text-neutral-600 dark:text-neutral-400">
                                    <p>
                                        Ative seu módulo e acesse funcionalidades de:
                                        <strong>{{ $module->name }}</strong>
                                    </p>

                                    <a href="{{ route('modules.show', $module->slug) }}"
                                       class="text-blue-600 hover:underline">
                                       Saiba mais
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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