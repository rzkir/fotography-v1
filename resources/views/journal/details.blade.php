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
        .content-spacing { line-height: 1.8; letter-spacing: 0.01em; }
        .toc-link:hover { padding-left: 8px; color: #f5f2ed; }
        .toc-link { transition: all 0.3s ease; }
        .article-content h2 {
            font-family: 'Cabinet Grotesk', sans-serif;
            font-size: 2.25rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -0.02em;
            margin-bottom: 2.5rem;
            scroll-margin-top: 8rem;
        }
        .article-content p {
            font-size: 1.125rem;
            color: rgb(161 161 170);
            font-weight: 300;
            margin-bottom: 2rem;
        }
        .article-content blockquote {
            margin: 6rem 0;
            border-top: 1px solid rgb(39 39 42);
            border-bottom: 1px solid rgb(39 39 42);
            padding: 4rem 0;
            text-align: center;
        }
        .article-content blockquote p {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 2.25rem;
            line-height: 1.3;
            color: rgb(212 212 216);
            margin-bottom: 0;
        }
        .article-content figure {
            margin: 5rem 0;
        }
        .article-content figure img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            border-radius: 0.125rem;
            filter: grayscale(100%);
            transition: filter 2s ease;
        }
        .article-content figure:hover img {
            filter: grayscale(0%);
        }
        .article-content figcaption {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgb(82 82 91);
            border-left: 2px solid rgb(39 39 42);
            padding-left: 1rem;
            margin-top: 1.5rem;
        }
        .article-content section {
            margin-bottom: 6rem;
        }
    </style>
    <title>Noir/Studio — {{ $jurnal->title }}</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line" style="top: 15%"></div>
        <div class="diagonal-line" style="top: 55%"></div>

        <x-layout.header />

        <main class="relative z-10">
            <header class="relative h-[80vh] w-full overflow-hidden flex items-end pb-24 px-6 md:px-12">
                <img
                    src="{{ $heroImage }}"
                    alt="{{ $jurnal->title }}"
                    class="absolute inset-0 w-full h-full object-cover grayscale opacity-60"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-[#0d0d0d] via-transparent to-transparent"></div>

                <div class="max-w-7xl mx-auto w-full relative z-10">
                    <div class="flex flex-wrap items-center gap-4 md:gap-6 mb-8">
                        <span class="bg-[#f5f2ed] text-[#0d0d0d] px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.3em]">
                            {{ $jurnal->jurnalCategory?->title ?? 'Journal' }}
                        </span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                            <iconify-icon icon="lucide:clock" class="mr-2 align-middle"></iconify-icon>
                            {{ $readTime }} Min Read
                        </span>
                    </div>

                    <h1 class="text-5xl md:text-7xl lg:text-9xl font-display font-black leading-[0.85] tracking-tighter uppercase max-w-5xl">
                        {{ $titleParts['main'] }}
                        @if (filled($titleParts['accent']))
                            <br/><span class="font-serif italic capitalize text-zinc-400">{{ $titleParts['accent'] }}</span>
                        @endif
                    </h1>

                    <div class="mt-12 flex flex-col md:flex-row md:items-center gap-4 md:gap-0 md:space-x-12">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-zinc-600 uppercase tracking-widest mb-1">Written By</span>
                            <span class="text-sm font-bold uppercase">{{ $authorName }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-zinc-600 uppercase tracking-widest mb-1">Published</span>
                            <span class="text-sm font-bold uppercase">{{ $jurnal->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] text-zinc-600 uppercase tracking-widest mb-1">Share</span>
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

            <article class="py-32 px-6 md:px-12">
                <div class="asymmetric-grid max-w-7xl mx-auto">
                    <aside class="col-span-12 lg:col-span-3 lg:sticky lg:top-40 h-fit mb-20 lg:mb-0 border-l border-zinc-900 pl-8">
                        @if ($tableOfContents !== [])
                            <h4 class="text-[10px] font-bold uppercase tracking-[0.4em] text-zinc-500 mb-8">Table of Contents</h4>
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
                                <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-800">Related Series</span>
                                <a href="{{ route('journal.show', $sidebarRelated) }}" class="block mt-4 group">
                                    <div class="aspect-square w-24 overflow-hidden mb-2 bg-zinc-900">
                                        <img
                                            src="{{ $sidebarRelated->thumbnailUrl() ?? $placeholderImage }}"
                                            alt="{{ $sidebarRelated->title }}"
                                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all"
                                        >
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $sidebarRelated->title }}</span>
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

                        <div class="bg-zinc-900/40 p-8 md:p-12 rounded-sm border border-zinc-800 mt-32">
                            <div class="flex flex-col md:flex-row items-start gap-8 md:gap-12">
                                <div class="w-32 h-32 rounded-full overflow-hidden shrink-0 border-4 border-zinc-800 grayscale bg-zinc-800 flex items-center justify-center">
                                    <iconify-icon icon="lucide:user-round" class="text-4xl text-zinc-600"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-600 mb-2 block">About the Author</span>
                                    <h3 class="text-2xl font-display font-black uppercase mb-4">{{ $authorName }}</h3>
                                    <p class="text-zinc-400 font-light text-sm leading-relaxed mb-6">
                                        {{ $authorName }} is the lead voice behind Noir/Studio journal — sharing craft notes, production insights, and visual philosophy from the studio floor.
                                    </p>
                                    <div class="flex space-x-6">
                                        <a href="{{ route('works.index') }}" class="text-zinc-500 hover:text-white transition-colors uppercase text-[10px] font-bold tracking-widest">Portfolio</a>
                                        <a href="{{ route('journal.index') }}" class="text-zinc-500 hover:text-white transition-colors uppercase text-[10px] font-bold tracking-widest">Journal</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-32 pt-24 border-t border-zinc-900">
                            <h4 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-12 text-center">Reader Discussion</h4>
                            <div class="max-w-3xl mx-auto space-y-10">
                                <div class="flex space-x-6">
                                    <div class="w-10 h-10 rounded-full bg-zinc-800 overflow-hidden grayscale shrink-0 flex items-center justify-center">
                                        <iconify-icon icon="lucide:user" class="text-zinc-600"></iconify-icon>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between mb-2">
                                            <span class="text-xs font-bold uppercase tracking-widest">Studio Reader</span>
                                            <span class="text-[10px] text-zinc-600">Recently</span>
                                        </div>
                                        <p class="text-sm text-zinc-400">Great read — the practical notes on light fall-off really clarified how you build mood in editorial portraits.</p>
                                    </div>
                                </div>
                                <div class="flex space-x-6 border-t border-zinc-900 pt-10">
                                    <div class="w-10 h-10 rounded-full bg-zinc-800 overflow-hidden grayscale shrink-0 flex items-center justify-center">
                                        <iconify-icon icon="lucide:user" class="text-zinc-600"></iconify-icon>
                                    </div>
                                    <div class="flex-1">
                                        <form>
                                            <textarea placeholder="Share your thoughts..." class="w-full bg-transparent border border-zinc-800 p-6 text-sm text-zinc-300 outline-none focus:border-white transition-all resize-none mb-6" rows="4"></textarea>
                                            <button type="button" class="px-10 py-3 bg-white text-black text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-200 transition-all">Post Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            @if ($relatedJurnals->isNotEmpty())
                <section class="py-32 px-6 md:px-12 bg-[#09090b]">
                    <div class="max-w-7xl mx-auto">
                        <div class="flex flex-col lg:flex-row justify-between items-end mb-24 gap-8">
                            <div class="max-w-2xl">
                                <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-4">More from Journal</span>
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
                    </div>
                </section>
            @endif
        </main>

        <x-layout.footer />
    </div>
</body>
</html>
