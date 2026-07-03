@php
    $metrics = $portfolio->metrics ?? [];
    $specs = $portfolio->technical_specs ?? [];
    $testimonial = $portfolio->testimonial ?? [];
    $contentSections = $portfolio->content_sections ?? [];
    $timelineItems = $portfolio->timeline ?? [];
    $contributors = $portfolio->contributorsForDisplay();
    $galleryImages = $portfolio->galleryImageUrls();
    $heroGridImages = array_slice($galleryImages, 0, 4);
    $metricsLargeImage = $galleryImages[4] ?? null;
    $metricsSquareImages = array_slice($galleryImages, 5, 2);
    $postProcessing = $specs['post_processing'] ?? [];
    $heroUrl = $portfolio->heroImageUrl();
    $placeholderImage = 'https://images.unsplash.com/photo-1509460913899-515f1df34fed?auto=format&fit=crop&q=80&w=2400';
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
            background: rgba(245, 242, 237, 0.1);
            transform: rotate(-15deg);
            top: 50%;
            left: -25%;
            z-index: 0;
            pointer-events: none;
        }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #0d0d0d; }
        ::-webkit-scrollbar-thumb { background: #27272a; }
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scroll-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .lightbox-hover { cursor: zoom-in; }
    </style>
    <title>Noir/Studio — {{ $portfolio->title }}</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden">
        <div class="diagonal-line"></div>

        <x-layout.header />

        <main class="relative pt-40 z-10">
            {{-- Hero Header --}}
            <section class="px-6 md:px-12 mb-32">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-8">
                        <div class="mb-16">
                            <a href="{{ route('works.index') }}" id="back-to-portfolio-expanded" class="inline-flex items-center space-x-2 text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-500 hover:text-white transition-colors mb-12">
                                <iconify-icon icon="lucide:arrow-left"></iconify-icon>
                                <span>Back to Selected Works</span>
                            </a>
                            <h1 class="text-5xl sm:text-7xl lg:text-9xl font-display font-black leading-[0.8] tracking-tighter uppercase mb-8">
                                {{ $portfolio->headlineTitle() }}@if(filled($portfolio->subtitle))<br/><span class="font-serif italic capitalize text-zinc-500 lowercase">{{ $portfolio->subtitle }}</span>@endif
                            </h1>
                            <div class="flex flex-wrap gap-8 items-center mt-12">
                                @if(filled($portfolio->client))
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest mb-1">Client</span>
                                        <span class="text-sm font-bold uppercase tracking-widest">{{ $portfolio->client }}</span>
                                    </div>
                                @endif
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-zinc-500 uppercase tracking-widest mb-1">Year</span>
                                    <span class="text-sm font-bold uppercase tracking-widest">{{ $portfolio->year }}</span>
                                </div>
                                @if(filled($portfolio->portfolioCategory?->title))
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest mb-1">Category</span>
                                        <span class="text-sm font-bold uppercase tracking-widest">{{ $portfolio->portfolioCategory->title }}</span>
                                    </div>
                                @endif
                                @if(filled($portfolio->location))
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest mb-1">Location</span>
                                        <span class="text-sm font-bold uppercase tracking-widest">{{ $portfolio->location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-4 flex justify-end items-end pb-16">
                        <div class="flex space-x-4">
                            <button type="button" id="share-btn" onclick="navigator.share?.({ title: '{{ addslashes($portfolio->title) }}', url: window.location.href })" class="p-4 border border-zinc-800 rounded-full hover:bg-white hover:text-black transition-all group">
                                <iconify-icon icon="lucide:share-2" class="text-xl"></iconify-icon>
                            </button>
                            @if($heroUrl)
                                <a href="{{ $heroUrl }}" id="download-btn" download class="p-4 border border-zinc-800 rounded-full hover:bg-white hover:text-black transition-all group">
                                    <iconify-icon icon="lucide:download" class="text-xl"></iconify-icon>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            {{-- Hero Image & Conceptual Framework --}}
            <section class="px-6 md:px-12 mb-40">
                <div class="w-full aspect-[21/9] overflow-hidden rounded-sm group mb-24 relative lightbox-hover">
                    <img
                        src="{{ $heroUrl ?? $placeholderImage }}"
                        alt="{{ $portfolio->title }}"
                        class="w-full h-full object-cover grayscale transition-transform duration-[2s] group-hover:scale-105"
                    >
                    @if(filled($portfolio->hero_caption))
                        <div class="absolute bottom-8 right-8 bg-zinc-900/40 backdrop-blur-sm p-4 border border-zinc-800">
                            <p class="text-[10px] font-bold uppercase tracking-widest">{{ $portfolio->hero_caption }}</p>
                        </div>
                    @endif
                </div>

                @if(filled($portfolio->quote) || count($contentSections) > 0 || count($heroGridImages) > 0)
                    <div class="asymmetric-grid scroll-reveal">
                        @if(filled($portfolio->quote) || count($contentSections) > 0)
                            <div class="col-span-12 lg:col-span-5">
                                <h2 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-8">Conceptual Framework</h2>
                                @if(filled($portfolio->quote))
                                    <p class="font-serif italic text-2xl sm:text-4xl text-zinc-300 leading-tight mb-12">"{{ $portfolio->quote }}"</p>
                                @endif
                                @if(count($contentSections) > 0)
                                    <div class="space-y-8 text-zinc-400 font-light leading-relaxed max-w-md">
                                        @foreach($contentSections as $index => $section)
                                            <div>
                                                <h4 class="text-white font-bold text-xs uppercase tracking-widest mb-2">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}. {{ $section['title'] ?? '' }}</h4>
                                                <p>{{ $section['description'] ?? '' }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if(count($heroGridImages) > 0)
                            <div @class([
                                'col-span-12 lg:col-span-6 lg:col-start-7 pt-12 lg:pt-0',
                                'col-start-1' => blank($portfolio->quote) && count($contentSections) === 0,
                            ])>
                                <div class="grid grid-cols-2 gap-6">
                                    @foreach($heroGridImages as $index => $image)
                                        <div @class([
                                            'group relative overflow-hidden rounded-sm lightbox-hover',
                                            'mt-12' => $index % 2 === 1,
                                        ])>
                                            <img
                                                src="{{ $image['url'] }}"
                                                alt="{{ $image['alt'] ?: $portfolio->title }}"
                                                class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700"
                                            >
                                            @if(filled($image['caption']))
                                                <div class="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="text-[8px] bg-black/50 p-2 uppercase tracking-widest">{{ $image['caption'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </section>

            {{-- Project Metrics & Gallery --}}
            @if(
                filled($metrics['shots_taken'] ?? null)
                || filled($metrics['final_selects'] ?? null)
                || filled($metrics['total_hours'] ?? null)
                || filled($metrics['team_members'] ?? null)
                || $metricsLargeImage
                || count($metricsSquareImages) > 0
            )
                <section class="px-6 md:px-12 mb-40">
                    <div class="asymmetric-grid">
                        @if(
                            filled($metrics['shots_taken'] ?? null)
                            || filled($metrics['final_selects'] ?? null)
                            || filled($metrics['total_hours'] ?? null)
                            || filled($metrics['team_members'] ?? null)
                        )
                            <div class="col-span-12 lg:col-span-4">
                                <div class="space-y-12">
                                    <div>
                                        <h2 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-8">Project Metrics</h2>
                                        <div class="grid grid-cols-2 gap-4">
                                            @foreach([
                                                'shots_taken' => 'Shots Taken',
                                                'final_selects' => 'Final Selects',
                                                'total_hours' => 'Total Hours',
                                                'team_members' => 'Team Members',
                                            ] as $key => $label)
                                                @if(filled($metrics[$key] ?? null))
                                                    <div class="bg-zinc-900/50 p-6 border border-zinc-800">
                                                        <span class="text-4xl font-display font-black block mb-2">{{ $metrics[$key] }}</span>
                                                        <span class="text-[10px] uppercase tracking-widest text-zinc-500">{{ $label }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($metricsLargeImage || count($metricsSquareImages) > 0)
                            <div @class([
                                'col-span-12 lg:col-span-7 lg:col-start-6 mt-20 lg:mt-0',
                                'lg:col-start-1 lg:col-span-12' => !(
                                    filled($metrics['shots_taken'] ?? null)
                                    || filled($metrics['final_selects'] ?? null)
                                    || filled($metrics['total_hours'] ?? null)
                                    || filled($metrics['team_members'] ?? null)
                                ),
                            ])>
                                @if($metricsLargeImage)
                                    <div class="w-full aspect-video overflow-hidden rounded-sm lightbox-hover mb-8">
                                        <img
                                            src="{{ $metricsLargeImage['url'] }}"
                                            alt="{{ $metricsLargeImage['alt'] ?: $portfolio->title }}"
                                            class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000"
                                        >
                                    </div>
                                @endif
                                @if(count($metricsSquareImages) > 0)
                                    <div class="grid grid-cols-2 gap-6">
                                        @foreach($metricsSquareImages as $image)
                                            <div class="aspect-square overflow-hidden rounded-sm lightbox-hover">
                                                <img
                                                    src="{{ $image['url'] }}"
                                                    alt="{{ $image['alt'] ?: $portfolio->title }}"
                                                    class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            {{-- Technical Specifications & Timeline --}}
            @if(
                filled($specs['camera_setup'] ?? null)
                || filled($specs['lighting_array'] ?? null)
                || count($postProcessing) > 0
                || filled($specs['retouching_notes'] ?? null)
                || count($timelineItems) > 0
                || filled($testimonial['quote'] ?? null)
            )
                <section class="bg-zinc-900 py-32 px-6 md:px-12">
                    <div class="asymmetric-grid">
                        @if(
                            filled($specs['camera_setup'] ?? null)
                            || filled($specs['lighting_array'] ?? null)
                            || count($postProcessing) > 0
                            || filled($specs['retouching_notes'] ?? null)
                        )
                            <div class="col-span-12 lg:col-span-4 mb-24 lg:mb-0">
                                <h2 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-8">Technical Specifications</h2>
                                <div class="space-y-10">
                                    @if(filled($specs['camera_setup'] ?? null))
                                        <div class="border-b border-zinc-800 pb-4">
                                            <p class="text-[10px] text-zinc-600 uppercase tracking-widest mb-1">Camera Setup</p>
                                            <p class="text-lg">{{ $specs['camera_setup'] }}</p>
                                            @if(filled($specs['camera_settings'] ?? null))
                                                <div class="flex flex-wrap gap-x-4 mt-2">
                                                    @foreach(explode('·', $specs['camera_settings']) as $setting)
                                                        <span class="text-[10px] text-zinc-400">{{ trim($setting) }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if(filled($specs['lighting_array'] ?? null))
                                        <div class="border-b border-zinc-800 pb-4">
                                            <p class="text-[10px] text-zinc-600 uppercase tracking-widest mb-1">Lighting Array</p>
                                            <p class="text-lg">{{ $specs['lighting_array'] }}</p>
                                            @if(filled($specs['lighting_notes'] ?? null))
                                                <p class="text-[10px] text-zinc-400 mt-1">{{ $specs['lighting_notes'] }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    @if(count($postProcessing) > 0)
                                        <div class="border-b border-zinc-800 pb-4">
                                            <h4 class="text-[10px] text-zinc-600 uppercase tracking-widest mb-3">Post-Processing Workflow</h4>
                                            <div class="space-y-2">
                                                @foreach($postProcessing as $step)
                                                    <div class="flex justify-between text-[11px]">
                                                        <span>{{ $step['title'] ?? '' }}</span>
                                                        <span class="text-zinc-500">{{ $step['text'] ?? '' }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if(filled($specs['retouching_notes'] ?? null))
                                        <div class="pt-4 text-zinc-500 text-xs italic">
                                            <p>Retouching notes: {{ $specs['retouching_notes'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(count($timelineItems) > 0 || filled($testimonial['quote'] ?? null))
                            <div @class([
                                'col-span-12 lg:col-span-7 lg:col-start-6',
                                'lg:col-start-1' => !(
                                    filled($specs['camera_setup'] ?? null)
                                    || filled($specs['lighting_array'] ?? null)
                                    || count($postProcessing) > 0
                                    || filled($specs['retouching_notes'] ?? null)
                                ),
                            ])>
                                @if(count($timelineItems) > 0)
                                    <h2 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-8">Production Timeline</h2>
                                    <div class="space-y-8 relative pl-8 border-l border-zinc-800">
                                        @foreach($timelineItems as $index => $item)
                                            <div class="relative">
                                                <div @class([
                                                    'absolute -left-[37px] top-1 w-4 h-4 rounded-full border-4 border-zinc-900',
                                                    'bg-white' => $index === 0,
                                                    'bg-zinc-800' => $index !== 0,
                                                ])></div>
                                                <h4 class="text-sm font-bold uppercase">{{ $item['title'] ?? '' }}</h4>
                                                <p class="text-xs text-zinc-400">{{ $item['text'] ?? '' }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if(filled($testimonial['quote'] ?? null))
                                    <div @class([
                                        'p-12 bg-zinc-950 border border-zinc-800 rounded-sm',
                                        'mt-24' => count($timelineItems) > 0,
                                    ])>
                                        <h4 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-600 mb-8">Client Testimonial</h4>
                                        <p class="font-serif italic text-2xl text-zinc-300 leading-relaxed mb-6">"{{ $testimonial['quote'] }}"</p>
                                        @if(filled($testimonial['author'] ?? null))
                                            <div class="flex items-center space-x-4">
                                                <div class="w-10 h-10 rounded-full bg-zinc-800"></div>
                                                <div>
                                                    <p class="text-xs font-bold uppercase">{{ $testimonial['author'] }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            {{-- Contributors --}}
            @if($contributors->isNotEmpty())
                <section class="px-6 md:px-12 py-32">
                    <h2 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-16">The Contributors</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
                        @foreach($contributors as $contributor)
                            <div class="space-y-6">
                                <div class="aspect-square bg-zinc-800 rounded-sm grayscale hover:grayscale-0 transition-all duration-700 overflow-hidden">
                                    @if(filled($contributor['photo_url'] ?? null))
                                        <img src="{{ $contributor['photo_url'] }}" alt="{{ $contributor['name'] ?? 'Contributor' }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    @if(filled($contributor['name'] ?? null))
                                        <h4 class="text-xl font-display font-black uppercase">{{ $contributor['name'] }}</h4>
                                    @endif
                                    @if(filled($contributor['job'] ?? null))
                                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest mb-4">{{ $contributor['job'] }}</p>
                                    @endif
                                    @if(filled($contributor['description'] ?? null))
                                        <p class="text-xs text-zinc-400 leading-relaxed mb-4">{{ $contributor['description'] }}</p>
                                    @endif
                                    @if(count($contributor['social_media'] ?? []) > 0)
                                        <div class="flex space-x-4">
                                            @foreach($contributor['social_media'] as $social)
                                                <a href="{{ $social['link'] }}" target="_blank" rel="noopener noreferrer" class="text-zinc-500 hover:text-white" title="{{ $social['label'] ?? ucfirst($social['type']) }}">
                                                    <iconify-icon icon="{{ \App\Models\Team::socialIcon($social['type'] ?? 'instagram') }}"></iconify-icon>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Related Projects --}}
            @if($relatedPortfolios->isNotEmpty())
                <section class="px-6 md:px-12 py-32 border-t border-zinc-900">
                    <div class="flex justify-between items-end mb-16">
                        <h2 class="text-3xl sm:text-5xl font-display font-bold uppercase tracking-tight">Related Projects</h2>
                        <a href="{{ route('works.index') }}" class="text-[10px] font-bold uppercase tracking-widest border-b border-white pb-1">Explore All</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                        @foreach($relatedPortfolios as $related)
                            <a href="{{ route('works.show', $related) }}" class="group block">
                                <div class="aspect-[3/4] overflow-hidden rounded-sm mb-6 grayscale group-hover:grayscale-0 transition-all duration-700 bg-zinc-900">
                                    <img
                                        src="{{ $related->heroImageUrl() ?? $placeholderImage }}"
                                        alt="{{ $related->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000"
                                    >
                                </div>
                                <h4 class="text-xs font-bold uppercase tracking-widest">{{ $related->title }}</h4>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>

        <x-layout.footer />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.scroll-reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            reveals.forEach(reveal => observer.observe(reveal));
        });
    </script>
</body>
</html>
