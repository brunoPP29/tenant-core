<!DOCTYPE html>
<html lang="pt-BR" class="{{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company_name ?? 'Links' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: {{ $company_settings['appearance']['primary_color'] ?? '#000000' }};
            --radius: {{ match($company_settings['appearance']['border_radius'] ?? 'md') { 'sm' => '4px', 'lg' => '50px', default => '12px' } }};
        }
        body {
            font-family: '{{ $company_settings['appearance']['font_family'] ?? 'Inter' }}', sans-serif;
            background-color: {{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? '#0f172a' : '#f8fafc' }};
            color: {{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? '#f1f5f9' : '#1e293b' }};
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <div class="w-24 h-24 bg-neutral-900 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl font-black">
                {{ substr($company_name, 0, 1) }}
            </div>
            <h1 class="text-2xl font-black tracking-tight">{{ $company_name }}</h1>
            <p class="text-neutral-500 text-sm mt-1">Confira nossos links úteis</p>
        </div>

        <div class="space-y-4">
            @forelse($links as $link)
                <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                   class="block w-full p-4 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-md hover:scale-[1.02] transition-all font-bold text-neutral-900 dark:text-white"
                   style="border-radius: var(--radius)">
                   {{ $link->title }}
                </a>
            @empty
                <p class="text-neutral-500 py-10">Nenhum link disponível.</p>
            @endforelse
        </div>

        <footer class="mt-12 text-neutral-400 text-[10px] uppercase tracking-widest font-bold">
            Powered by Modular CMS
        </footer>
    </div>
</body>
</html>
