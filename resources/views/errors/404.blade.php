<x-layout.public title="404 Asymmetrical | Noir/Studio">
    <div class="min-h-screen flex flex-col relative bg-[#0d0d0d]" data-error-page>
        <div class="error-grain-bg" aria-hidden="true"></div>

        <x-layout.header />

        <main class="relative z-10 flex-1 flex flex-col md:flex-row border-t border-white/10">
            <section class="w-full md:w-3/5 flex items-center justify-center border-b md:border-b-0 md:border-r border-white/10 pt-32 pb-16 md:py-0 overflow-hidden">
                <h1 class="font-display font-black text-[15rem] sm:text-[20rem] lg:text-[35rem] leading-none tracking-[-0.08em] select-none">
                    404
                </h1>
            </section>

            <section class="w-full md:w-2/5 flex flex-col justify-between pt-16 md:pt-48 pb-24 px-8 md:px-16">
                <div class="max-w-md">
                    <span class="inline-block px-3 py-1 border border-white/10 text-[10px] uppercase tracking-[0.4em] font-bold mb-8">
                        System Alert
                    </span>

                    <h2 class="font-display font-bold text-5xl md:text-7xl uppercase leading-[0.9] mb-8">
                        LOST IN THE<br>PROCESS
                    </h2>

                    <p class="font-serif italic text-2xl mb-12 opacity-80">
                        The image you are looking for has not been developed yet, or it was discarded in the darkroom.
                    </p>

                    <div class="flex flex-col gap-4">
                        <a href="{{ route('home') }}" id="err-nav-home" class="btn-noir group">
                            <span>Return to Surface</span>
                            <iconify-icon icon="lucide:arrow-right" class="text-lg group-hover:translate-x-2 transition-transform"></iconify-icon>
                        </a>

                        <a href="{{ route('works.index') }}" id="err-nav-works" class="btn-noir btn-noir--muted group">
                            <span>Browse Archive</span>
                            <iconify-icon icon="lucide:grid" class="text-lg"></iconify-icon>
                        </a>
                    </div>
                </div>

                <div class="mt-20 md:mt-0 pt-12 border-t border-white/10 flex items-start gap-12">
                    <div class="text-[10px] uppercase tracking-widest opacity-40 leading-relaxed">
                        Noir Studio &copy; {{ date('Y') }}<br>Internal Server Response
                    </div>
                    <div class="text-[10px] uppercase tracking-widest opacity-40 leading-relaxed">
                        Coordinates<br>40.7128&deg; N, 74.0060&deg; W
                    </div>
                </div>
            </section>
        </main>

        <x-layout.footer-minimal />
    </div>
</x-layout.public>
