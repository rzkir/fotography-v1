@props([
    'blendNav' => true,
    'active' => null,
])

@php
    $activeNav = $active ?? match (true) {
        request()->routeIs('home') => 'home',
        request()->routeIs('works.*') => 'works',
        request()->routeIs('gallery.*') => 'gallery',
        request()->routeIs('journal.*') => 'journal',
        request()->routeIs('contact') => 'contact',
        default => null,
    };

    $navItems = [
        ['id' => 'nav-home', 'label' => 'Home', 'route' => 'home', 'key' => 'home', 'delay' => 80],
        ['id' => 'nav-works', 'label' => 'Selected Works', 'route' => 'works.index', 'key' => 'works', 'delay' => 120],
        ['id' => 'nav-gallery', 'label' => 'Gallery', 'route' => 'gallery.index', 'key' => 'gallery', 'delay' => 160],
        ['id' => 'nav-journal', 'label' => 'Journal', 'route' => 'journal.index', 'key' => 'journal', 'delay' => 200],
        ['id' => 'nav-contact', 'label' => 'Contact', 'route' => 'contact', 'key' => 'contact', 'delay' => 240],
    ];
@endphp

<header data-site-header>
    <nav
        data-site-nav
        data-aos-header
        @class([
            'site-nav fixed top-0 left-0 z-50 w-full flex justify-between items-center py-6 md:py-8 px-6 md:px-12 lg:px-16',
            'mix-blend-difference' => $blendNav,
        ])
    >
        <a
            href="{{ route('home') }}"
            id="brand-logo"
            class="font-display font-extrabold text-2xl tracking-tighter uppercase text-white"
            data-aos="fade-down"
            data-aos-offset="0"
        >
            Noir<span class="text-zinc-600">/</span>Studio
        </a>

        <div class="flex items-center space-x-8 md:space-x-12">
            <div class="hidden md:flex items-center space-x-8 lg:space-x-12 text-sm uppercase tracking-widest text-white">
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        id="{{ $item['id'] }}"
                        @class([
                            'transition-opacity hover:opacity-100',
                            'opacity-100' => $activeNav === $item['key'],
                            'opacity-60' => $activeNav !== $item['key'],
                        ])
                        @if ($activeNav === $item['key']) aria-current="page" @endif
                        data-aos="fade-down"
                        data-aos-delay="{{ $item['delay'] }}"
                        data-aos-offset="0"
                    >{{ $item['label'] }}</a>
                @endforeach
            </div>

            <button
                type="button"
                data-menu-toggle
                class="flex md:hidden items-center space-x-4 text-white group"
                aria-label="Open menu"
                aria-expanded="false"
                aria-controls="site-menu"
                data-aos="fade-down"
                data-aos-delay="280"
                data-aos-offset="0"
            >
                <span class="text-sm uppercase tracking-widest group-hover:opacity-60 transition-opacity" data-menu-label>Menu</span>
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
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        data-menu-link
                        @class([
                            'site-menu__link block py-3 text-4xl sm:text-5xl font-display font-black uppercase tracking-tighter transition-colors',
                            'text-white' => $activeNav === $item['key'],
                            'text-zinc-500 hover:text-white' => $activeNav !== $item['key'],
                        ])
                        @if ($activeNav === $item['key']) aria-current="page" @endif
                    >{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <p class="relative z-10 mt-16 text-[10px] font-bold uppercase tracking-[0.4em] text-zinc-600">
                Noir Studio — Fine Art Portfolio
            </p>
        </div>
    </div>
</header>
