<div
    id="splash-screen"
    data-splash-screen
    class="splash-screen fixed inset-0 z-9999 flex items-center justify-center bg-[#0d0d0d] overflow-hidden"
    aria-hidden="true"
    aria-label="Loading Noir Studio"
>
    <div class="diagonal-line" style="top: 18%"></div>
    <div class="diagonal-line" style="top: 52%"></div>
    <div class="diagonal-line" style="top: 82%"></div>

    <div class="relative z-10 flex flex-col items-center text-center px-6" data-splash-content>
        <span
            class="splash-fade-up mb-10 text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500"
            style="--splash-delay: 0.15s"
        >
            Est. 2016 — Fine Art Portfolio
        </span>

        <h1
            class="splash-fade-up text-5xl sm:text-7xl md:text-8xl font-display font-black uppercase tracking-tighter leading-none"
            style="--splash-delay: 0.3s"
        >
            Noir<span class="text-zinc-600">/</span>Studio
        </h1>

        <p
            class="splash-fade-up mt-6 font-serif italic text-xl sm:text-2xl text-zinc-400"
            style="--splash-delay: 0.5s"
        >
            Beyond <span class="text-[#f5f2ed]">Vision</span>
        </p>

        <div
            class="splash-fade-up mt-16 w-56 sm:w-64"
            style="--splash-delay: 0.65s"
        >
            <div class="h-px w-full bg-zinc-800 overflow-hidden">
                <div
                    data-splash-progress
                    class="h-full w-0 bg-[#f5f2ed] transition-[width] duration-300 ease-out"
                ></div>
            </div>
            <div class="mt-4 flex items-center justify-between text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-500">
                <span>Loading</span>
                <span data-splash-counter>000</span>
            </div>
        </div>
    </div>

    <div
        data-splash-curtain
        class="splash-curtain pointer-events-none absolute inset-0 z-20 bg-[#0d0d0d] translate-y-full"
    ></div>
</div>
