@php
    $placeholderImage = 'https://images.unsplash.com/photo-1509460913899-515f1df34fed?auto=format&fit=crop&q=80&w=1600';
    $featuredJurnal = $jurnals->first();
    $pinnedJurnals = $jurnals->skip(1)->take(2);
    $gridJurnals = $jurnals->skip(3);
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
        .font-display { font-family: 'Cabinet Grotesk', sans-serif; }
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .asymmetric-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .diagonal-line {
            position: absolute;
            width: 150%;
            height: 1px;
            background: rgba(245, 242, 237, 0.05);
            transform: rotate(-15deg);
            left: -25%;
            z-index: 0;
            pointer-events: none;
        }
        .marquee-text {
            white-space: nowrap;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .article-card:hover .article-image {
            transform: scale(1.05);
            filter: grayscale(0%);
        }
        .article-image {
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            filter: grayscale(100%);
        }
        .filter-btn {
            position: relative;
            transition: all 0.3s ease;
        }
        .filter-btn.active {
            color: #f5f2ed;
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
        .article-hidden { display: none !important; }
    </style>
    <title>Noir/Studio - Journal</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line" style="top: 15%"></div>
        <div class="diagonal-line" style="top: 45%"></div>
        <div class="diagonal-line" style="top: 75%"></div>

        <x-layout.header />

        <main class="relative z-10">
            <header class="pt-48 px-6 md:px-12 pb-24 border-b border-zinc-900">
                <div class="asymmetric-grid max-w-7xl mx-auto">
                    <div class="col-span-12 lg:col-span-7">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-6">Studio Journal & Insights</span>
                        <h1 class="text-5xl md:text-7xl lg:text-9xl font-display font-black leading-[0.8] tracking-tighter uppercase mb-8">
                            Selected<br/><span class="font-serif italic capitalize text-zinc-500">Writings</span>
                        </h1>
                        <p class="text-zinc-500 font-light leading-relaxed max-w-xl text-lg">
                            A curated collection of thoughts on light, shadow, and the human narrative. Exploring the intersection of fine art and technical mastery through the lens of a visionary.
                        </p>
                    </div>
                    <div class="col-span-12 lg:col-span-5 flex flex-col justify-end lg:items-end mt-12 lg:mt-0">
                        <div class="w-full max-w-md">
                            <div class="relative flex items-center mb-8">
                                <input
                                    type="text"
                                    id="journal-search"
                                    placeholder="Search articles..."
                                    class="w-full bg-zinc-900/50 border border-zinc-800 p-4 text-xs outline-none focus:border-zinc-700 transition-colors uppercase tracking-widest text-[#f5f2ed]"
                                >
                                <iconify-icon icon="lucide:search" class="absolute right-4 text-zinc-500 text-lg"></iconify-icon>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex space-x-4 items-center">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-600">Sort by:</span>
                                    <select id="journal-sort" class="bg-transparent text-[10px] font-bold uppercase tracking-widest text-zinc-400 outline-none cursor-pointer hover:text-white transition-colors">
                                        <option value="latest" class="bg-zinc-900">Latest</option>
                                        <option value="oldest" class="bg-zinc-900">Oldest</option>
                                        <option value="title" class="bg-zinc-900">Title A–Z</option>
                                    </select>
                                </div>
                                <div class="text-[10px] font-bold uppercase tracking-widest text-zinc-600">
                                    <span id="article-count">{{ $totalArticles }}</span> Articles
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            @if ($jurnals->isEmpty())
                <section class="py-32 px-6 md:px-12 text-center">
                    <iconify-icon icon="lucide:book-open" class="text-5xl text-zinc-700 mb-6"></iconify-icon>
                    <h2 class="text-2xl font-display font-black uppercase mb-4">No stories yet</h2>
                    <p class="text-zinc-500 text-sm max-w-md mx-auto">Published journal articles will appear here once they are live.</p>
                </section>
            @else
                <section class="py-24 px-6 md:px-12">
                    @if ($categories->isNotEmpty())
                        <div class="flex flex-wrap gap-6 md:gap-8 text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500 mb-20 border-b border-zinc-900 pb-8" id="category-filters">
                            <button type="button" class="filter-btn active" data-category="all">All</button>
                            @foreach ($categories as $category)
                                <button type="button" class="filter-btn hover:text-white" data-category="{{ $category->category_id }}">
                                    {{ $category->title }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <div class="asymmetric-grid gap-y-32 max-w-7xl mx-auto" id="journal-layout">
                        @if ($featuredJurnal)
                            <div class="col-span-12 lg:col-span-8 article-item article-featured" id="featured-slot"
                                data-category="{{ $featuredJurnal->category_id ?? 'uncategorized' }}"
                                data-title="{{ strtolower($featuredJurnal->title) }}"
                                data-search="{{ strtolower($featuredJurnal->title.' '.($featuredJurnal->description ?? '')) }}"
                                data-timestamp="{{ $featuredJurnal->created_at->timestamp }}"
                                data-id="{{ $featuredJurnal->id }}">
                                <a href="{{ route('journal.show', $featuredJurnal) }}" class="group block article-card">
                                    <div class="aspect-[16/9] overflow-hidden bg-zinc-900 mb-8 rounded-sm">
                                        <img
                                            src="{{ $featuredJurnal->thumbnailUrl() ?? $placeholderImage }}"
                                            alt="{{ $featuredJurnal->title }}"
                                            class="article-image w-full h-full object-cover"
                                        >
                                    </div>
                                    <div class="flex justify-between items-start mb-6 gap-4">
                                        <div class="flex flex-wrap gap-x-6 gap-y-2 text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                                            <span>{{ $featuredJurnal->created_at->format('F j, Y') }}</span>
                                            <span>{{ $featuredJurnal->readingTimeMinutes() }} Min Read</span>
                                            <span class="text-zinc-300">{{ $featuredJurnal->jurnalCategory?->title ?? 'Journal' }}</span>
                                        </div>
                                        <div class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center shrink-0 group-hover:bg-white group-hover:border-white transition-all duration-500">
                                            <iconify-icon icon="lucide:arrow-up-right" class="text-xl group-hover:text-black"></iconify-icon>
                                        </div>
                                    </div>
                                    <h2 class="text-4xl md:text-5xl lg:text-7xl font-display font-black uppercase tracking-tighter leading-none mb-6 group-hover:text-zinc-300 transition-colors">
                                        {{ $featuredJurnal->title }}
                                    </h2>
                                    @if (filled($featuredJurnal->description))
                                        <p class="text-zinc-500 text-lg font-light leading-relaxed max-w-3xl mb-8">{{ $featuredJurnal->description }}</p>
                                    @endif
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center">
                                            <iconify-icon icon="lucide:user" class="text-zinc-600"></iconify-icon>
                                        </div>
                                        <span class="text-xs font-bold uppercase tracking-widest">By {{ $featuredJurnal->user?->name ?? 'Noir Studio' }}</span>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if ($pinnedJurnals->isNotEmpty())
                            <div class="col-span-12 lg:col-span-4 lg:pl-12 space-y-24 article-pinned-column" id="pinned-slot">
                                <h3 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-12">Pinned Stories</h3>
                                @foreach ($pinnedJurnals as $pinned)
                                    <div class="article-item article-pinned"
                                        data-category="{{ $pinned->category_id ?? 'uncategorized' }}"
                                        data-title="{{ strtolower($pinned->title) }}"
                                        data-search="{{ strtolower($pinned->title.' '.($pinned->description ?? '')) }}"
                                        data-timestamp="{{ $pinned->created_at->timestamp }}"
                                        data-id="{{ $pinned->id }}">
                                        <a href="{{ route('journal.show', $pinned) }}" class="group block article-card">
                                            <div class="aspect-square overflow-hidden bg-zinc-900 mb-6 rounded-sm">
                                                <img
                                                    src="{{ $pinned->thumbnailUrl() ?? $placeholderImage }}"
                                                    alt="{{ $pinned->title }}"
                                                    class="article-image w-full h-full object-cover"
                                                >
                                            </div>
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-300 block mb-3">
                                                {{ $pinned->jurnalCategory?->title ?? 'Journal' }}
                                            </span>
                                            <h4 class="text-2xl font-display font-black uppercase tracking-tight mb-4 group-hover:text-zinc-400 transition-colors">{{ $pinned->title }}</h4>
                                            @if (filled($pinned->description))
                                                <p class="text-xs text-zinc-500 font-light leading-relaxed line-clamp-2">{{ $pinned->description }}</p>
                                            @endif
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="col-span-12 mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16" id="journal-grid">
                            @foreach ($gridJurnals as $index => $jurnal)
                                <div @class([
                                    'article-item article-grid',
                                    'lg:mt-24' => $index % 3 === 1,
                                    'lg:-mt-24' => $index % 3 === 2,
                                ])
                                    data-category="{{ $jurnal->category_id ?? 'uncategorized' }}"
                                    data-title="{{ strtolower($jurnal->title) }}"
                                    data-search="{{ strtolower($jurnal->title.' '.($jurnal->description ?? '')) }}"
                                    data-timestamp="{{ $jurnal->created_at->timestamp }}"
                                    data-id="{{ $jurnal->id }}"
                                    data-page="{{ (int) floor($index / 6) + 1 }}">
                                    <a href="{{ route('journal.show', $jurnal) }}" class="group article-card block">
                                        <div class="aspect-[4/5] overflow-hidden bg-zinc-900 mb-8 rounded-sm">
                                            <img
                                                src="{{ $jurnal->thumbnailUrl() ?? $placeholderImage }}"
                                                alt="{{ $jurnal->title }}"
                                                class="article-image w-full h-full object-cover"
                                            >
                                        </div>
                                        <div class="flex space-x-4 text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-4">
                                            <span>{{ $jurnal->created_at->format('M d') }}</span>
                                            <span>{{ $jurnal->readingTimeMinutes() }} Min</span>
                                        </div>
                                        <h3 class="text-3xl font-display font-black uppercase mb-4 leading-tight group-hover:text-zinc-300 transition-colors">{{ $jurnal->title }}</h3>
                                        @if (filled($jurnal->description))
                                            <p class="text-sm text-zinc-500 font-light leading-relaxed mb-6 line-clamp-3">{{ $jurnal->description }}</p>
                                        @endif
                                        <span class="text-[10px] font-bold uppercase text-zinc-400">Read Article</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if ($gridJurnals->count() > 6)
                        <div class="mt-32 flex justify-center items-center space-x-6 pb-8" id="journal-pagination">
                            <button type="button" id="page-prev" class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center text-zinc-600 hover:border-white hover:text-white transition-all">
                                <iconify-icon icon="lucide:chevron-left"></iconify-icon>
                            </button>
                            <div class="flex space-x-4 text-xs font-bold uppercase tracking-widest" id="page-numbers"></div>
                            <button type="button" id="page-next" class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center text-zinc-600 hover:border-white hover:text-white transition-all">
                                <iconify-icon icon="lucide:chevron-right"></iconify-icon>
                            </button>
                        </div>
                    @endif

                    <p id="no-results" class="hidden text-center text-zinc-500 text-sm py-24">No articles match your search or filter.</p>
                </section>
            @endif

            <div class="py-24 border-t border-zinc-900 overflow-hidden">
                <div class="marquee-text flex space-x-24 items-center">
                    <span class="text-5xl md:text-7xl font-display font-black text-transparent uppercase" style="-webkit-text-stroke: 1px #27272a;">Journal</span>
                    <span class="text-5xl md:text-7xl font-display font-black uppercase">Insights</span>
                    <span class="text-5xl md:text-7xl font-display font-black text-transparent uppercase" style="-webkit-text-stroke: 1px #27272a;">Technique</span>
                    <span class="text-5xl md:text-7xl font-display font-black uppercase">Inspiration</span>
                    <span class="text-5xl md:text-7xl font-display font-black text-transparent uppercase" style="-webkit-text-stroke: 1px #27272a;">Archive</span>
                    <span class="text-5xl md:text-7xl font-display font-black uppercase">Stories</span>
                    <span class="text-5xl md:text-7xl font-display font-black text-transparent uppercase" style="-webkit-text-stroke: 1px #27272a;">Process</span>
                    <span class="text-5xl md:text-7xl font-display font-black uppercase">Vision</span>
                    <span class="text-5xl md:text-7xl font-display font-black text-transparent uppercase" style="-webkit-text-stroke: 1px #27272a;">Journal</span>
                    <span class="text-5xl md:text-7xl font-display font-black uppercase">Insights</span>
                </div>
            </div>
        </main>

        <x-layout.footer />
    </div>

    @if ($jurnals->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const searchInput = document.getElementById('journal-search');
                const sortSelect = document.getElementById('journal-sort');
                const filterButtons = document.querySelectorAll('#category-filters .filter-btn');
                const gridItems = Array.from(document.querySelectorAll('.article-grid'));
                const noResults = document.getElementById('no-results');
                const articleCount = document.getElementById('article-count');
                const grid = document.getElementById('journal-grid');
                const perPage = 6;
                let activeCategory = 'all';
                let currentPage = 1;
                let searchQuery = '';

                const getVisibleGridItems = () => {
                    return gridItems.filter((item) => {
                        const matchesCategory = activeCategory === 'all' || item.dataset.category === activeCategory;
                        const matchesSearch = !searchQuery || item.dataset.search.includes(searchQuery);

                        return matchesCategory && matchesSearch;
                    });
                };

                const sortGridItems = () => {
                    if (!grid) {
                        return;
                    }

                    const sortBy = sortSelect?.value ?? 'latest';
                    const sorted = [...gridItems].sort((a, b) => {
                        if (sortBy === 'latest') {
                            return Number(b.dataset.timestamp) - Number(a.dataset.timestamp);
                        }

                        if (sortBy === 'oldest') {
                            return Number(a.dataset.timestamp) - Number(b.dataset.timestamp);
                        }

                        return a.dataset.title.localeCompare(b.dataset.title);
                    });

                    sorted.forEach((item) => grid.appendChild(item));
                };

                const renderPagination = (totalPages) => {
                    const pageNumbers = document.getElementById('page-numbers');
                    const pagination = document.getElementById('journal-pagination');

                    if (!pageNumbers || !pagination) {
                        return;
                    }

                    pagination.classList.toggle('hidden', totalPages <= 1);
                    pageNumbers.innerHTML = '';

                    for (let page = 1; page <= totalPages; page++) {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.textContent = String(page).padStart(2, '0');
                        button.className = page === currentPage
                            ? 'w-10 h-10 flex items-center justify-center border-b-2 border-white'
                            : 'w-10 h-10 flex items-center justify-center text-zinc-600 hover:text-white';
                        button.addEventListener('click', () => {
                            currentPage = page;
                            applyFilters();
                        });
                        pageNumbers.appendChild(button);
                    }
                };

                const applyFilters = () => {
                    const visibleItems = getVisibleGridItems();
                    const totalPages = Math.max(1, Math.ceil(visibleItems.length / perPage));

                    if (currentPage > totalPages) {
                        currentPage = totalPages;
                    }

                    gridItems.forEach((item) => item.classList.add('article-hidden'));

                    visibleItems.forEach((item, index) => {
                        const page = Math.floor(index / perPage) + 1;

                        if (page === currentPage) {
                            item.classList.remove('article-hidden');
                        }
                    });

                    if (articleCount) {
                        const featuredCount = document.querySelectorAll('.article-featured, .article-pinned').length;
                        articleCount.textContent = String(visibleItems.length + featuredCount);
                    }

                    if (noResults) {
                        noResults.classList.toggle('hidden', visibleItems.length > 0 || activeCategory === 'all');
                    }

                    renderPagination(totalPages);
                };

                filterButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        filterButtons.forEach((btn) => btn.classList.remove('active'));
                        button.classList.add('active');
                        activeCategory = button.dataset.category;
                        currentPage = 1;
                        applyFilters();
                    });
                });

                searchInput?.addEventListener('input', () => {
                    searchQuery = searchInput.value.trim().toLowerCase();
                    currentPage = 1;
                    applyFilters();
                });

                sortSelect?.addEventListener('change', () => {
                    sortGridItems();
                    currentPage = 1;
                    applyFilters();
                });

                document.getElementById('page-prev')?.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        applyFilters();
                    }
                });

                document.getElementById('page-next')?.addEventListener('click', () => {
                    const totalPages = Math.max(1, Math.ceil(getVisibleGridItems().length / perPage));

                    if (currentPage < totalPages) {
                        currentPage++;
                        applyFilters();
                    }
                });

                sortGridItems();
                applyFilters();
            });
        </script>
    @endif
</body>
</html>
