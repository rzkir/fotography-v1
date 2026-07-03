@props(['active' => 'workspace'])

@php
    $portfolioOpen = in_array($active, ['projects', 'portfolio', 'portfolio-categories']);
    $journalOpen = in_array($active, ['journal', 'journal-categories']);
@endphp

<aside id="sidebar" class="fixed left-0 top-0 h-full bg-[#0d0d0d] z-50 flex flex-col">
    <div class="p-6 lg:p-8 flex items-center gap-4 overflow-hidden">
        <div class="w-10 h-10 bg-linear-to-tr from-[#ff6b35] to-[#fb7185] rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-orange-500/20">
            <iconify-icon icon="lucide:camera" class="text-white text-2xl"></iconify-icon>
        </div>
        <a href="/" class="nav-text font-display font-black text-2xl tracking-tighter whitespace-nowrap">
            Noir<span class="text-zinc-600">/</span>Studio
        </a>
    </div>

    <nav class="flex-1 px-5 py-4 space-y-8 overflow-y-auto custom-scroll">
        <div class="space-y-1">
            <p class="group-title text-[10px] uppercase tracking-[0.2em] text-zinc-600 font-black px-3 mb-4">Studio</p>

            <a
                href="{{ route('dashboard.index') }}"
                id="nav-workspace"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all',
                    'bg-white/5 text-white font-semibold shadow-inner' => $active === 'workspace',
                    'text-zinc-400 hover:text-white hover:bg-white/5' => $active !== 'workspace',
                ])
            >
                <iconify-icon
                    icon="lucide:layout-dashboard"
                    @class([
                        'text-xl shrink-0',
                        'text-[#ff6b35]' => $active === 'workspace',
                    ])
                ></iconify-icon>
                <span class="nav-text">Overview</span>
            </a>

            <div class="dropdown-container">
                <button
                    type="button"
                    onclick="toggleDropdown('portfolio-dropdown', this)"
                    @class([
                        'nav-item flex items-center justify-between w-full gap-3 px-3 py-3 rounded-xl transition-all group',
                        'bg-white/5 text-white' => $portfolioOpen,
                        'text-zinc-400 hover:text-white hover:bg-white/5' => ! $portfolioOpen,
                    ])
                >
                    <div class="flex items-center gap-3">
                        <iconify-icon icon="lucide:gallery-horizontal-end" class="text-xl shrink-0 group-hover:text-teal-400"></iconify-icon>
                        <span class="nav-text">Portfolio</span>
                    </div>
                    <iconify-icon icon="lucide:chevron-down" @class(['chevron chevron-rotate text-sm', 'rotate-180' => $portfolioOpen])></iconify-icon>
                </button>
                <div id="portfolio-dropdown" @class(['dropdown-content ml-9 space-y-1 mt-1 border-l border-zinc-800 pl-4', 'open' => $portfolioOpen])>
                    <a
                        id="nav-projects"
                        href="{{ route('dashboard.portofolio.index') }}"
                        @class([
                            'block py-2 text-sm transition-colors',
                            'text-[#fb7185]' => $active === 'projects',
                            'text-zinc-500 hover:text-[#fb7185]' => $active !== 'projects',
                        ])
                    >
                        All Projects
                    </a>
                    <a
                        id="nav-portfolio-categories"
                        href="{{ route('dashboard.portofolio.category.index') }}"
                        @class([
                            'block py-2 text-sm transition-colors',
                            'text-[#fb7185]' => $active === 'portfolio-categories',
                            'text-zinc-500 hover:text-[#fb7185]' => $active !== 'portfolio-categories',
                        ])
                    >
                        Categories
                    </a>
                </div>
            </div>

            <a
                href="/works"
                id="nav-gallery"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all group',
                    'bg-white/5 text-white font-semibold' => $active === 'gallery',
                    'text-zinc-400 hover:text-white hover:bg-white/5' => $active !== 'gallery',
                ])
            >
                <iconify-icon icon="lucide:images" class="text-xl shrink-0 group-hover:text-rose-400"></iconify-icon>
                <span class="nav-text">Cloud Assets</span>
            </a>
        </div>

        <div class="space-y-1">
            <p class="group-title text-[10px] uppercase tracking-[0.2em] text-zinc-600 font-black px-3 mb-4">Reputation</p>

            <a
                href="{{ route('dashboard.testimonials.index') }}"
                id="nav-testimonials"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all group',
                    'bg-white/5 text-white font-semibold shadow-inner' => $active === 'testimonials',
                    'text-zinc-400 hover:text-white hover:bg-white/5' => $active !== 'testimonials',
                ])
            >
                <iconify-icon
                    icon="lucide:star"
                    @class([
                        'text-xl shrink-0',
                        'text-[#ff6b35]' => $active === 'testimonials',
                        'group-hover:text-[#ff6b35]' => $active !== 'testimonials',
                    ])
                ></iconify-icon>
                <span class="nav-text">Testimonials</span>
            </a>

            <a
                href="{{ route('dashboard.features.index') }}"
                id="nav-features"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all group',
                    'bg-white/5 text-white font-semibold shadow-inner' => $active === 'features',
                    'text-zinc-400 hover:text-white hover:bg-white/5' => $active !== 'features',
                ])
            >
                <iconify-icon
                    icon="lucide:sparkles"
                    @class([
                        'text-xl shrink-0',
                        'text-teal-400' => $active === 'features',
                        'group-hover:text-teal-400' => $active !== 'features',
                    ])
                ></iconify-icon>
                <span class="nav-text">Features</span>
            </a>
        </div>

        <div class="space-y-1">
            <p class="group-title text-[10px] uppercase tracking-[0.2em] text-zinc-600 font-black px-3 mb-4">Productivity</p>

            <div class="dropdown-container">
                <button
                    type="button"
                    onclick="toggleDropdown('journal-dropdown', this)"
                    @class([
                        'nav-item flex items-center justify-between w-full gap-3 px-3 py-3 rounded-xl transition-all group',
                        'bg-white/5 text-white' => $journalOpen,
                        'text-zinc-400 hover:text-white hover:bg-white/5' => ! $journalOpen,
                    ])
                >
                    <div class="flex items-center gap-3">
                        <iconify-icon icon="lucide:book-open" class="text-xl shrink-0 group-hover:text-blue-400"></iconify-icon>
                        <span class="nav-text">Journal</span>
                    </div>
                    <iconify-icon icon="lucide:chevron-down" @class(['chevron chevron-rotate text-sm', 'rotate-180' => $journalOpen])></iconify-icon>
                </button>
                <div id="journal-dropdown" @class(['dropdown-content ml-9 space-y-1 mt-1 border-l border-zinc-800 pl-4', 'open' => $journalOpen])>
                    <a
                        id="nav-journal"
                        href="{{ route('dashboard.jurnal.index') }}"
                        @class([
                            'block py-2 text-sm transition-colors',
                            'text-white' => $active === 'journal',
                            'text-zinc-500 hover:text-white' => $active !== 'journal',
                        ])
                    >
                        All Articles
                    </a>
                    <a
                        id="nav-journal-categories"
                        href="{{ route('dashboard.jurnal.category.index') }}"
                        @class([
                            'block py-2 text-sm transition-colors',
                            'text-white' => $active === 'journal-categories',
                            'text-zinc-500 hover:text-white' => $active !== 'journal-categories',
                        ])
                    >
                        Categories
                    </a>
                </div>
            </div>

            <a
                href="/contact"
                id="nav-schedule"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all group',
                    'bg-white/5 text-white font-semibold' => $active === 'schedule',
                    'text-zinc-400 hover:text-white hover:bg-white/5' => $active !== 'schedule',
                ])
            >
                <iconify-icon icon="lucide:calendar-range" class="text-xl shrink-0 group-hover:text-yellow-400"></iconify-icon>
                <span class="nav-text">Shooting Plan</span>
            </a>
        </div>

        <div class="space-y-1">
            <p class="group-title text-[10px] uppercase tracking-[0.2em] text-zinc-600 font-black px-3 mb-4">Account</p>

            <a
                href="{{ route('dashboard.profile.index') }}"
                id="nav-profile"
                @class([
                    'nav-item flex items-center gap-3 px-3 py-3 rounded-xl transition-all group',
                    'bg-white/5 text-white font-semibold shadow-inner' => in_array($active, ['profile', 'profile-password']),
                    'text-zinc-400 hover:text-white hover:bg-white/5' => ! in_array($active, ['profile', 'profile-password']),
                ])
            >
                <iconify-icon
                    icon="lucide:user"
                    @class([
                        'text-xl shrink-0',
                        'text-[#fb7185]' => in_array($active, ['profile', 'profile-password']),
                        'group-hover:text-[#fb7185]' => ! in_array($active, ['profile', 'profile-password']),
                    ])
                ></iconify-icon>
                <span class="nav-text">Profile Settings</span>
            </a>
        </div>

        <div class="promo-card mt-auto p-4 mx-1 rounded-2xl bg-linear-to-br from-zinc-900 to-black border border-white/5 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-[#ff6b35]/10 rounded-full blur-2xl group-hover:bg-[#ff6b35]/20 transition-all"></div>
            <p class="text-[10px] font-bold text-zinc-500 mb-1">STORAGE</p>
            <p class="text-sm font-bold mb-3">82% Full (4.1 TB)</p>
            <div class="w-full h-1 bg-zinc-800 rounded-full overflow-hidden mb-4">
                <div class="h-full bg-linear-to-r from-[#ff6b35] to-[#fb7185] w-[82%]"></div>
            </div>
            <a id="nav-upgrade" href="/contact" class="block text-center py-2 bg-[#f5f2ed] text-[#0d0d0d] rounded-lg text-xs font-black hover:scale-[1.02] transition-transform">
                UPGRADE PLAN
            </a>
        </div>
    </nav>

    <div class="p-6 border-t border-white/5">
        <div class="flex items-center gap-3 p-2 bg-white/5 rounded-2xl">
            <img
                src="https://api.dicebear.com/7.x/shapes/svg?seed={{ rawurlencode(auth()->user()->name) }}"
                class="w-10 h-10 rounded-xl object-cover"
                alt="{{ auth()->user()->name }}"
            >
            <div class="user-info flex flex-col overflow-hidden">
                <span class="text-sm font-bold whitespace-nowrap">{{ auth()->user()->name }}</span>
                <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider">Pro Photographer</span>
            </div>
        </div>
    </div>
</aside>
