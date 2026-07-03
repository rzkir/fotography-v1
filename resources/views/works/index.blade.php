@php
    $placeholderImage = 'https://images.unsplash.com/photo-1509460913899-515f1df34fed?auto=format&fit=crop&q=80&w=1600';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300;1,600&family=Epilogue:wght@700;900&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @import url('https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@800,900&f[]=satoshi@400,700&display=swap');
        :root {
            --bg-color: #0d0d0d;
            --accent-color: #f5f2ed;
        }
        body {
            background-color: var(--bg-color);
            color: var(--accent-color);
            font-family: 'Satoshi', sans-serif;
            overflow-x: hidden;
        }
        .font-display {
            font-family: 'Cabinet Grotesk', sans-serif;
        }
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }
        .diagonal-line {
            position: absolute;
            width: 150%;
            height: 1px;
            background: rgba(245, 242, 237, 0.1);
            transform: rotate(-15deg);
            z-index: 0;
            pointer-events: none;
        }
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 32px;
        }
        .project-card {
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .project-card:hover {
            transform: translateY(-8px);
        }
        .project-card:hover .overlay-text {
            opacity: 1;
            transform: translateY(0);
        }
        .filter-btn {
            position: relative;
            transition: all 0.3s ease;
        }
        .filter-btn.active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: #f5f2ed;
        }
        .price-card {
            border: 1px solid #e5e5e5;
            background: #ffffff;
            transition: all 0.4s ease;
        }
        .price-card:hover {
            border-color: #d4d4d8;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .portfolio-item.hidden-by-filter,
        .portfolio-item.hidden-by-load-more {
            display: none;
        }
    </style>
    <title>Noir/Studio - Works & Services</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line" style="top: 5%;"></div>
        <div class="diagonal-line" style="top: 15%; transform: rotate(15deg);"></div>
        <div class="diagonal-line" style="top: 40%; transform: rotate(-5deg);"></div>
        <div class="diagonal-line" style="top: 75%; transform: rotate(10deg);"></div>

        <x-layout.header />

        <main class="relative pt-48 px-6 md:px-12 lg:px-20 z-10 pb-32">
            <header class="mb-32">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12">
                    <div class="max-w-3xl">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-6">Studio Archive v.2.4</span>
                        <h1 class="text-6xl md:text-8xl lg:text-9xl font-display font-black leading-none tracking-tighter uppercase">Selected<br/><span class="font-serif italic capitalize text-zinc-500">Masterpieces</span></h1>
                        <p class="mt-8 text-zinc-400 font-light max-w-xl text-lg leading-relaxed">Sebuah kurasi visual dari momen-momen paling berpengaruh. Noir/Studio menghadirkan perspektif baru dalam fotografi komersial dan seni murni.</p>
                    </div>
                    <div class="hidden lg:block pb-4">
                        <div class="flex space-x-12">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-zinc-600 uppercase tracking-widest">Total Projects</span>
                                <span class="text-2xl font-bold">{{ $totalProjects }}{{ $totalProjects >= 100 ? '+' : '' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] text-zinc-600 uppercase tracking-widest">Locations</span>
                                <span class="text-2xl font-bold">{{ $uniqueLocations > 0 ? $uniqueLocations : '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            @if($featuredPortfolios->isNotEmpty())
                <section class="mb-40">
                    <div class="flex items-center space-x-4 mb-12">
                        <div class="w-12 h-[1px] bg-zinc-800"></div>
                        <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-zinc-500">Featured Projects</h2>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-12">
                        @foreach($featuredPortfolios as $portfolio)
                            @php
                                $excerpt = $portfolio->quote
                                    ?? collect($portfolio->content_sections)->first()['description'] ?? null;
                            @endphp
                            <a href="{{ route('works.show', $portfolio) }}" class="group relative aspect-[16/10] overflow-hidden rounded-sm bg-zinc-900 block">
                                <img
                                    src="{{ $portfolio->heroImageUrl() ?? $placeholderImage }}"
                                    alt="{{ $portfolio->title }}"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent p-12 flex flex-col justify-end">
                                    <div class="flex justify-between items-end">
                                        <div class="space-y-4">
                                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-white/60">
                                                {{ $portfolio->portfolioCategory?->title ?? 'Project' }} / {{ $portfolio->year }}
                                            </span>
                                            <h3 class="text-4xl lg:text-5xl font-display font-black uppercase tracking-tighter">{{ $portfolio->title }}</h3>
                                            @if(filled($excerpt))
                                                <p class="text-zinc-400 max-w-sm text-sm line-clamp-2">{{ Str::limit($excerpt, 120) }}</p>
                                            @endif
                                        </div>
                                        @if(filled($portfolio->client))
                                            <div class="text-right">
                                                <span class="block text-[10px] text-zinc-500 uppercase">Client</span>
                                                <span class="font-bold">{{ $portfolio->client }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($categories->isNotEmpty())
                <section class="mb-20 bg-zinc-900/50 py-20 px-6 md:px-12 border-y border-zinc-900">
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
                        @foreach($categories as $category)
                            <div class="space-y-4">
                                <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-200">{{ $category->title }}</h4>
                                <p class="text-sm text-zinc-500 leading-relaxed">
                                    {{ $category->published_count }} {{ Str::plural('project', $category->published_count) }} dalam kategori ini.
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="mb-24">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 border-b border-zinc-900 pb-12 mb-16">
                    @if($categories->isNotEmpty())
                        <div class="flex flex-wrap gap-x-8 gap-y-4 text-[10px] font-bold uppercase tracking-[0.2em]" id="category-filters">
                            <button type="button" class="filter-btn active hover:text-white" data-category="all">All Work</button>
                            @foreach($categories as $category)
                                <button type="button" class="filter-btn text-zinc-500 hover:text-white" data-category="{{ $category->category_id }}">{{ $category->title }}</button>
                            @endforeach
                        </div>
                    @endif
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-3">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-600">Sort By</span>
                            <select id="sort-select" class="bg-transparent border-none text-[10px] font-bold uppercase tracking-widest text-white outline-none cursor-pointer">
                                <option value="latest" class="bg-zinc-900">Latest</option>
                                <option value="oldest" class="bg-zinc-900">Oldest</option>
                                <option value="title" class="bg-zinc-900">Title A–Z</option>
                            </select>
                        </div>
                    </div>
                </div>

                @if($gridPortfolios->isNotEmpty())
                    <div class="portfolio-grid" id="portfolio-grid">
                        @foreach($gridPortfolios as $index => $portfolio)
                            <a
                                href="{{ route('works.show', $portfolio) }}"
                                class="project-card portfolio-item group relative overflow-hidden bg-zinc-900 {{ $index % 2 === 0 ? 'col-span-12 md:col-span-6 lg:col-span-8 aspect-[16/9]' : 'col-span-12 md:col-span-6 lg:col-span-4 aspect-[3/4]' }}"
                                data-category="{{ $portfolio->category_id ?? 'uncategorized' }}"
                                data-year="{{ $portfolio->year }}"
                                data-title="{{ strtolower($portfolio->title) }}"
                                data-index="{{ $index }}"
                            >
                                <img
                                    src="{{ $portfolio->heroImageUrl() ?? $placeholderImage }}"
                                    alt="{{ $portfolio->title }}"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000"
                                >
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end {{ $index % 2 === 0 ? 'p-12' : 'p-10' }}">
                                    <div class="overlay-text opacity-0 transform translate-y-4 transition-all duration-500">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-zinc-400">
                                                {{ $portfolio->portfolioCategory?->title ?? 'Project' }}
                                            </span>
                                            <span class="text-xs text-zinc-500">{{ $portfolio->year }}</span>
                                        </div>
                                        <h3 class="{{ $index % 2 === 0 ? 'text-4xl lg:text-6xl' : 'text-4xl' }} font-display font-black uppercase tracking-tighter">{{ $portfolio->title }}</h3>
                                        @if(filled($portfolio->client))
                                            <p class="text-sm text-zinc-400 mt-4">Client: {{ $portfolio->client }}</p>
                                        @elseif(filled($portfolio->location))
                                            <p class="text-sm text-zinc-400 mt-4">{{ $portfolio->location }}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if($gridPortfolios->count() > 4)
                        <div class="mt-24 text-center">
                            <button type="button" id="load-more-btn" class="px-12 py-5 border border-zinc-800 text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all duration-500">
                                Load More Projects
                            </button>
                        </div>
                    @endif
                @elseif($portfolios->isEmpty())
                    <div class="text-center py-24 border border-zinc-900 rounded-sm">
                        <iconify-icon icon="lucide:image-off" class="text-4xl text-zinc-700 mb-6"></iconify-icon>
                        <h3 class="text-2xl font-display font-black uppercase mb-2">No Published Projects Yet</h3>
                        <p class="text-zinc-500 text-sm max-w-md mx-auto">Portfolio akan muncul di sini setelah dipublikasikan dari dashboard.</p>
                    </div>
                @else
                    <p class="text-center text-zinc-500 text-sm py-12">Semua proyek ditampilkan di bagian Featured di atas.</p>
                @endif
            </section>

            <section class="py-40 bg-white text-black">
                <div class="max-w-7xl mx-auto px-6 md:px-12">
                    <div class="mb-24 text-center">
                        <span class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 block mb-6">Investment & Value</span>
                        <h2 class="text-6xl md:text-8xl font-display font-black tracking-tighter uppercase">Pricing Tiers</h2>
                    </div>
                    <div class="grid md:grid-cols-3 gap-12">
                        <div class="price-card p-12 flex flex-col justify-between h-full rounded-sm bg-white border border-zinc-200">
                            <div class="space-y-8">
                                <div>
                                    <h4 class="text-xs font-bold uppercase tracking-[0.3em] mb-4 text-zinc-600">Essential</h4>
                                    <span class="text-5xl font-display font-black tracking-tighter text-black">$450</span>
                                </div>
                                <ul class="space-y-4 text-sm text-zinc-500">
                                    <li>— 2 Hours Session</li>
                                    <li>— 1 Local Location</li>
                                    <li>— 15 High-End Edits</li>
                                    <li>— Online Gallery Access</li>
                                </ul>
                            </div>
                            <a href="/contact" class="mt-12 w-full py-4 border border-black text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-black hover:text-white transition-all text-center block">Request Booking</a>
                        </div>

                        <div class="price-card p-12 flex flex-col justify-between h-full border-2 border-black rounded-sm" style="background: #f8f8f8;">
                            <div class="space-y-8">
                                <div>
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="text-xs font-bold uppercase tracking-[0.3em] text-black">Editorial</h4>
                                        <span class="bg-black text-white px-3 py-1 text-[8px] font-bold uppercase">Popular</span>
                                    </div>
                                    <span class="text-5xl font-display font-black tracking-tighter text-black">$850</span>
                                </div>
                                <ul class="space-y-4 text-sm text-zinc-600">
                                    <li>— 4 Hours Session</li>
                                    <li>— Studio + Location</li>
                                    <li>— 40 High-End Edits</li>
                                    <li>— Full Wardrobe Assistance</li>
                                    <li>— 48h Preview Access</li>
                                </ul>
                            </div>
                            <a href="/contact" class="mt-12 w-full py-4 bg-black text-white text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-zinc-800 transition-all text-center block">Request Booking</a>
                        </div>

                        <div class="price-card p-12 flex flex-col justify-between h-full rounded-sm bg-white border border-zinc-200">
                            <div class="space-y-8">
                                <div>
                                    <h4 class="text-xs font-bold uppercase tracking-[0.3em] mb-4 text-zinc-600">Premium</h4>
                                    <span class="text-5xl font-display font-black tracking-tighter italic font-serif capitalize text-black">Custom</span>
                                </div>
                                <ul class="space-y-4 text-sm text-zinc-500">
                                    <li>— Multi-Day Session</li>
                                    <li>— Global Locations</li>
                                    <li>— Unlimited Edits</li>
                                    <li>— Creative Direction Team</li>
                                    <li>— Physical Print Box</li>
                                </ul>
                            </div>
                            <a href="/contact" class="mt-12 w-full py-4 border border-black text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-black hover:text-white transition-all text-center block">Inquire Now</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-40 border-t border-zinc-900">
                <div class="max-w-7xl mx-auto px-6 md:px-12">
                    <div class="grid lg:grid-cols-12 gap-24">
                        <div class="lg:col-span-5">
                            <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-8">The Workflow</span>
                            <h2 class="text-6xl font-display font-black leading-none tracking-tighter uppercase mb-12">Commission<br/>Process</h2>
                            <p class="font-serif italic text-2xl text-zinc-400">Sebuah perjalanan kolaboratif untuk mencapai keunggulan visual.</p>
                        </div>
                        <div class="lg:col-span-7">
                            <div class="space-y-20">
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">01</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">Discovery & Concept</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Konsultasi awal untuk memahami visi, tujuan brand, dan moodboard proyek Anda.</p>
                                    </div>
                                </div>
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">02</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">Pre-Production</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Penentuan lokasi, pemilihan talent, dan teknis pencahayaan yang disesuaikan dengan konsep.</p>
                                    </div>
                                </div>
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">03</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">The Session</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Eksekusi kreatif di set dengan arahan yang presisi untuk hasil terbaik.</p>
                                    </div>
                                </div>
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">04</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">Mastering</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Proses kurasi dan color grading profesional untuk mencapai estetika signature Noir/Studio.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-32 text-center pb-40">
                <a href="/contact" class="inline-flex flex-col items-center group">
                    <span class="text-[10px] font-bold uppercase tracking-[0.4em] mb-4 text-zinc-500">Ready to work together?</span>
                    <span class="text-4xl md:text-6xl font-display font-black uppercase border-b-2 border-zinc-800 pb-2 group-hover:text-zinc-400 group-hover:border-zinc-500 transition-all">Start a Commission</span>
                </a>
            </div>
        </main>

        <x-layout.footer />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const grid = document.getElementById('portfolio-grid');
            const loadMoreBtn = document.getElementById('load-more-btn');
            const sortSelect = document.getElementById('sort-select');
            const filterButtons = document.querySelectorAll('#category-filters .filter-btn');
            const perPage = 4;
            let visibleCount = perPage;
            let activeCategory = 'all';

            const getItems = () => Array.from(grid?.querySelectorAll('.portfolio-item') ?? []);

            const applyFilters = () => {
                const items = getItems();
                let shown = 0;

                items.forEach((item) => {
                    const matchesCategory = activeCategory === 'all' || item.dataset.category === activeCategory;
                    const withinLimit = shown < visibleCount;

                    if (matchesCategory && withinLimit) {
                        item.classList.remove('hidden-by-filter', 'hidden-by-load-more');
                        shown++;
                    } else if (!matchesCategory) {
                        item.classList.add('hidden-by-filter');
                        item.classList.remove('hidden-by-load-more');
                    } else {
                        item.classList.remove('hidden-by-filter');
                        item.classList.add('hidden-by-load-more');
                    }
                });

                if (loadMoreBtn) {
                    const totalMatching = items.filter((item) => activeCategory === 'all' || item.dataset.category === activeCategory).length;
                    loadMoreBtn.classList.toggle('hidden', shown >= totalMatching);
                }
            };

            const sortItems = () => {
                if (!grid) return;

                const items = getItems();
                const sortBy = sortSelect?.value ?? 'latest';

                items.sort((a, b) => {
                    if (sortBy === 'latest') return Number(b.dataset.year) - Number(a.dataset.year);
                    if (sortBy === 'oldest') return Number(a.dataset.year) - Number(b.dataset.year);
                    return a.dataset.title.localeCompare(b.dataset.title);
                });

                items.forEach((item) => grid.appendChild(item));
            };

            filterButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    filterButtons.forEach((btn) => btn.classList.remove('active'));
                    button.classList.add('active');
                    activeCategory = button.dataset.category;
                    visibleCount = perPage;
                    applyFilters();
                });
            });

            sortSelect?.addEventListener('change', () => {
                sortItems();
                applyFilters();
            });

            loadMoreBtn?.addEventListener('click', () => {
                visibleCount += perPage;
                applyFilters();
            });

            if (grid) {
                sortItems();
                applyFilters();
            }
        });
    </script>
</body>
</html>
