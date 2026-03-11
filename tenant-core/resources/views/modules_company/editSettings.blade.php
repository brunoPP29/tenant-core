<x-layouts::app :title="__('Editar Configurações')">

<div class="flex w-full flex-1 flex-col gap-6">

    @if(session('success'))
        <div class="p-3 rounded-lg bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-3 rounded-lg bg-red-100 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('settingsCompany.store') }}" class="grid gap-6 lg:grid-cols-2">
        @csrf
        @method('PATCH')

        {{-- APARÊNCIA --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            <div class="mb-6">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-neutral-100">
                    Aparência
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Personalização visual da interface.
                </p>
            </div>

            <div class="space-y-4">

                <div>
                    <label class="text-sm font-medium">Tema</label>
                    <select name="appearance[theme]"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-900">
                        <option value="light" {{ $settings['appearance']['theme']=='light'?'selected':'' }}>Light</option>
                        <option value="dark" {{ $settings['appearance']['theme']=='dark'?'selected':'' }}>Dark</option>
                        <option value="system" {{ $settings['appearance']['theme']=='system'?'selected':'' }}>System</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Fonte</label>
                    <select name="appearance[font_family]"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-900">
                        <option value="Inter" {{ $settings['appearance']['font_family']=='Inter'?'selected':'' }}>Inter</option>
                        <option value="Roboto" {{ $settings['appearance']['font_family']=='Roboto'?'selected':'' }}>Roboto</option>
                        <option value="Open Sans" {{ $settings['appearance']['font_family']=='Open Sans'?'selected':'' }}>Open Sans</option>
                        <option value="Poppins" {{ $settings['appearance']['font_family']=='Poppins'?'selected':'' }}>Poppins</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Tamanho da Fonte</label>
                    <select name="appearance[font_size]"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-900">
                        <option value="small" {{ $settings['appearance']['font_size']=='small'?'selected':'' }}>Pequena</option>
                        <option value="normal" {{ $settings['appearance']['font_size']=='normal'?'selected':'' }}>Normal</option>
                        <option value="large" {{ $settings['appearance']['font_size']=='large'?'selected':'' }}>Grande</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Arredondamento</label>
                    <select name="appearance[border_radius]"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-900">
                        <option value="sm" {{ $settings['appearance']['border_radius']=='sm'?'selected':'' }}>Pequeno</option>
                        <option value="md" {{ $settings['appearance']['border_radius']=='md'?'selected':'' }}>Médio</option>
                        <option value="lg" {{ $settings['appearance']['border_radius']=='lg'?'selected':'' }}>Grande</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm font-medium">Cor Principal</label>
                        <input type="color"
                            name="appearance[primary_color]"
                            value="{{ $settings['appearance']['primary_color'] }}"
                            class="mt-1 h-10 w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Cor Secundária</label>
                        <input type="color"
                            name="appearance[secondary_color]"
                            value="{{ $settings['appearance']['secondary_color'] }}"
                            class="mt-1 h-10 w-full rounded-lg border border-neutral-300 dark:border-neutral-600 dark:bg-neutral-900">
                    </div>

                </div>

            </div>

        </div>


        {{-- SISTEMA --}}
        <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            <div class="mb-6">
                <h2 class="text-lg font-bold text-neutral-900 dark:text-neutral-100">
                    Sistema
                </h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Configurações operacionais da aplicação.
                </p>
            </div>

            <div class="space-y-4">

                <div>
                    <label class="text-sm font-medium">Formato de Data</label>
                    <select name="localization[date_format]"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-900">
                        <option value="d/m/Y" {{ $settings['localization']['date_format']=='d/m/Y'?'selected':'' }}>31/12/2026</option>
                        <option value="Y-m-d" {{ $settings['localization']['date_format']=='Y-m-d'?'selected':'' }}>2026-12-31</option>
                        <option value="m/d/Y" {{ $settings['localization']['date_format']=='m/d/Y'?'selected':'' }}>12/31/2026</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Formato de Hora</label>
                    <select name="localization[time_format]"
                        class="mt-1 w-full rounded-lg border border-neutral-300 px-3 py-2 text-sm dark:border-neutral-600 dark:bg-neutral-900">
                        <option value="H:i" {{ $settings['localization']['time_format']=='H:i'?'selected':'' }}>24h (14:30)</option>
                        <option value="h:i A" {{ $settings['localization']['time_format']=='h:i A'?'selected':'' }}>12h (02:30 PM)</option>
                    </select>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-3">
                        <input type="checkbox"
                            name="system[maintenance_mode]"
                            value="1"
                            {{ $settings['system']['maintenance_mode'] ? 'checked' : '' }}
                            class="rounded border-neutral-300 dark:border-neutral-600">
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">
                            Ativar modo manutenção
                        </span>
                    </label>
                </div>

            </div>

        </div>


        {{-- BOTÃO --}}
        <div class="lg:col-span-2 flex justify-end">
            <button type="submit"
                class="rounded-lg bg-neutral-900 px-6 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition">
                Salvar Configurações
            </button>
        </div>

    </form>

</div>

</x-layouts::app>