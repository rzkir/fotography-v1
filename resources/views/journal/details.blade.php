@php
    $placeholderImage = 'https://images.unsplash.com/photo-1509460913899-515f1df34fed?auto=format&fit=crop&q=80&w=2400';
    $heroImage = $jurnal->thumbnailUrl() ?? $placeholderImage;
    $titleParts = $jurnal->titleParts();
    $tableOfContents = $jurnal->tableOfContents();
    $articleContent = $jurnal->contentWithSectionIds();
    $readTime = $jurnal->readingTimeMinutes();
    $authorName = $jurnal->user?->name ?? 'Noir Studio';
    $shareUrl = urlencode(url()->current());
    $shareText = urlencode($jurnal->title);
    $sidebarRelated = $relatedJurnals->first();
@endphp
<x-layout.public :title="'Noir/Studio — '.$jurnal->title">
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line" style="top: 15%"></div>
        <div class="diagonal-line" style="top: 55%"></div>

        <x-layout.header />

        <main class="relative z-10">
            <header class="relative h-screen w-full overflow-hidden flex items-end py-12 px-6 md:px-12">
                <img
                    src="{{ $heroImage }}"
                    alt="{{ $jurnal->title }}"
                    class="absolute inset-0 w-full h-full object-cover grayscale opacity-60"
                >
                <div class="absolute inset-0 bg-linear-to-t from-[#0d0d0d] via-transparent to-transparent"></div>

                <div class="w-full relative z-10">
                    <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-8">
                        <span class="bg-[#f5f2ed] text-[#0d0d0d] px-4 py-1.5 text-xs font-bold uppercase tracking-[0.3em]">
                            {{ $jurnal->jurnalCategory?->title ?? 'Journal' }}
                        </span>
                        <span class="text-xs font-bold uppercase tracking-widest text-zinc-400">
                            <iconify-icon icon="lucide:clock" class="mr-2 align-middle"></iconify-icon>
                            {{ $readTime }} Min Read
                        </span>
                    </div>

                    <h1 class="text-5xl md:text-7xl font-display font-black leading-[0.85] tracking-tighter uppercase max-w-5xl">
                        {{ $titleParts['main'] }}
                        @if (filled($titleParts['accent']))
                            <br/><span class="font-serif italic capitalize text-zinc-400">{{ $titleParts['accent'] }}</span>
                        @endif
                    </h1>

                    <div class="mt-12 flex flex-col md:flex-row md:items-center gap-4 md:gap-0 md:space-x-12">
                        <div class="flex flex-col">
                            <span class="text-xs text-zinc-600 uppercase tracking-widest mb-1">Written By</span>
                            <span class="text-sm font-bold uppercase">{{ $authorName }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-zinc-600 uppercase tracking-widest mb-1">Published</span>
                            <span class="text-sm font-bold uppercase">{{ $jurnal->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-zinc-600 uppercase tracking-widest mb-1">Share</span>
                            <div class="flex space-x-4 mt-1">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="text-zinc-500 hover:text-white transition-colors" aria-label="Share on Facebook">
                                    <iconify-icon icon="mdi:facebook"></iconify-icon>
                                </a>
                                <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}&description={{ $shareText }}" target="_blank" rel="noopener noreferrer" class="text-zinc-500 hover:text-white transition-colors" aria-label="Share on Pinterest">
                                    <iconify-icon icon="mdi:pinterest"></iconify-icon>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener noreferrer" class="text-zinc-500 hover:text-white transition-colors" aria-label="Share on X">
                                    <iconify-icon icon="mdi:twitter"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <article class="px-6 md:px-12 py-12">
                <div class="asymmetric-grid">
                    <aside class="col-span-12 lg:col-span-3 lg:sticky lg:top-40 h-fit mb-20 lg:mb-0 border-l border-zinc-900 pl-8">
                        @if ($tableOfContents !== [])
                            <h4 class="text-xs font-bold uppercase tracking-[0.4em] text-zinc-500 mb-8">Table of Contents</h4>
                            <ul class="space-y-6 text-sm font-medium text-zinc-600">
                                @foreach ($tableOfContents as $item)
                                    <li class="toc-link">
                                        <a href="#{{ $item['id'] }}">{{ $item['number'] }}. {{ $item['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($sidebarRelated)
                            <div @class(['mt-20' => $tableOfContents !== []])>
                                <span class="text-xs font-bold uppercase tracking-widest text-zinc-800">Related Series</span>
                                <a href="{{ route('journal.show', $sidebarRelated) }}" class="block mt-4 group">
                                    <div class="aspect-square w-24 overflow-hidden mb-2 bg-zinc-900">
                                        <img
                                            src="{{ $sidebarRelated->thumbnailUrl() ?? $placeholderImage }}"
                                            alt="{{ $sidebarRelated->title }}"
                                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all"
                                        >
                                    </div>
                                    <span class="text-xs font-bold uppercase tracking-widest">{{ $sidebarRelated->title }}</span>
                                </a>
                            </div>
                        @endif
                    </aside>

                    <div class="col-span-12 lg:col-span-7 lg:col-start-5 content-spacing">
                        @if (filled($articleContent))
                            <div class="article-content">
                                {!! $articleContent !!}
                            </div>
                        @elseif (filled($jurnal->description))
                            <p class="text-lg text-zinc-400 font-light">{{ $jurnal->description }}</p>
                        @endif
                    </div>
                </div>
            </article>

            @if ($relatedJurnals->isNotEmpty())
                <section class="px-6 md:px-12 bg-[#09090b] py-12">
                        <div class="flex flex-col lg:flex-row justify-between items-end mb-24 gap-8">
                            <div class="max-w-2xl">
                                <span class="text-xs font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-4">More from Journal</span>
                                <h2 class="text-5xl md:text-6xl font-display font-black uppercase tracking-tighter">
                                    Related<br/><span class="font-serif italic capitalize text-zinc-400">Reading</span>
                                </h2>
                            </div>
                            <a href="{{ route('journal.index') }}" class="text-xs font-bold uppercase tracking-[0.3em] border-b border-zinc-800 pb-2 hover:border-white transition-all">
                                Back to Journal
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                            @foreach ($relatedJurnals as $related)
                                <a href="{{ route('journal.show', $related) }}" class="group block">
                                    <div class="aspect-video overflow-hidden rounded-sm mb-8 bg-zinc-900">
                                        <img
                                            src="{{ $related->thumbnailUrl() ?? $placeholderImage }}"
                                            alt="{{ $related->title }}"
                                            class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110"
                                        >
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-600 mb-4 block">
                                        {{ $related->jurnalCategory?->title ?? 'Journal' }}
                                    </span>
                                    <h4 class="text-2xl font-display font-black uppercase mb-4">{{ $related->title }}</h4>
                                    @if (filled($related->description))
                                        <p class="text-sm text-zinc-500 font-light line-clamp-2 mb-6">{{ $related->description }}</p>
                                    @endif
                                    <div class="flex items-center space-x-4">
                                        <iconify-icon icon="lucide:arrow-right" class="group-hover:translate-x-2 transition-transform"></iconify-icon>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Read More</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                </section>
            @endif
        </main>

        <x-layout.footer />
    </div>
</x-layout.public>
