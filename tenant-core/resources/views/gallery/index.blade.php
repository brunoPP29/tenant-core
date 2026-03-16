<!DOCTYPE html>
<html lang="pt-BR" class="{{ $appearance['theme'] == 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company['display_name'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: {{ $appearance['primary_color'] }};
            --radius: {{ $appearance['border_radius'] == 'md' ? '8px' : ($appearance['border_radius'] == 'lg' ? '24px' : '0px') }};
        }
        body {
            font-family: '{{ $appearance['font_family'] }}', sans-serif;
            background-color: {{ $appearance['theme'] == 'dark' ? '#0f172a' : '#ffffff' }};
            color: {{ $appearance['theme'] == 'dark' ? '#f1f5f9' : '#1e293b' }};
        }

        .gallery-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat({{ $config['columns'] ?? 3 }}, minmax(0, 1fr));
        }

        .gallery-masonry {
            columns: {{ $config['columns'] ?? 3 }} 250px;
            column-gap: 1.5rem;
        }
        .gallery-masonry > div {
            break-inside: avoid;
            margin-bottom: 1.5rem;
            display: inline-block;
            width: 100%;
        }

        .gallery-carousel {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding-bottom: 1rem;
            scroll-behavior: smooth;
        }
        .gallery-carousel > div {
            flex: 0 0 calc(100% / {{ $config['columns'] ?? 3 }} - 1rem);
            scroll-snap-align: start;
            min-width: 280px;
        }
        .gallery-carousel::-webkit-scrollbar { height: 6px; }
        .gallery-carousel::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
        
        #lightbox { display: none; opacity: 0; transition: opacity 0.3s ease; }
        #lightbox.active { display: flex; opacity: 1; }
    </style>
</head>
<body class="antialiased">

    <main class="max-w-7xl mx-auto px-6 py-12">
        <section class="mb-16 border-b border-gray-200 dark:border-gray-800 pb-10 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black tracking-tight mb-2">Galeria de {{ $company['display_name'] }}</h1>
                <p class="text-sm opacity-60 uppercase tracking-widest font-bold">{{ $config['slug'] }} / {{ $config['layout'] }}</p>
            </div>
            <div class="text-right hidden md:block">
                <span class="text-3xl font-light">{{ $total_count }}</span>
                <span class="block text-[10px] uppercase font-black opacity-40">Mídias</span>
            </div>
        </section>

        <div class="gallery-{{ $config['layout'] ?? 'grid' }}">
            @forelse($items as $index => $item)
                <div class="group relative cursor-zoom-in overflow-hidden bg-gray-100 dark:bg-gray-900 shadow-sm hover:shadow-xl transition-all" 
                     style="border-radius: var(--radius)"
                     onclick="openLightbox({{ $index }})">
                    
                    <div style="aspect-ratio: {{ $config['layout'] === 'masonry' || $config['image_ratio'] === 'auto' ? 'auto' : str_replace(':', '/', $config['image_ratio']) }}">
                        <img src="{{ $item['url'] }}" class="w-full h-full object-cover">
                    </div>

                    @if($config['show_titles'] ?? true)
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                            <p class="text-white text-xs font-bold uppercase tracking-wider">{{ $item['title'] }}</p>
                        </div>
                    @endif
                </div>
            @empty
                @for($i = 1; $i <= 6; $i++)
                    <div class="bg-gray-100 dark:bg-gray-800/50 border border-dashed border-gray-300 dark:border-gray-700 flex items-center justify-center" 
                         style="border-radius: var(--radius); aspect-ratio: {{ $config['image_ratio'] === 'auto' ? '1/1' : str_replace(':', '/', $config['image_ratio']) }}">
                        <span class="text-[9px] font-black opacity-20 uppercase tracking-widest">Vazio {{ $i }}</span>
                    </div>
                @endfor
            @endforelse
        </div>
    </main>

    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md items-center justify-center p-4">
        <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white/50 hover:text-white">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        
        <button onclick="prevImage()" class="absolute left-4 text-white/20 hover:text-white transition-all">
            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7"/></svg>
        </button>

        <div class="relative flex flex-col items-center max-w-5xl">
            <img id="lightbox-img" src="" class="max-w-full max-h-[85vh] object-contain">
            <div id="lightbox-caption" class="mt-4 text-white text-[10px] font-black uppercase tracking-[0.3em]"></div>
        </div>

        <button onclick="nextImage()" class="absolute right-4 text-white/20 hover:text-white transition-all">
            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7"/></svg>
        </button>
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
            lightboxImg.src = item.url;
            lightboxCaption.innerText = item.title || '';
        }

        function nextImage() { currentIndex = (currentIndex + 1) % images.length; updateLightbox(); }
        function prevImage() { currentIndex = (currentIndex - 1 + images.length) % images.length; updateLightbox(); }

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });
        lightbox.addEventListener('click', (e) => { if (e.target === lightbox) closeLightbox(); });
    </script>
</body>
</html>