@php
    $articlesPayload = $jurnals->map(fn ($jurnal) => [
        'id' => $jurnal->id,
        'url' => route('journal.show', $jurnal),
        'title' => $jurnal->title,
        'description' => $jurnal->description,
        'thumbnail' => $jurnal->thumbnailUrl(),
        'date' => $jurnal->created_at->format('F j, Y'),
        'dateShort' => $jurnal->created_at->format('M d'),
        'readTime' => $jurnal->readingTimeMinutes(),
        'category' => $jurnal->jurnalCategory?->title,
        'categoryId' => $jurnal->category_id ?? 'uncategorized',
        'author' => $jurnal->user?->name,
        'search' => strtolower($jurnal->title.' '.($jurnal->description ?? '')),
        'timestamp' => $jurnal->created_at->timestamp,
    ])->values();
@endphp
<x-layout.public title="Noir/Studio - Journal">
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line" style="top: 15%"></div>
        <div class="diagonal-line" style="top: 45%"></div>
        <div class="diagonal-line" style="top: 75%"></div>

        <x-layout.header />

        <main class="relative z-10">
            <header class="pt-28 px-6 md:px-12 pb-24 border-b border-zinc-900">
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
                <section class="py-24 px-6 md:px-12" id="journal-content" data-journal-index>
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
                        <div class="col-span-12 lg:col-span-8 article-featured hidden" id="featured-slot"></div>

                        <div class="col-span-12 lg:col-span-4 lg:pl-12 space-y-24 article-pinned-column hidden" id="pinned-slot">
                            <h3 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-12">Pinned Stories</h3>
                            <div id="pinned-items" class="space-y-24"></div>
                        </div>

                        <div class="col-span-12 mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16" id="journal-grid"></div>
                    </div>

                    <x-ui.pagination
                        id="journal-pagination"
                        data-scroll-target="#journal-content"
                        data-per-page="9"
                        :manual="true"
                    />

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
        <script type="application/json" id="journal-articles-data">@json($articlesPayload)</script>
    @endif
</x-layout.public>
