@php
    $portfolioLayouts = [
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-8 aspect-[16/9]', 'offset' => '', 'pad' => 'p-12', 'title' => 'text-4xl lg:text-6xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-4 aspect-[3/4]', 'offset' => '', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-4 aspect-[4/5]', 'offset' => 'lg:-mt-24', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-4 aspect-square', 'offset' => '', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-4 aspect-[4/5]', 'offset' => 'lg:mt-12', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-6 aspect-[3/4]', 'offset' => 'lg:-mt-12', 'pad' => 'p-12', 'title' => 'text-4xl lg:text-6xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-6 aspect-square', 'offset' => '', 'pad' => 'p-12', 'title' => 'text-4xl lg:text-6xl'],
        ['class' => 'col-span-12 md:col-span-4 lg:col-span-4 aspect-[4/5]', 'offset' => 'lg:mt-24', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-4 lg:col-span-4 aspect-[3/4]', 'offset' => 'lg:-mt-12', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-4 lg:col-span-4 aspect-square', 'offset' => 'lg:mt-32', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-4 aspect-[4/5]', 'offset' => 'lg:mt-8', 'pad' => 'p-10', 'title' => 'text-4xl'],
        ['class' => 'col-span-12 md:col-span-6 lg:col-span-8 aspect-[21/9]', 'offset' => 'lg:-mt-16', 'pad' => 'p-12', 'title' => 'text-4xl lg:text-7xl'],
    ];
@endphp
<x-layout.public title="Noir/Studio - Expanded Portfolio & Services">
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line" style="top: 5%;"></div>
        <div class="diagonal-line" style="top: 15%; transform: rotate(15deg);"></div>
        <div class="diagonal-line" style="top: 40%; transform: rotate(-5deg);"></div>
        <div class="diagonal-line" style="top: 75%; transform: rotate(10deg);"></div>

        <x-layout.header />

        <main class="relative pt-28 px-6 md:px-12 z-10 pb-24 space-y-24">
            <header>
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12">
                    <div class="max-w-3xl">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-6">Studio Archive v.2.4</span>
                        <h1 class="text-6xl md:text-8xl lg:text-9xl font-display font-black leading-none tracking-tighter uppercase">
                            Selected<br/><span class="font-serif italic capitalize text-zinc-500">Masterpieces</span>
                        </h1>
                        <p class="mt-8 text-zinc-400 font-light max-w-xl text-lg leading-relaxed">
                            Sebuah kurasi visual dari momen-momen paling berpengaruh. Noir/Studio menghadirkan perspektif baru dalam fotografi komersial dan seni murni.
                        </p>
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

            @if ($featuredPortfolios->isNotEmpty())
                <section>
                    <div class="flex items-center space-x-4 mb-12">
                        <div class="w-12 h-[1px] bg-zinc-800"></div>
                        <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-zinc-500">Featured Projects</h2>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-12">
                        @foreach ($featuredPortfolios as $portfolio)
                            @php
                                $excerpt = $portfolio->quote
                                    ?? collect($portfolio->content_sections)->first()['description'] ?? null;
                            @endphp
                            <a href="{{ route('works.show', $portfolio) }}" class="group relative aspect-[16/10] overflow-hidden rounded-sm bg-zinc-900 block">
                                @if ($portfolio->heroImageUrl())
                                    <img
                                        src="{{ $portfolio->heroImageUrl() }}"
                                        alt="{{ $portfolio->title }}"
                                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000"
                                    >
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent p-12 flex flex-col justify-end">
                                    <div class="flex justify-between items-end gap-6">
                                        <div class="space-y-4">
                                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-white/60">
                                                {{ $portfolio->portfolioCategory?->title ?? 'Project' }} / {{ $portfolio->year }}
                                            </span>
                                            <h3 class="text-4xl lg:text-5xl font-display font-black uppercase tracking-tighter">{{ $portfolio->title }}</h3>
                                            @if (filled($excerpt))
                                                <p class="text-zinc-400 max-w-sm text-sm line-clamp-2">{{ Str::limit($excerpt, 120) }}</p>
                                            @endif
                                        </div>
                                        @if (filled($portfolio->client))
                                            <div class="text-right shrink-0">
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

            <section id="portfolio-content" data-works-index data-per-page="6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 border-b border-zinc-900 pb-12">
                    @if ($categories->isNotEmpty())
                        <div class="flex flex-wrap gap-x-8 gap-y-4 text-[10px] font-bold uppercase tracking-[0.2em]" id="category-filters">
                            <button type="button" class="filter-btn active hover:text-white" data-category="all">All Work</button>
                            @foreach ($categories as $category)
                                <button type="button" class="filter-btn text-zinc-500 hover:text-white" data-category="{{ $category->category_id }}">
                                    {{ $category->title }}
                                </button>
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

                @if ($gridPortfolios->isNotEmpty())
                    <div class="portfolio-grid" id="portfolio-grid">
                        @foreach ($gridPortfolios as $index => $portfolio)
                            @php
                                $layout = $portfolioLayouts[$index % count($portfolioLayouts)];
                            @endphp
                            <a
                                href="{{ route('works.show', $portfolio) }}"
                                class="project-card portfolio-item group relative overflow-hidden bg-zinc-900 {{ $layout['class'] }} {{ $layout['offset'] }}"
                                data-category="{{ $portfolio->category_id ?? 'uncategorized' }}"
                                data-year="{{ $portfolio->year }}"
                                data-title="{{ strtolower($portfolio->title) }}"
                            >
                                @if ($portfolio->heroImageUrl())
                                    <img
                                        src="{{ $portfolio->heroImageUrl() }}"
                                        alt="{{ $portfolio->title }}"
                                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000"
                                    >
                                @endif
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end {{ $layout['pad'] }}">
                                    <div class="overlay-text">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="text-xs font-bold uppercase tracking-[0.3em] text-zinc-400">
                                                {{ $portfolio->portfolioCategory?->title ?? 'Project' }}
                                            </span>
                                            <span class="text-xs text-zinc-500">{{ $portfolio->year }}</span>
                                        </div>
                                        <h3 class="{{ $layout['title'] }} font-display font-black uppercase tracking-tighter">{{ $portfolio->title }}</h3>
                                        @if (filled($portfolio->client))
                                            <p class="text-sm text-zinc-400 mt-4">Client: {{ $portfolio->client }}</p>
                                        @elseif (filled($portfolio->location))
                                            <p class="text-sm text-zinc-400 mt-4">{{ $portfolio->location }}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if ($gridPortfolios->count() > 6)
                        <div class="mt-10 text-center">
                            <button type="button" id="load-more-btn" class="px-12 py-5 border border-zinc-800 text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all duration-500">
                                Load More Projects
                            </button>
                        </div>
                    @endif
                @elseif ($portfolios->isEmpty())
                    <div class="text-center py-24 border border-zinc-900 rounded-sm">
                        <iconify-icon icon="lucide:image-off" class="text-4xl text-zinc-700 mb-6"></iconify-icon>
                        <h3 class="text-2xl font-display font-black uppercase mb-2">No Published Projects Yet</h3>
                        <p class="text-zinc-500 text-sm max-w-md mx-auto">Portfolio akan muncul di sini setelah dipublikasikan dari dashboard.</p>
                    </div>
                @else
                    <p class="text-center text-zinc-500 text-sm py-12">Semua proyek ditampilkan di bagian Featured di atas.</p>
                @endif
            </section>

            <section class="py-16 border-t border-zinc-900">
                <div class="container mx-auto">
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

            <div class="text-center">
                <a href="{{ route('contact') }}" class="inline-flex flex-col items-center group">
                    <span class="text-[10px] font-bold uppercase tracking-[0.4em] mb-4 text-zinc-500">Ready to work together?</span>
                    <span class="text-4xl md:text-6xl font-display font-black uppercase border-b-2 border-zinc-800 pb-2 group-hover:text-zinc-400 group-hover:border-zinc-500 transition-all">Start a Commission</span>
                </a>
            </div>
        </main>

        <x-layout.footer />
    </div>
</x-layout.public>
