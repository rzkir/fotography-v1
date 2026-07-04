<header data-site-header>
    <nav
        data-site-nav
        data-aos-header
        class="site-nav fixed top-0 left-0 z-50 w-full mix-blend-difference flex justify-between items-center py-5 px-6 md:px-12"
    >
        <a
            href="{{ route('home') }}"
            id="brand-logo"
            class="text-3xl font-display font-black tracking-tighter uppercase text-white"
            data-aos="fade-down"
            data-aos-offset="0"
        >
            Noir<span class="text-zinc-600">/</span>Studio
        </a>

        <div class="flex items-center space-x-8 md:space-x-12">
            <div class="hidden md:flex space-x-8 text-[10px] font-bold uppercase tracking-[0.3em] text-white">
                <a
                    href="{{ route('home') }}"
                    id="nav-home"
                    class="transition-colors hover:text-zinc-400"
                    data-aos="fade-down"
                    data-aos-delay="80"
                    data-aos-offset="0"
                >Home</a>
                <a
                    href="{{ route('works.index') }}"
                    id="nav-works"
                    class="transition-colors hover:text-zinc-400"
                    data-aos="fade-down"
                    data-aos-delay="120"
                    data-aos-offset="0"
                >Selected Works</a>
                <a
                    href="{{ route('journal.index') }}"
                    id="nav-journal"
                    class="transition-colors hover:text-zinc-400"
                    data-aos="fade-down"
                    data-aos-delay="160"
                    data-aos-offset="0"
                >Journal</a>
                <a
                    href="{{ route('contact') }}"
                    id="nav-contact"
                    class="transition-colors hover:text-zinc-400"
                    data-aos="fade-down"
                    data-aos-delay="200"
                    data-aos-offset="0"
                >Contact</a>
            </div>

            <button
                type="button"
                data-menu-toggle
                class="flex md:hidden items-center space-x-2 text-white"
                aria-label="Open menu"
                aria-expanded="false"
                aria-controls="site-menu"
                data-aos="fade-down"
                data-aos-delay="240"
                data-aos-offset="0"
            >
                <span class="text-[10px] font-bold uppercase tracking-widest" data-menu-label>Menu</span>
                <iconify-icon icon="lucide:menu" class="text-2xl" data-menu-icon></iconify-icon>
            </button>
        </div>
    </nav>

    <div
        id="site-menu"
        data-site-menu
        class="site-menu fixed inset-0 z-60 bg-[#0d0d0d]/98 backdrop-blur-xl md:hidden"
        aria-hidden="true"
    >
        <div data-menu-backdrop class="absolute inset-0" aria-hidden="true"></div>

        <div class="relative z-10 flex h-full flex-col justify-center px-6">
            <div class="diagonal-line" style="top: 20%"></div>
            <div class="diagonal-line" style="top: 55%"></div>
            <div class="diagonal-line" style="top: 80%"></div>

            <nav class="relative z-10 space-y-2 md:space-y-4" aria-label="Mobile navigation">
                <a
                    href="{{ route('home') }}"
                    data-menu-link
                    class="site-menu__link block py-3 text-4xl sm:text-5xl md:text-7xl font-display font-black uppercase tracking-tighter text-white transition-colors hover:text-zinc-400"
                >Home</a>
                <a
                    href="{{ route('works.index') }}"
                    data-menu-link
                    class="site-menu__link block py-3 text-4xl sm:text-5xl md:text-7xl font-display font-black uppercase tracking-tighter text-white transition-colors hover:text-zinc-400"
                >Selected Works</a>
                <a
                    href="{{ route('journal.index') }}"
                    data-menu-link
                    class="site-menu__link block py-3 text-4xl sm:text-5xl md:text-7xl font-display font-black uppercase tracking-tighter text-white transition-colors hover:text-zinc-400"
                >Journal</a>
                <a
                    href="{{ route('contact') }}"
                    data-menu-link
                    class="site-menu__link block py-3 text-4xl sm:text-5xl md:text-7xl font-display font-black uppercase tracking-tighter text-white transition-colors hover:text-zinc-400"
                >Contact</a>
            </nav>

            <p class="relative z-10 mt-16 text-[10px] font-bold uppercase tracking-[0.4em] text-zinc-600">
                Noir Studio — Fine Art Portfolio
            </p>
        </div>
    </div>
</header>
