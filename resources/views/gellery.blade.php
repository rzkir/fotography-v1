<x-layout.public title="Gallery | Noir/Studio">
    <div class="min-h-screen flex flex-col bg-[#0d0d0d]">
        <x-layout.header :blend-nav="false" />

        <main class="flex-1 pt-28 pb-10 w-full" data-gallery-index>
            <header class="px-6 md:px-12 lg:px-16 mb-20 md:mb-32" data-aos-hero>
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                    <p class="text-xs uppercase tracking-[0.5em] font-bold opacity-50" data-aos="fade-down" data-aos-offset="0">
                        Koleksi Visual
                    </p>
                    <p class="font-serif italic text-xl md:text-2xl opacity-70" data-aos="fade-down" data-aos-delay="80" data-aos-offset="0">
                        Kurasi gambar dalam bentuk paling murni.
                    </p>
                </div>
                <h1 class="font-display font-black text-6xl sm:text-8xl md:text-[12rem] leading-[0.8] tracking-tighter uppercase" data-aos="fade-right" data-aos-delay="120" data-aos-offset="0">
                    WORKS<br>GALLERY
                </h1>
            </header>

            @if ($galleries->isEmpty())
                <div class="px-6 md:px-12 lg:px-16">
                    <div class="border border-white/10 rounded-sm p-16 md:p-24 text-center max-w-3xl mx-auto">
                        <iconify-icon icon="lucide:image-off" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                        <h2 class="font-display font-bold text-2xl uppercase tracking-tight mb-3">Belum ada karya</h2>
                        <p class="text-sm text-zinc-500 leading-relaxed">
                            Arsip visual sedang disiapkan. Kembali lagi nanti untuk melihat koleksi terbaru dari studio.
                        </p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1" id="gallery-grid">
                    @foreach ($galleries as $gallery)
                        <article
                            data-gallery-item
                            data-gallery-title="{{ $gallery->title }}"
                            data-gallery-image-url="{{ $gallery->imageUrl() }}"
                            data-gallery-date="{{ $gallery->updated_at->format('M d, Y') }}"
                            tabindex="0"
                            role="button"
                            aria-label="View {{ $gallery->title }}"
                            class="gallery-item gallery-card relative block overflow-hidden bg-[#1a1a1a] cursor-pointer lightbox-hover group focus:outline-none focus-visible:ring-2 focus-visible:ring-[#ff6b35] focus-visible:ring-offset-2 focus-visible:ring-offset-[#0d0d0d]"
                        >
                            <img
                                src="{{ $gallery->imageUrl() }}"
                                alt="{{ $gallery->title }}"
                                loading="lazy"
                                decoding="async"
                                class="gallery-item__image w-full aspect-4/5 md:aspect-3/4 object-cover"
                            >
                            <div class="absolute inset-0 bg-linear-to-t from-black/80 via-transparent to-transparent opacity-80"></div>
                            <div class="absolute bottom-8 left-8 right-8">
                                <p class="text-[10px] uppercase tracking-widest opacity-60 mb-1">Visual Archive</p>
                                <h3 class="font-display font-bold text-xl uppercase tracking-tighter">{{ $gallery->title }}</h3>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <section class="px-6 md:px-12 lg:px-16 max-w-7xl mx-auto mt-20 mb-10 text-center">
                <h2 class="font-display font-bold text-3xl uppercase tracking-tight mb-8">Tertarik berkolaborasi?</h2>
                <a
                    href="{{ route('contact') }}"
                    id="gallery-cta-link"
                    class="inline-block px-12 py-5 border-2 border-[#f5f2ed] font-display font-bold uppercase tracking-widest hover:bg-[#f5f2ed] hover:text-[#0d0d0d] transition-all"
                >
                    Hubungi Studio
                </a>
            </section>
        </main>

        <x-layout.footer />
    </div>

    <x-ui.dialog.gallery-preview id="gallery-preview-dialog" />
</x-layout.public>
