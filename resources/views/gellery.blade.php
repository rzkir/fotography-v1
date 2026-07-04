@php
    $galleryItems = [
        [
            'image' => 'https://images.unsplash.com/photo-1518005020250-675f0f0fd13b?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Structural Void',
            'category' => 'Architecture',
            'title' => 'Structural Void',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1509060408796-772ab1ef9946?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Hidden Gaze',
            'category' => 'Portraits',
            'title' => 'Hidden Gaze',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Morning Shadows',
            'category' => 'Still Life',
            'title' => 'Morning Shadows',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1493246507139-91e8bef99c1e?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Desolate Peaks',
            'category' => 'Landscapes',
            'title' => 'Desolate Peaks',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Silken Skin',
            'category' => 'Portraits',
            'title' => 'Silken Skin',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1507738978512-35798112892c?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Concrete Flow',
            'category' => 'Architecture',
            'title' => 'Concrete Flow',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Organic Form',
            'category' => 'Still Life',
            'title' => 'Organic Form',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Misty Horizon',
            'category' => 'Landscapes',
            'title' => 'Misty Horizon',
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1504194104404-433180773017?auto=format&fit=crop&q=80&w=1200',
            'alt' => 'Brutal Geometry',
            'category' => 'Architecture',
            'title' => 'Brutal Geometry',
        ],
    ];
@endphp

<x-layout.public title="Gallery | Noir/Studio">
    <div class="min-h-screen flex flex-col bg-[#0d0d0d]">
        <x-layout.header />

        <main class="flex-1 pt-28 pb-10 w-full">
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1" id="gallery-grid">
                @foreach ($galleryItems as $item)
                    <article
                        class="gallery-item gallery-card relative block aspect-4/5 md:aspect-3/4 overflow-hidden bg-[#1a1a1a]"
                        data-aos="fade-up"
                        data-aos-delay="{{ ($loop->index % 6) * 80 }}"
                    >
                        <img
                            src="{{ $item['image'] }}"
                            alt="{{ $item['alt'] }}"
                            class="w-full h-full object-cover grayscale"
                        >
                        <div class="absolute bottom-8 left-8">
                            <p class="text-[10px] uppercase tracking-widest opacity-60 mb-1">{{ $item['category'] }}</p>
                            <h3 class="font-display font-bold text-xl uppercase tracking-tighter">{{ $item['title'] }}</h3>
                        </div>
                    </article>
                @endforeach
            </div>

            <section class="px-6 md:px-12 lg:px-16 max-w-7xl mx-auto mt-40 mb-20 text-center" data-aos="fade-up">
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
</x-layout.public>
