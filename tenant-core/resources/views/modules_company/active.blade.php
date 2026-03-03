<x-layouts::app :title="__('Ativar Módulo')">

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

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

    <div class="grid gap-4 md:grid-cols-2">

        <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">

            <h2 class="text-lg font-bold text-neutral-900 dark:text-neutral-100">
                Configurações do módulo
            </h2>

            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                Defina os parâmetros iniciais antes de ativar.
            </p>

            <form method="POST" action="{{ route('modulesCompany.store') }}" class="mt-6 space-y-5">
                @csrf

                @foreach($defaultSettings as $name => $field)

                    <div class="flex flex-col gap-2">

                        <label class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                            {{ $field['label'] ?? ucfirst($name) }}
                        </label>

                        {{-- NUMBER --}}
                        @if($field['type'] === 'number')
                            <input type="number"
                                name="{{ $name }}"
                                value="{{ old($name, $field['default'] ?? '') }}"
                                min="{{ $field['min'] ?? '' }}"
                                max="{{ $field['max'] ?? '' }}"
                                class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:outline-none dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @endif

                        {{-- TEXT --}}
                        @if($field['type'] === 'text')
                            <input type="text"
                                name="{{ $name }}"
                                value="{{ old($name, $field['default'] ?? '') }}"
                                class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:outline-none dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                        @endif

                        {{-- SELECT --}}
                        @if($field['type'] === 'select')
                            <select name="{{ $name }}"
                                class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-neutral-900 focus:outline-none dark:border-neutral-600 dark:bg-neutral-900 dark:text-white">
                                @foreach($field['options'] ?? [] as $option)
                                    <option value="{{ $option }}"
                                        {{ old($name, $field['default'] ?? '') == $option ? 'selected' : '' }}>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        {{-- BOOLEAN --}}
                        @if($field['type'] === 'boolean')
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox"
                                    name="{{ $name }}"
                                    value="1"
                                    {{ old($name, $field['default'] ?? false) ? 'checked' : '' }}
                                    class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900 dark:border-neutral-600 dark:bg-neutral-900">
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                    Ativado
                                </span>
                            </label>
                        @endif

                        @error($name)
                            <span class="text-xs text-red-500">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                @endforeach

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="rounded-lg bg-neutral-900 px-4 py-2 text-sm font-semibold text-white hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 transition-all active:scale-95">
                        Ativar Módulo
                    </button>
                </div>

            </form>
        </div>

    </div>

</div>

</x-layouts::app>