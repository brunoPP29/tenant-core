@php
    // --- Lógica de Manutenção ---
    $isMaintenance = ($settings['system']['maintenance_mode'] ?? "0") == "1";
    $isOwner = Auth::check() && Auth::user()->name === $company_name;
    $showSite = !$isMaintenance || $isOwner;

    // --- Variáveis de Aparência ---
    $theme = $settings['appearance']['theme'] ?? 'light';
    $fontFamily = $settings['appearance']['font_family'] ?? 'Poppins';
    $primaryColor = $settings['appearance']['primary_color'] ?? '#000000';
    $secondaryColor = $settings['appearance']['secondary_color'] ?? '#ffffff';
    
    $rootFontSize = match($settings['appearance']['font_size'] ?? 'medium') {
        'small' => '14px',
        'large' => '18px',
        default => '16px',
    };

    $borderRadius = match($settings['appearance']['border_radius'] ?? 'md') {
        'none' => '0px',
        'sm' => '4px',
        'lg' => '16px',
        'full' => '9999px',
        default => '12px',
    };

    $bgClass = $theme === 'dark' ? 'bg-[#0a0f1d] text-slate-200' : 'bg-slate-50 text-slate-900';
    $cardBg = $theme === 'dark' ? 'bg-slate-800/40 border-slate-700/50' : 'bg-white border-slate-200';
@endphp

<!DOCTYPE html>
<html lang="pt-BR" style="font-size: {{ $rootFontSize }};">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company_name }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $fontFamily) }}:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: {{ $primaryColor }};
            --secondary: {{ $secondaryColor }};
            --radius: {{ $borderRadius }};
        }
        body { 
            font-family: '{{ $fontFamily }}', sans-serif; 
            animation: fadeInPage 0.8s ease-out;
            line-height: 1.5;
        }

        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .interactive-card {
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: var(--radius);
        }
        .interactive-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.15);
            border-color: var(--primary);
        }

        .bg-primary { background-color: var(--primary); }
        .text-primary { color: var(--primary); }
        .text-secondary { color: var(--secondary); }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
    </style>
</head>
<body class="{{ $bgClass }} min-h-screen flex flex-col antialiased overflow-x-hidden">

    @if(!$showSite)
        {{-- MODO MANUTENÇÃO --}}
        <div class="flex-grow flex items-center justify-center p-6">
            <div class="{{ $cardBg }} backdrop-blur-xl p-16 text-center border shadow-2xl max-w-lg w-full" style="border-radius: var(--radius)">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-8 animate-pulse">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight">Manutenção</h1>
                <p class="opacity-60 text-lg">O site <strong>{{ $company_name }}</strong> está passando por ajustes técnicos.</p>
            </div>
        </div>
    @else
        {{-- NAVBAR --}}
        <nav class="h-24 border-b flex items-center {{ $theme === 'dark' ? 'border-white/5 bg-slate-900/50' : 'border-black/5 bg-white/70' }} backdrop-blur-2xl sticky top-0 z-50">
            <div class="container mx-auto px-8 flex justify-between items-center">
                <span class="text-3xl font-extrabold tracking-tighter uppercase">
                    {{ $company_name }}
                </span>
                
                @if($isOwner && $isMaintenance)
                    <div class="flex items-center gap-3 px-5 py-2.5 rounded-full bg-red-500/10 border border-red-500/20 text-red-500 text-xs font-bold uppercase tracking-widest">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        Acesso Administrativo
                    </div>
                @endif
            </div>
        </nav>

        {{-- HERO --}}
        <header class="py-24 relative">
            <div class="container mx-auto px-8">
                <div class="max-w-3xl">
                    <h1 class="text-6xl md:text-8xl font-extrabold mb-8 leading-[0.9] tracking-tighter">
                        Explore os <span class="text-primary">Ambientes</span>
                    </h1>
                    <p class="text-xl opacity-50 font-medium leading-relaxed">
                        Bem vindo aos ambientes da <strong>{{ $company_name }}</strong>, sinta se livre para explorar!
                    </p>
                </div>
            </div>
        </header>

        {{-- MÓDULOS --}}
        <main class="container mx-auto px-8 pb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($modules_info as $module)
                <a href="{{ url('/site/' . request()->route('company_name') . '/' . $module['slug']) }}" class="group">
                            <div class="interactive-card {{ $cardBg }} border p-10 h-full flex flex-col relative overflow-hidden shadow-sm">
                            {{-- Fundo sutil com primária apenas --}}
                            <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/5 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
                            
                            {{-- Ícone: Fundo Primário, Ícone Secundário --}}
                            <div class="w-16 h-16 mb-10 flex items-center justify-center bg-primary text-secondary shadow-lg shadow-primary/20" style="border-radius: var(--radius)">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            
                            <h2 class="text-3xl font-bold mb-4 group-hover:text-primary transition-colors">
                                {{ $module['name'] }}
                            </h2>
                            
                            <p class="opacity-40 font-normal leading-relaxed text-base mb-10">
                                Explore nosso ambiente de {{ strtolower($module['name']) }}.
                            </p>

                            <div class="mt-auto flex items-center gap-3 text-xs font-black uppercase tracking-[0.25em] text-primary group-hover:gap-6 transition-all">
                                Acessar <span class="text-2xl">→</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="mt-auto bg-slate-900 text-white pt-20 pb-10">
            <div class="container mx-auto px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                    <div>
                        <span class="text-3xl font-black uppercase tracking-tighter mb-6 block">
                            {{ $company_name }}
                        </span>
                        <p class="text-slate-400 max-w-sm leading-relaxed text-sm">
                            Os conteúdos publicados nesta página não têm responsabilidade do site e sim do criador da página.
                        </p>
                    </div>
                    
                    <div class="flex flex-col md:items-end">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-primary mb-6">Navegação</h4>
                        <ul class="space-y-4 text-sm text-slate-400 md:text-right">
                            @foreach($modules_info as $module)
                                <li>
                                    <a href="/{{ $module['slug'] }}" class="hover:text-primary transition-colors">
                                        {{ $module['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="pt-10 border-t border-white/5 text-center md:text-left">
                    <div class="text-[11px] uppercase tracking-widest font-bold text-slate-500">
                        &copy; {{ date('Y') }} {{ $company_name }} - Direitos Reservados
                    </div>
                </div>
            </div>
        </footer>
    @endif

</body>
</html>