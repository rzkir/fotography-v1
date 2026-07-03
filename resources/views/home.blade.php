<x-layout.public title="Noir/Studio - Fine Art Portfolio">
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]" data-home-page>
        <div class="diagonal-line" style="top: 10%"></div>
        <div class="diagonal-line" style="top: 40%"></div>
        <div class="diagonal-line" style="top: 70%"></div>

        <!-- NavigationBar Component -->
        <x-layout.header />

        <main class="relative z-0">
            <!-- Hero Section -->
            <section class="pt-40 px-6 md:px-12" data-aos-hero>
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-7 relative z-10 flex flex-col justify-center lg:pr-12">
                        <div class="mb-12 relative">
                            <span class="absolute -top-12 left-0 text-xs font-bold tracking-[0.5em] text-zinc-500 uppercase" data-aos="fade-down" data-aos-offset="0">Est. 2016 — Fine Art Portfolio</span>
                            <h1 class="text-6xl sm:text-8xl lg:text-[13rem] font-display font-black leading-[0.8] tracking-tighter uppercase mb-6" data-aos="fade-right" data-aos-offset="0">Beyond<br/>Vision</h1>
                            <p class="font-serif italic text-2xl sm:text-4xl lg:text-6xl text-zinc-400 leading-tight" data-aos="fade-right" data-aos-delay="100" data-aos-offset="0">The art of capturing what stays <span class="inline-block text-[#f5f2ed] border-b border-zinc-700" data-aos="fade-up" data-aos-delay="180" data-aos-offset="0">unseen</span>.</p>
                        </div>
                        <div class="max-w-xl space-y-8">
                            <p class="text-zinc-500 font-light leading-relaxed" data-aos="fade-right" data-aos-delay="200" data-aos-offset="0">I am a visionary photographer pushing the boundaries of portraiture. Through minimal lighting and cinematic composition, I reveal the raw essence of every subject.</p>
                            <div class="flex flex-wrap gap-4 text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                                <span class="inline-block px-4 py-2 border border-zinc-800 rounded-full" data-aos="fade-up" data-aos-delay="250" data-aos-offset="0">Studio Sessions</span>
                                <span class="inline-block px-4 py-2 border border-zinc-800 rounded-full" data-aos="fade-up" data-aos-delay="300" data-aos-offset="0">Editorial Shoots</span>
                                <span class="inline-block px-4 py-2 border border-zinc-800 rounded-full" data-aos="fade-up" data-aos-delay="350" data-aos-offset="0">Fashion Photography</span>
                                <span class="inline-block px-4 py-2 border border-zinc-800 rounded-full" data-aos="fade-up" data-aos-delay="400" data-aos-offset="0">Fine Art Portraits</span>
                                <span class="inline-block px-4 py-2 border border-zinc-800 rounded-full" data-aos="fade-up" data-aos-delay="450" data-aos-offset="0">Commercial Work</span>
                            </div>
                            <div class="flex items-center space-x-8 pt-4">
                                <a href="#team" id="hero-primary-cta" class="group flex items-center space-x-4" data-aos="fade-up" data-aos-delay="500" data-aos-offset="0">
                                    <div class="w-16 h-16 rounded-full border border-zinc-700 flex items-center justify-center group-hover:bg-white group-hover:border-white transition-all duration-500">
                                        <iconify-icon icon="lucide:arrow-up-right" class="text-2xl group-hover:text-black transition-colors"></iconify-icon>
                                    </div>
                                    <span class="inline-block text-xs font-bold uppercase tracking-[0.2em]" data-aos="fade-up" data-aos-delay="550" data-aos-offset="0">Studio Team</span>
                                </a>
                                <div class="flex flex-col">
                                    <span class="inline-block text-xs text-zinc-500 uppercase tracking-widest mb-1" data-aos="fade-left" data-aos-delay="600" data-aos-offset="0">Based in Jakarta</span>
                                    <span class="inline-block text-sm font-medium" data-aos="fade-left" data-aos-delay="700" data-aos-offset="0">Available Globally / 2024</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-5 relative z-0 mt-24 lg:mt-0">
                        <div class="relative aspect-3/4 overflow-hidden rounded-sm group">
                            <div class="absolute inset-0" data-aos="fade-left" data-aos-delay="150" data-aos-offset="0">
                                <img src="{{ asset('assets/hero.avif') }}" alt="Dramatic Portrait" class="h-full w-full object-cover grayscale mask-image transition-transform duration-[2s] group-hover:scale-110">
                            </div>
                            <div class="absolute bottom-8 right-8 z-10 text-right">
                                <span class="inline-block text-xs font-bold uppercase tracking-widest text-white/50" data-aos="fade-up" data-aos-delay="400" data-aos-offset="0">Model: Sophia K.</span>
                                <span class="inline-block text-xs font-bold uppercase tracking-widest text-white/50" data-aos="fade-up" data-aos-delay="450" data-aos-offset="0">Series: Midnight Soul</span>
                            </div>
                        </div>
                        <div class="absolute -top-12 -left-12 w-48 h-48 bg-zinc-900 hidden xl:flex items-center justify-center text-center p-8 rounded-full border border-zinc-800">
                            <p class="text-xs font-bold leading-tight uppercase tracking-widest" data-aos="zoom-in" data-aos-delay="350" data-aos-offset="0">Shot on 35mm Analog Film</p>
                        </div>
                    </div>
                </div>
            </section>

            @if($features->isNotEmpty())
                <section class="py-20 px-6 md:px-12">
                    <div class="container mx-auto">
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
                                    <h3 class="text-5xl font-display font-black" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">{{ $feature->number }}+</h3>
                                    <p class="text-xs font-bold uppercase tracking-[0.4em] text-zinc-500" data-aos="fade-up" data-aos-delay="{{ ($loop->index * 100) + 50 }}">{{ $feature->title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if($teams->isNotEmpty())
                <!-- Featured Team -->
                <section id="team" class="py-20 px-6 md:px-12">
                    <div class="flex flex-col lg:flex-row justify-between items-end mb-12 gap-8">
                        <div class="max-w-2xl">
                            <span class="text-xs font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-4" data-aos="fade-up">The Collective</span>
                            <h2 class="text-7xl font-display font-black uppercase tracking-tighter" data-aos="fade-up" data-aos-delay="100">Studio<br/><span class="font-serif italic capitalize text-zinc-400">Team</span></h2>
                        </div>
                        <a href="{{ route('contact') }}#team" id="view-all-team" class="text-xs font-bold uppercase tracking-widest border-b border-zinc-800 hover:border-white transition-all" data-aos="fade-left" data-aos-delay="150">Meet The Crew</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($teams as $index => $team)
                            @php
                                $featuredPortfolio = $team->portfolios->first();
                            @endphp
                            @if ($featuredPortfolio)
                                <a
                                    href="{{ route('works.show', $featuredPortfolio) }}"
                                    class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900 block {{ $index % 2 === 1 ? 'lg:mt-12' : '' }}"
                                >
                            @else
                                <article class="project-card group relative aspect-3/4 overflow-hidden bg-zinc-900 block {{ $index % 2 === 1 ? 'lg:mt-12' : '' }}">
                            @endif
                                @if ($team->pictureUrl())
                                    <img
                                        src="{{ $team->pictureUrl() }}"
                                        alt="{{ $team->name }}"
                                        class="h-full w-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110"
                                        data-aos="fade-up"
                                        data-aos-delay="{{ $index * 100 }}"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-zinc-900" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                        <iconify-icon icon="lucide:user-round" class="text-4xl text-zinc-700"></iconify-icon>
                                    </div>
                                @endif
                                <div class="absolute inset-0 flex flex-col justify-end bg-black/60 p-8 project-overlay">
                                    <span class="mb-2 text-xs font-bold uppercase text-zinc-400" data-aos="fade-up" data-aos-delay="{{ ($index * 100) + 50 }}">
                                        {{ $team->number }} {{ Str::plural('project', $team->number) }}
                                    </span>
                                    <h3 class="text-2xl font-display font-black uppercase" data-aos="fade-up" data-aos-delay="{{ ($index * 100) + 100 }}">
                                        {{ $team->name }}
                                    </h3>
                                    <p class="mt-2 text-[10px] font-bold uppercase tracking-widest text-zinc-500" data-aos="fade-up" data-aos-delay="{{ ($index * 100) + 150 }}">
                                        {{ $team->job }}
                                    </p>
                                </div>
                            @if ($featuredPortfolio)
                                </a>
                            @else
                                </article>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Marquee Section -->
            <section class="py-20 overflow-hidden border-t border-zinc-900">
                <div class="marquee-text flex space-x-12 items-center">
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
            <section class="py-20 px-6 md:px-12 bg-zinc-900/30">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-5">
                        <span class="text-xs font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-8" data-aos="fade-up">About the Artist</span>
                        <h2 class="text-6xl font-display font-black leading-[0.9] uppercase mb-12" data-aos="fade-up" data-aos-delay="100">The Eye<br/>Behind<br/>The Lens</h2>
                        <div class="space-y-6 text-zinc-400 font-light leading-relaxed">
                            <p data-aos="fade-up" data-aos-delay="200">Noir/Studio was founded on the belief that photography should not just record a person, but interpret their story. My approach is rooted in 8+ years of professional exploration, focusing on the intersection of fine art and editorial storytelling.</p>
                            <p data-aos="fade-up" data-aos-delay="300">I specialize in capturing raw, authentic moments using a minimalists lens, often working with high-contrast shadows to bring out the depth of human expression.</p>
                            <a href="#" id="about-session-cta" class="inline-flex items-center space-x-4 pt-8 group" data-aos="fade-up" data-aos-delay="400">
                                <div class="w-12 h-12 rounded-full border border-zinc-700 flex items-center justify-center group-hover:bg-white transition-all">
                                    <iconify-icon icon="lucide:arrow-right" class="group-hover:text-black"></iconify-icon>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-widest">Book A Session</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6 lg:col-start-7 mt-20 lg:mt-0 grid grid-cols-2 gap-8">
                        <div class="aspect-square bg-zinc-900 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale" data-aos="fade-left" data-aos-delay="200">
                        </div>
                        <div class="aspect-square bg-zinc-900 overflow-hidden mt-12">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=800" class="w-full h-full object-cover grayscale" data-aos="fade-left" data-aos-delay="300">
                        </div>
                    </div>
                </div>
            </section>

            @if($testimonials->isNotEmpty())
                <section class="py-20 px-6 md:px-12" id="testimonials-slider" aria-label="Client Testimonials">
                    <div class="container mx-auto text-center">
                        <span class="text-xs font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-12" data-aos="fade-up">Client Testimonials</span>

                        <div class="relative">
                            <div class="overflow-hidden">
                                <div id="testimonial-track" class="testimonial-track flex">
                                    @foreach($testimonials as $testimonial)
                                        <article class="w-full shrink-0 space-y-8 px-4" data-testimonial-slide>
                                            <iconify-icon icon="mdi:format-quote-close" class="text-6xl text-zinc-800"></iconify-icon>
                                            <p class="text-2xl sm:text-3xl font-serif italic text-zinc-300 leading-relaxed" @if($loop->first) data-aos="fade-up" data-aos-delay="100" @endif>"{{ $testimonial->message }}"</p>
                                            <div class="flex flex-col items-center">
                                                <span class="text-sm font-bold uppercase tracking-widest" @if($loop->first) data-aos="fade-up" data-aos-delay="200" @endif>{{ $testimonial->name }}</span>
                                                <span class="text-[10px] text-zinc-600 uppercase tracking-widest" @if($loop->first) data-aos="fade-up" data-aos-delay="250" @endif>{{ $testimonial->jobs }}, {{ $testimonial->company }}</span>
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