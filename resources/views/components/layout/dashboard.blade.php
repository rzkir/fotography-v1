@props([
    'title' => 'Dashboard',
    'active' => 'workspace',
    'contentClass' => '',
])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&family=Space+Grotesk:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d0d0d;
            --accent-color: #f5f2ed;
            --color-orange: #ff6b35;
            --color-teal: #14b8a6;
            --color-coral: #fb7185;
            --sidebar-w: 280px;
            --sidebar-collapsed-w: 80px;
        }
        html {
            height: 100%;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--accent-color);
            overflow-x: hidden;
            min-height: 100dvh;
            margin: 0;
        }
        h1, h2, h3, .font-display {
            font-family: 'Space Grotesk', sans-serif;
        }
        #sidebar {
            width: var(--sidebar-w);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(245, 242, 237, 0.05);
        }
        #sidebar.collapsed {
            width: var(--sidebar-collapsed-w);
        }
        #sidebar.collapsed .nav-text,
        #sidebar.collapsed .chevron,
        #sidebar.collapsed .group-title,
        #sidebar.collapsed .promo-card {
            display: none;
        }
        #sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 12px 0;
        }
        #main-content {
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: var(--sidebar-w);
        }
        #main-content.sidebar-collapsed {
            margin-left: var(--sidebar-collapsed-w);
        }
        .dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .dropdown-content.open {
            max-height: 500px;
        }
        .chevron-rotate {
            transition: transform 0.2s;
        }
        .rotate-180 {
            transform: rotate(180deg);
        }
        .card-photography {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .card-photography:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-4px);
        }
        .gradient-text {
            background: linear-gradient(to right, #ff6b35, #fb7185);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass {
            background: rgba(245, 242, 237, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(245, 242, 237, 0.08);
        }
        .glass-hover:hover {
            background: rgba(245, 242, 237, 0.06);
            border: 1px solid rgba(245, 242, 237, 0.15);
            transition: all 0.3s ease;
        }
        .card-gradient {
            background: linear-gradient(135deg, rgba(245, 242, 237, 0.05) 0%, rgba(245, 242, 237, 0) 100%);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(245, 242, 237, 0.1);
            border-radius: 1.25rem;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            color: #f5f2ed;
            outline: none;
            transition: all 0.3s ease;
            width: 100%;
        }
        .input-field:focus {
            border-color: rgba(255, 107, 53, 0.5);
            background: rgba(255, 255, 255, 0.08);
        }
        .input-field::placeholder {
            color: rgba(245, 242, 237, 0.3);
        }
        select.input-field option {
            background: #0d0d0d;
            color: #f5f2ed;
        }
        .custom-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(245, 242, 237, 0.28) transparent;
            scrollbar-gutter: stable;
        }
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(245, 242, 237, 0.1);
            border-radius: 10px;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(245, 242, 237, 0.28);
        }
        .page-content-enter {
            animation: page-content-enter 0.35s ease-out forwards;
        }
        @keyframes page-content-enter {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .dialog-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
        }
        .dialog-panel {
            position: relative;
            z-index: 10;
            background: #181818;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow:
                0 0 0 1px rgba(0, 0, 0, 0.35),
                0 28px 64px rgba(0, 0, 0, 0.7);
        }
    </style>
    <title>Noir/Studio - {{ $title }}</title>
</head>
<body>
    <div class="flex min-h-screen relative">
        <x-layout.sidebar :active="$active" />

        <main id="main-content" class="flex-1 min-w-0">
            @isset($header)
                {{ $header }}
            @else
                <header class="sticky top-0 z-40 bg-[#0d0d0d]/90 backdrop-blur-xl px-6 lg:px-10 h-24 flex items-center justify-between">
                    <div class="flex flex-col min-w-0">
                        <h1 class="text-xl lg:text-2xl font-display font-black tracking-tight leading-none truncate">Studio Dashboard</h1>
                        <p class="text-[10px] text-zinc-500 font-bold tracking-widest mt-1 hidden sm:block">
                            PRESS <span class="text-[#ff6b35]">CTRL + B</span> TO TOGGLE SIDEBAR
                        </p>
                    </div>
                    <div class="flex items-center gap-3 lg:gap-6 shrink-0">
                        <div class="relative hidden md:block">
                            <input
                                type="text"
                                placeholder="Search projects..."
                                class="bg-white/5 border border-white/10 rounded-xl px-5 py-2.5 w-48 lg:w-64 text-sm focus:outline-none focus:border-[#ff6b35] transition-all"
                            >
                            <iconify-icon icon="lucide:search" class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-500"></iconify-icon>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-layout.profile />
                        </div>
                    </div>
                </header>
            @endisset

            <section class="p-6 lg:p-10 max-w-[1600px] mx-auto {{ $contentClass }}">
                @if (session('success'))
                    <div class="mb-6 px-6 py-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="page-content-enter">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </div>

    <div
        id="crud-loading-overlay"
        class="fixed inset-0 z-300 hidden items-center justify-center bg-black/60 backdrop-blur-sm"
        aria-live="polite"
        aria-busy="true"
    >
        <div class="flex flex-col items-center gap-4 rounded-4xl border border-white/10 bg-[#181818] px-10 py-8 shadow-2xl">
            <x-ui.spiner size="lg" />
            <p data-crud-overlay-message class="text-xs font-black uppercase tracking-[0.2em] text-zinc-300">
                Processing...
            </p>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')
    @vite(['resources/js/app.js'])

    <script>
        function toggleDropdown(id, btn) {
            const content = document.getElementById(id);
            const chevron = btn.querySelector('.chevron');
            content.classList.toggle('open');
            chevron.classList.toggle('rotate-180');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('sidebar-collapsed');
        }

        function initDashboardProfile() {
            const profile = document.querySelector('[data-dashboard-profile]');

            if (!profile) {
                return;
            }

            const toggle = profile.querySelector('[data-dashboard-profile-toggle]');
            const menu = profile.querySelector('[data-dashboard-profile-menu]');
            const chevron = profile.querySelector('[data-dashboard-profile-chevron]');

            const closeMenu = () => {
                menu?.classList.add('hidden');
                toggle?.setAttribute('aria-expanded', 'false');
                chevron?.classList.remove('rotate-180');
            };

            const openMenu = () => {
                menu?.classList.remove('hidden');
                toggle?.setAttribute('aria-expanded', 'true');
                chevron?.classList.add('rotate-180');
            };

            toggle?.addEventListener('click', (event) => {
                event.stopPropagation();

                if (menu?.classList.contains('hidden')) {
                    openMenu();
                } else {
                    closeMenu();
                }
            });

            document.addEventListener('click', (event) => {
                if (!profile.contains(event.target)) {
                    closeMenu();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeMenu();
                }
            });
        }

        initDashboardProfile();

        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                toggleSidebar();
            }
        });
    </script>
</body>
</html>
