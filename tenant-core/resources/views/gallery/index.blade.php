<!DOCTYPE html>
<html lang="pt-BR" class="{{ $appearance['theme'] == 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ucfirst($config['slug']) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: {{ $appearance['primary_color'] }};
            --radius: {{ $appearance['border_radius'] == 'md' ? '8px' : ($appearance['border_radius'] == 'lg' ? '20px' : '0px') }};
        }
        body {
            font-family: '{{ $appearance['font_family'] }}', sans-serif;
            background-color: {{ $appearance['theme'] == 'dark' ? '#0f172a' : '#ffffff' }};
            color: {{ $appearance['theme'] == 'dark' ? '#f1f5f9' : '#1e293b' }};
        }
        .layout-masonry { column-count: {{ $config['columns'] ?? 3 }}; column-gap: 1.5rem; }
        .layout-masonry > div { break-inside: avoid; margin-bottom: 1.5rem; }
        
        /* Lightbox Styles */
        #lightbox { display: none; transition: opacity 0.3s ease; }
        #lightbox.active { display: flex; opacity: 1; }
    </style>
</head>
<body class="antialiased overflow-x-hidden">

    <main class="max-w-7xl mx-auto px-6 py-12">
        <header class="mb-12 border-b border-gray-200 dark:border-gray-800 pb-8">
            <h1 class="text-4xl font-bold tracking-tight">{{ ucfirst($config['slug']) }}</h1>
            <p class="text-xs opacity-50 mt-2 font-bold uppercase tracking-[0.2em]">{{ $config['layout'] }} mode</p>
        </header>

        @php
            $layout = $config['layout'] ?? 'grid';
            $containerClass = $layout === 'grid' ? 'grid gap-6' : ($layout === 'masonry' ? 'layout-masonry' : 'flex overflow-x-auto gap-6 pb-6 snap-x');
            $gridStyle = $layout === 'grid' ? "grid-template-columns: repeat({$config['columns']}, minmax(0, 1fr));" : "";
        @endphp

        <div class="{{ $containerClass }}" style="{{ $gridStyle }}">
            @forelse($items as $index => $item)
                <div class="gallery-item group relative cursor-zoom-in overflow-hidden bg-gray-100 dark:bg-gray-900 shadow-sm transition-all hover:shadow-md {{ $layout === 'carousel' ? 'min-w-[300px] snap-center' : '' }}" 
                     style="border-radius: var(--radius)"
                     onclick="openLightbox({{ $index }})">
                    
                    <div style="aspect-ratio: {{ $config['image_ratio'] === 'auto' ? 'auto' : str_replace(':', '/', $config['image_ratio']) }}">
                        <img src="{{ $item['url'] }}" data-full="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>

                    @if($config['show_titles'] ?? true)
                        <div class="absolute inset-x-0 bottom-0 bg-black/60 p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <p class="text-white text-xs font-bold truncate">{{ $item['title'] }}</p>
                        </div>
                    @endif
                </div>
            @empty
                @for($i = 0; $i < 6; $i++)
                    <div class="bg-gray-100 dark:bg-gray-900 border border-dashed border-gray-300 dark:border-gray-800 flex items-center justify-center" 
                         style="border-radius: var(--radius); aspect-ratio: {{ str_replace(':', '/', $config['image_ratio'] === 'auto' ? '1:1' : $config['image_ratio']) }}">
                        <span class="text-[10px] uppercase tracking-widest opacity-30">Slot {{ $i + 1 }}</span>
                    </div>
                @endfor
            @endforelse
        </div>
    </main>

    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-sm items-center justify-center p-4">
        <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white hover:text-[var(--primary)] transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        
        <button onclick="prevImage()" class="absolute left-6 text-white/50 hover:text-white transition-colors hidden md:block">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>

        <img id="lightbox-img" src="" class="max-w-full max-h-[90vh] object-contain shadow-2xl transition-all duration-300">

        <button onclick="nextImage()" class="absolute right-6 text-white/50 hover:text-white transition-colors hidden md:block">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        <div id="lightbox-caption" class="absolute bottom-10 text-white text-sm font-bold tracking-widest uppercase"></div>
    </div>

    <script>
        let currentIndex = 0;
        const images = @json($items);
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');

        function openLightbox(index) {
            if (!images.length) return;
            currentIndex = index;
            updateLightbox();
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function updateLightbox() {
            const item = images[currentIndex];
            lightboxImg.style.opacity = '0';
            setTimeout(() => {
                lightboxImg.src = item.url;
                lightboxCaption.innerText = item.title || '';
                lightboxImg.style.opacity = '1';
            }, 150);
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            updateLightbox();
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateLightbox();
        }

        // Teclado
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });

        // Fechar ao clicar no fundo
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
    </script>
</body>
</html>