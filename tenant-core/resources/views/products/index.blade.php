<!DOCTYPE html>
<html lang="pt-BR" class="{{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - {{ $company_name ?? 'Empresa' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: {{ $company_settings['appearance']['primary_color'] ?? '#000000' }};
            --radius: {{ match($company_settings['appearance']['border_radius'] ?? 'md') { 'sm' => '4px', 'lg' => '24px', default => '12px' } }};
        }
        body {
            font-family: '{{ $company_settings['appearance']['font_family'] ?? 'Inter' }}', sans-serif;
            background-color: {{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? '#0f172a' : '#ffffff' }};
            color: {{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? '#f1f5f9' : '#1e293b' }};
        }
    </style>
</head>
<body class="antialiased min-h-screen">
    <main class="max-w-7xl mx-auto px-6 py-12">
        <header class="mb-12">
            <h1 class="text-4xl font-black tracking-tight mb-2">Nosso Catálogo</h1>
            <p class="text-neutral-500 uppercase tracking-widest text-sm">{{ $company_name }}</p>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="group bg-white dark:bg-neutral-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-neutral-100 dark:border-neutral-700" style="border-radius: var(--radius)">
                    <div class="aspect-square overflow-hidden bg-neutral-100 dark:bg-neutral-900">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-neutral-400">Sem imagem</div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold mb-1">{{ $product->name }}</h3>
                        <p class="text-neutral-500 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>
                        <div class="flex items-center justify-between">
                            @if($product->price)
                                <span class="text-lg font-black text-neutral-900 dark:text-white">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                            @endif
                            <button class="px-4 py-2 bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 text-xs font-bold uppercase tracking-widest rounded-lg hover:opacity-80 transition-opacity" style="border-radius: var(--radius)">Ver mais</button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center py-20 text-neutral-500 font-medium">Nenhum produto disponível no momento.</p>
            @endforelse
        </div>
    </main>
</body>
</html>
