<x-layout.public title="Noir/Studio - Fine Art Portfolio">
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]" data-home-page>
        <div class="diagonal-line" style="top: 10%"></div>
        <div class="diagonal-line" style="top: 40%"></div>
        <div class="diagonal-line" style="top: 70%"></div>

        <!-- NavigationBar Component -->
        <x-layout.header />

        <main class="relative z-10">
            <!-- Hero Section -->
            <header class="pt-40 px-12 pb-32">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-7 flex flex-col justify-center pr-12">
                        <div class="mb-12 relative">
                            <span class="absolute -top-12 left-0 text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase">Est. 2016 — Fine Art Portfolio</span>
                            <h1 class="text-8xl lg:text-[13rem] font-display font-black leading-[0.8] tracking-tighter uppercase mb-6">Beyond<br/>Vision</h1>
                            <p class="font-serif italic text-4xl lg:text-6xl text-zinc-400 leading-tight ml-24">The art of capturing what stays <span class="text-[#f5f2ed] border-b border-zinc-700">unseen</span>.</p>
                        </div>
                        <div class="ml-24 max-w-xl space-y-8">
                            <p class="text-zinc-500 font-light leading-relaxed">I am a visionary photographer pushing the boundaries of portraiture. Through minimal lighting and cinematic composition, I reveal the raw essence of every subject.</p>
                            <div class="flex flex-wrap gap-4 text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                                <span class="px-4 py-2 border border-zinc-800 rounded-full">Studio Sessions</span>
                                <span class="px-4 py-2 border border-zinc-800 rounded-full">Editorial Shoots</span>
                                <span class="px-4 py-2 border border-zinc-800 rounded-full">Fashion Photography</span>
                                <span class="px-4 py-2 border border-zinc-800 rounded-full">Fine Art Portraits</span>
                                <span class="px-4 py-2 border border-zinc-800 rounded-full">Commercial Work</span>
                            </div>
                            <div class="flex items-center space-x-8 pt-4">
                                <a href="#works" id="hero-primary-cta" class="group flex items-center space-x-4">
                                    <div class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center group-hover:bg-white group-hover:border-white transition-all duration-500">
                                        <iconify-icon icon="lucide:arrow-up-right" class="text-2xl group-hover:text-black transition-colors"></iconify-icon>
                                    </div>
                                    <span class="text-xs font-bold uppercase tracking-[0.2em]">Selected Works</span>
                                </a>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-zinc-500 uppercase tracking-widest mb-1">Based in Jakarta</span>
                                    <span class="text-sm font-medium">Available Globally / 2024</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-5 relative mt-24 lg:mt-0">
                        <div class="relative aspect-3/4 overflow-hidden rounded-sm group">
                            <img src="https://images.unsplash.com/photo-1509460913899-515f1df34fed?auto=format&fit=crop&q=80&w=1200" alt="Dramatic Portrait" class="w-full h-full object-cover grayscale transition-all duration-[2s] group-hover:scale-110 mask-image">
                            <div class="absolute bottom-8 right-8 text-right">
                                <span class="block text-xs font-bold uppercase tracking-widest text-white/50">Model: Sophia K.</span>
                                <span class="block text-xs font-bold uppercase tracking-widest text-white/50">Series: Midnight Soul</span>
                            </div>
                        </div>
                        <div class="absolute -top-12 -left-12 w-48 h-48 bg-zinc-900 flex items-center justify-center text-center p-8 rounded-full border border-zinc-800 xl:flex">
                            <p class="text-[10px] font-bold leading-tight uppercase tracking-widest">Shot on 35mm Analog Film</p>
                        </div>
                    </div>
                </div>
            </header>

            @if($features->isNotEmpty())
                <section class="py-32 border-y border-zinc-900">
                    <div class="max-w-7xl mx-auto px-6 md:px-12">
                        <div @class([
                            'grid gap-12 text-center',
                            'grid-cols-2' => $features->count() > 1,
                            'grid-cols-1' => $features->count() === 1,
                            'lg:grid-cols-4' => $features->count() >= 4,
                            'lg:grid-cols-3' => $features->count() === 3,
                            'lg:grid-cols-2' => $features->count() === 2,
                        ])>
                            @foreach($features as $feature)
                                <div class="space-y-2">
                                    <h3 class="text-5xl font-display font-black">{{ $feature->number }}+</h3>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-zinc-500">{{ $feature->title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            <!-- Portfolio Grid -->
            <section id="works" class="py-32 px-12">
                <div class="flex flex-col lg:flex-row justify-between items-end mb-24 gap-8">
                    <div class="max-w-2xl">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-4">Portfolio Showcase</span>
                        <h2 class="text-7xl font-display font-black uppercase tracking-tighter">Curated<br/><span class="font-serif italic capitalize text-zinc-400">Collection</span></h2>
                    </div>
                    <a href="#" id="view-all-portfolio" class="text-xs font-bold uppercase tracking-[0.3em] border-b border-zinc-800 pb-2 hover:border-white transition-all">View Full Archive</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Editorial</span>
                            <h3 class="text-2xl font-display font-black uppercase">Ethereal Echoes</h3>
                        </div>
                    </div>
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900 lg:mt-12">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Street</span>
                            <h3 class="text-2xl font-display font-black uppercase">Urban Silence</h3>
                        </div>
                    </div>
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Portrait</span>
                            <h3 class="text-2xl font-display font-black uppercase">Golden Hour Soul</h3>
                        </div>
                    </div>
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900 lg:mt-12">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Minimalist</span>
                            <h3 class="text-2xl font-display font-black uppercase">The Minimalist</h3>
                        </div>
                    </div>
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1523950103971-5cf00677a26c?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Fashion</span>
                            <h3 class="text-2xl font-display font-black uppercase">Fashion Forward</h3>
                        </div>
                    </div>
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900 lg:mt-12">
                        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Landscape</span>
                            <h3 class="text-2xl font-display font-black uppercase">Nature's Mirror</h3>
                        </div>
                    </div>
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Studio</span>
                            <h3 class="text-2xl font-display font-black uppercase">Studio Noir</h3>
                        </div>
                    </div>
                    <div class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900 lg:mt-12">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-8 project-overlay">
                            <span class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Portrait</span>
                            <h3 class="text-2xl font-display font-black uppercase">Timeless Beauty</h3>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Marquee Section -->
            <section class="py-32 overflow-hidden border-t border-zinc-900">
                <div class="marquee-text flex space-x-24 items-center">
                    <span class="text-9xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Portrait</span>
                    <span class="text-9xl font-display font-black uppercase">Editorial</span>
                    <span class="text-9xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Fashion</span>
                    <span class="text-9xl font-display font-black uppercase">Beauty</span>
                    <span class="text-9xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Lifestyle</span>
                    <span class="text-9xl font-display font-black uppercase">Commercial</span>
                    <span class="text-9xl font-display font-black text-transparent stroke-zinc-800 uppercase" style="-webkit-text-stroke: 1px #27272a;">Documentary</span>
                    <span class="text-9xl font-display font-black uppercase">Landscape</span>
                </div>
            </section>

            <!-- About Section -->
            <section class="py-32 px-12 bg-zinc-900/30">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-5">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-8">About the Artist</span>
                        <h2 class="text-6xl font-display font-black leading-[0.9] uppercase mb-12">The Eye<br/>Behind<br/>The Lens</h2>
                        <div class="space-y-6 text-zinc-400 font-light leading-relaxed">
                            <p>Noir/Studio was founded on the belief that photography should not just record a person, but interpret their story. My approach is rooted in 8+ years of professional exploration, focusing on the intersection of fine art and editorial storytelling.</p>
                            <p>I specialize in capturing raw, authentic moments using a minimalists lens, often working with high-contrast shadows to bring out the depth of human expression.</p>
                            <a href="#" id="about-session-cta" class="inline-flex items-center space-x-4 pt-8 group">
                                <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center group-hover:bg-white transition-all">
                                    <iconify-icon icon="lucide:arrow-right" class="group-hover:text-black"></iconify-icon>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest">Book A Session</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 lg:col-start-7 mt-20 lg:mt-0 grid grid-cols-2 gap-8">
                        <div class="aspect-square bg-zinc-900 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale">
                        </div>
                        <div class="aspect-square bg-zinc-900 overflow-hidden mt-12">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale">
                        </div>
                    </div>
                </div>
            </section>

            @if($testimonials->isNotEmpty())
                <section class="py-32 px-6 md:px-12" id="testimonials-slider" aria-label="Client Testimonials">
                    <div class="max-w-4xl mx-auto text-center">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-12">Client Testimonials</span>

                        <div class="relative">
                            <div class="overflow-hidden">
                                <div id="testimonial-track" class="testimonial-track flex">
                                    @foreach($testimonials as $testimonial)
                                        <article class="w-full shrink-0 space-y-8 px-4" data-testimonial-slide>
                                            <iconify-icon icon="mdi:format-quote-close" class="text-6xl text-zinc-800"></iconify-icon>
                                            <p class="text-2xl sm:text-3xl font-serif italic text-zinc-300 leading-relaxed">"{{ $testimonial->message }}"</p>
                                            <div class="flex flex-col items-center">
                                                <span class="text-sm font-bold uppercase tracking-widest">{{ $testimonial->name }}</span>
                                                <span class="text-[10px] text-zinc-600 uppercase tracking-widest">{{ $testimonial->jobs }}, {{ $testimonial->company }}</span>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>

                            @if($testimonials->count() > 1)
                                <div class="flex items-center justify-center gap-8 mt-16">
                                    <button
                                        type="button"
                                        id="testimonial-prev"
                                        class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center text-zinc-400 hover:bg-white hover:text-black hover:border-white transition-all"
                                        aria-label="Previous testimonial"
                                    >
                                        <iconify-icon icon="lucide:arrow-left" class="text-xl"></iconify-icon>
                                    </button>

                                    <div class="flex items-center gap-2" id="testimonial-dots" role="tablist" aria-label="Testimonial slides">
                                        @foreach($testimonials as $index => $testimonial)
                                            <button
                                                type="button"
                                                class="testimonial-dot h-1.5 w-1.5 rounded-full bg-zinc-700 {{ $index === 0 ? 'active' : '' }}"
                                                data-slide="{{ $index }}"
                                                aria-label="Go to testimonial {{ $index + 1 }}"
                                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                                                role="tab"
                                            ></button>
                                        @endforeach
                                    </div>

                                    <button
                                        type="button"
                                        id="testimonial-next"
                                        class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center text-zinc-400 hover:bg-white hover:text-black hover:border-white transition-all"
                                        aria-label="Next testimonial"
                                    >
                                        <iconify-icon icon="lucide:arrow-right" class="text-xl"></iconify-icon>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            @endif

            <!-- Footer Component -->
            <x-layout.footer />
        </main>
    </div>
</x-layout.public>