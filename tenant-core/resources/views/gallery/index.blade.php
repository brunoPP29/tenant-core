<!DOCTYPE html>
<html lang="pt-BR" class="{{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de {{ $company_name ?? 'Empresa' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            /* Cores extraídas das configurações de Aparência */
            --primary: {{ $company_settings['appearance']['primary_color'] ?? '#000000' }};
            --secondary: {{ $company_settings['appearance']['secondary_color'] ?? '#666666' }};
            
            /* Mapeamento do Border Radius */
            --radius: {{ 
                match($company_settings['appearance']['border_radius'] ?? 'md') {
                    'sm' => '4px',
                    'lg' => '24px',
                    default => '12px',
                } 
            }};

            /* Mapeamento do Tamanho da Fonte */
            --base-font-size: {{ 
                match($company_settings['appearance']['font_size'] ?? 'normal') {
                    'small' => '14px',
                    'large' => '18px',
                    default => '16px',
                } 
            }};
        }

        body {
            font-family: '{{ $company_settings['appearance']['font_family'] ?? 'Inter' }}', sans-serif;
            font-size: var(--base-font-size);
            background-color: {{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? '#0f172a' : '#ffffff' }};
            color: {{ ($company_settings['appearance']['theme'] ?? 'light') == 'dark' ? '#f1f5f9' : '#1e293b' }};
            margin: 0;
            line-height: 1.5;
        }

        /* --- Layouts da Galeria --- */
        .gallery-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat({{ $configs_module['columns'] ?? 3 }}, minmax(0, 1fr));
        }

        .gallery-masonry {
            columns: {{ $configs_module['columns'] ?? 3 }} 250px;
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
            flex: 0 0 calc(100% / {{ ($configs_module['columns'] ?? 3) == 1 ? 1 : ($configs_module['columns'] ?? 3) - 0.5 }});
            scroll-snap-align: start;
            min-width: 250px;
        }

        /* Utilitários */
        .img-container {
            width: 100%;
            overflow: hidden;
            background-color: #f3f4f6;
            border-radius: var(--radius);
        }
        
        .dark .img-container { background-color: #1e293b; }

        #lightbox { display: none; }
        #lightbox.active { display: flex; }
    </style>
</head>
<body class="antialiased">

    <main class="max-w-7xl mx-auto px-6 py-12">
        {{-- Header --}}
        <section class="mb-16 border-b border-gray-200 dark:border-gray-800 pb-10 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black tracking-tight mb-2">
                    Galeria de {{ $company_name ?? 'Empresa' }}
                </h1>
                <p class="text-sm opacity-60 uppercase tracking-widest font-bold">
                    {{ $configs_module['slug'] ?? 'Gallery' }} / {{ $configs_module['layout'] ?? 'Grid' }}
                </p>
            </div>
            <div class="text-right hidden md:block">
                <span class="text-3xl font-light">{{ $photos->count() }}</span>
                <span class="block text-[10px] uppercase font-black opacity-40">Mídias</span>
            </div>
        </section>

        {{-- Galeria --}}
        <div class="gallery-{{ $configs_module['layout'] ?? 'grid' }}">
            @forelse($photos as $index => $photo)
                <div class="group relative cursor-zoom-in shadow-sm hover:shadow-xl transition-all duration-300" 
                     style="border-radius: var(--radius)"
                     onclick="openLightbox({{ $index }})">
                    
                    <div class="img-container" style="aspect-ratio: {{ ($configs_module['layout'] ?? 'grid') === 'masonry' || ($configs_module['image_ratio'] ?? '1:1') === 'auto' ? 'auto' : str_replace(':', '/', $configs_module['image_ratio']) }}">
                        <img src="{{ asset('storage/' . $photo->path) }}" 
                             alt="{{ $photo->alt_text }}" 
                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>

                    {{-- Overlay condicional com Título e Descrição --}}
                    @if(($configs_module['show_titles'] ?? true) || ($configs_module['show_description'] ?? false))
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4" style="border-radius: var(--radius)">
                            @if($configs_module['show_titles'] ?? true)
                                <p class="text-white text-xs font-bold uppercase tracking-wider mb-1">{{ $photo->title }}</p>
                            @endif
                            @if($configs_module['show_description'] ?? false)
                                <p class="text-white/80 text-[10px] line-clamp-2 leading-tight">{{ $photo->description }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                @for($i = 1; $i <= 3; $i++)
                    <div class="img-container border-2 border-dashed border-gray-200 dark:border-gray-800 flex items-center justify-center" 
                         style="aspect-ratio: 1/1">
                        <span class="text-[10px] opacity-30 font-bold uppercase">Espaço Vazio</span>
                    </div>
                @endfor
            @endforelse
        </div>
    </main>

    {{-- Lightbox --}}
    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md flex-col items-center justify-center p-4">
        {{-- Top Bar --}}
        <div class="absolute top-6 left-0 w-full px-8 flex justify-between items-center z-10">
            <div class="text-white/50 text-[10px] font-mono">
                <span id="lb-idx">1</span> / {{ $photos->count() }}
            </div>
            <div class="flex items-center gap-4">
                @if($configs_module['allow_download'] ?? false)
                    <a id="lb-down" href="#" download class="text-white/50 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    </a>
                @endif
                <button onclick="closeLightbox()" class="text-white/50 hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        
        <button onclick="prevImage()" class="absolute left-4 text-white/20 hover:text-white transition-all hidden md:block">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7"/></svg>
        </button>

        <div class="relative flex flex-col items-center max-w-5xl w-full">
            <img id="lightbox-img" src="" class="max-w-full max-h-[75vh] object-contain shadow-2xl">
            <div class="mt-6 text-center">
                <h3 id="lightbox-title" class="text-white text-xl font-bold uppercase tracking-widest"></h3>
                <p id="lightbox-desc" class="text-white/60 text-sm mt-2 max-w-xl mx-auto"></p>
            </div>
        </div>

        <button onclick="nextImage()" class="absolute right-4 text-white/20 hover:text-white transition-all hidden md:block">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    <script>
        let currentIndex = 0;
        
        // Correção do ParseError: Usando json_encode clássico
        const photos = {!! json_encode($photos->map(function($p) {
            return [
                'url' => asset('storage/' . $p->path),
                'title' => $p->title,
                'description' => $p->description
            ];
        })) !!};

        const lb = {
            el: document.getElementById('lightbox'),
            img: document.getElementById('lightbox-img'),
            title: document.getElementById('lightbox-title'),
            desc: document.getElementById('lightbox-desc'),
            idx: document.getElementById('lb-idx'),
            down: document.getElementById('lb-down')
        };

        function openLightbox(index) {
            currentIndex = index;
            updateLightbox();
            lb.el.classList.add('active', 'flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lb.el.classList.remove('active', 'flex');
            document.body.style.overflow = 'auto';
        }

        function updateLightbox() {
            const item = photos[currentIndex];
            lb.img.src = item.url;
            lb.title.innerText = item.title || '';
            lb.desc.innerText = item.description || '';
            lb.idx.innerText = currentIndex + 1;
            if (lb.down) lb.down.href = item.url;
        }

        function nextImage() { currentIndex = (currentIndex + 1) % photos.length; updateLightbox(); }
        function prevImage() { currentIndex = (currentIndex - 1 + photos.length) % photos.length; updateLightbox(); }

        document.addEventListener('keydown', (e) => {
            if (!lb.el.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });

        lb.el.addEventListener('click', (e) => { if (e.target === lb.el) closeLightbox(); });
    </script>
</body>
</html>