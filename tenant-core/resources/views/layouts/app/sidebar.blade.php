<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        {{-- Script simples para o botão de copiar --}}
        <script>
            function copySiteLink(url) {
                navigator.clipboard.writeText(url).then(() => {
                    // Feedback visual simples (opcional)
                    alert('Link copiado com sucesso!');
                });
            }
        </script>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>

                    {{-- Link do Site e Botão Copiar (Apenas para não-superuser) --}}
                    @if(!auth()->user()->superuser)
                        @php $siteUrl = url('/site/' . auth()->user()->name); @endphp
                        
                        <flux:sidebar.item icon="globe-alt" href="{{ $siteUrl }}" target="_blank">
                            {{ __('Ver meu Site') }}
                        </flux:sidebar.item>
                        <flux:button 
                            size="sm" 
                            variant="subtle" 
                            icon="clipboard"
                            class="w-full justify-start text-xs"
                            onclick="copySiteLink('{{ $siteUrl }}')"
                        >
                            {{ __('Copiar link do meu site') }}
                        </flux:button>


                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:sidebar.nav>
                @if(auth()->user()->superuser)
                    <flux:sidebar.group :heading="__('Módulos')" class="grid">
                        <flux:sidebar.item icon="puzzle-piece" :href="route('modules.index')" :current="request()->routeIs('modules.index')" wire:navigate>
                            {{ __('Modules') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="plus" :href="route('modules.create')" :current="request()->routeIs('modules.create')" wire:navigate>
                            {{ __('Criar módulo') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @else
                    <flux:sidebar.group :heading="__('Módulos')" class="grid">
                        <flux:sidebar.item icon="puzzle-piece" :href="route('modulesCompany.index')" :current="request()->routeIs('modulesCompany.index')" wire:navigate>
                            {{ __('Modules') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Geral')" class="grid">
                    <flux:sidebar.item 
                        icon="cog-6-tooth" 
                        :href="route('settingsCompany.index')" 
                        :current="request()->routeIs('settingsCompany.index')" 
                        wire:navigate
                    >
                        {{ __('Configurações Gerais') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    {{-- Link do Site no Mobile Menu --}}
                    @if(!auth()->user()->superuser)
                        <flux:menu.item href="/site/{{ auth()->user()->name }}" icon="globe-alt" target="_blank">
                            {{ __('Ver meu Site') }}
                        </flux:menu.item>
                        <flux:menu.separator />
                    @endif

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>