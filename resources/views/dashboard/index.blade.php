<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d0d0d;
            --accent-color: #f5f2ed;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--accent-color);
            height: 100dvh;
            overflow: hidden;
        }
        html {
            height: 100%;
            overflow: hidden;
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
        .mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background:
                radial-gradient(circle at 20% 20%, rgba(245, 242, 237, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(245, 242, 237, 0.05) 0%, transparent 40%);
        }
        .active-nav {
            background: rgba(245, 242, 237, 0.1);
            border: 1px solid rgba(245, 242, 237, 0.2);
        }
        .card-gradient {
            background: linear-gradient(135deg, rgba(245, 242, 237, 0.05) 0%, rgba(245, 242, 237, 0) 100%);
        }
        .custom-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(245, 242, 237, 0.28) transparent;
            scrollbar-gutter: stable;
        }
        .custom-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
            margin: 12px 0;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(245, 242, 237, 0.1);
            border-radius: 999px;
            border: 1px solid rgba(245, 242, 237, 0.06);
            backdrop-filter: blur(8px);
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(245, 242, 237, 0.28);
            border-color: rgba(245, 242, 237, 0.18);
        }
        .custom-scroll::-webkit-scrollbar-thumb:active {
            background: rgba(245, 242, 237, 0.4);
        }
    </style>
    <title>Noir/Studio - Dashboard</title>
</head>
<body>
    <div class="mesh-bg"></div>

    <div class="flex h-full p-4 gap-4 overflow-hidden">
        <x-layout.sidebar active="workspace" />

        <main class="flex-1 flex flex-col gap-4 min-h-0 min-w-0 overflow-hidden">
            <header class="h-24 glass rounded-[2rem] flex items-center justify-between px-6 lg:px-10 flex-shrink-0 min-w-0 gap-4">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-12 h-12 rounded-full overflow-hidden border border-[#f5f2ed]/20 flex-shrink-0">
                        <img src="https://api.dicebear.com/7.x/shapes/svg?seed={{ rawurlencode(auth()->user()->name) }}" alt="{{ auth()->user()->name }}">
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-lg font-bold leading-tight truncate">Morning, {{ explode(' ', auth()->user()->name)[0] }}</h2>
                        <p class="text-xs text-[#f5f2ed]/40 hidden sm:block truncate">Manage your portfolio and commissions</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 lg:gap-4 flex-shrink-0">
                    <div class="relative hidden md:block">
                        <iconify-icon icon="lucide:search" class="absolute left-4 top-1/2 -translate-y-1/2 opacity-30"></iconify-icon>
                        <input type="text" placeholder="Search projects..." class="bg-[#f5f2ed]/5 border border-[#f5f2ed]/10 rounded-2xl py-3 pl-12 pr-6 text-sm w-48 lg:w-80 focus:outline-none focus:border-[#f5f2ed]/30">
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" id="header-logout" class="w-12 h-12 flex items-center justify-center glass rounded-2xl glass-hover" title="Sign out">
                            <iconify-icon icon="lucide:log-out"></iconify-icon>
                        </button>
                    </form>
                    <button id="header-settings" class="w-12 h-12 flex items-center justify-center glass rounded-2xl glass-hover">
                        <iconify-icon icon="lucide:sliders-horizontal"></iconify-icon>
                    </button>
                </div>
            </header>

            <div class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden space-y-4 pb-4 pr-2 custom-scroll">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="glass rounded-[2rem] p-8 card-gradient">
                        <iconify-icon icon="lucide:folder-open" class="text-3xl mb-6 text-emerald-400"></iconify-icon>
                        <p class="text-sm text-[#f5f2ed]/40">Active Projects</p>
                        <p class="text-3xl font-bold tracking-tighter">45</p>
                    </div>
                    <div class="glass rounded-[2rem] p-8 card-gradient">
                        <iconify-icon icon="lucide:calendar" class="text-3xl mb-6 text-blue-400"></iconify-icon>
                        <p class="text-sm text-[#f5f2ed]/40">Upcoming Events</p>
                        <p class="text-3xl font-bold tracking-tighter">12</p>
                    </div>
                    <div class="glass rounded-[2rem] p-8 card-gradient">
                        <iconify-icon icon="lucide:star" class="text-3xl mb-6 text-orange-400"></iconify-icon>
                        <p class="text-sm text-[#f5f2ed]/40">Pending Reviews</p>
                        <p class="text-3xl font-bold tracking-tighter">8</p>
                    </div>
                    <div class="glass rounded-[2rem] p-8 card-gradient">
                        <iconify-icon icon="lucide:globe" class="text-3xl mb-6 text-purple-400"></iconify-icon>
                        <p class="text-sm text-[#f5f2ed]/40">Global Reach</p>
                        <p class="text-3xl font-bold tracking-tighter">24</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dashboard.portofolio.create') }}" class="px-6 py-3 glass rounded-2xl text-xs font-bold glass-hover">New Project</a>
                    <a href="{{ route('dashboard.portofolio.index') }}" class="px-6 py-3 glass rounded-2xl text-xs font-bold glass-hover">All Projects</a>
                    <a href="#" class="px-6 py-3 glass rounded-2xl text-xs font-bold glass-hover">Messages</a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2 glass rounded-[2.5rem] p-6 lg:p-10 min-h-[320px] lg:min-h-[400px]">
                        <div class="flex items-center justify-between mb-8 lg:mb-12">
                            <div>
                                <h3 class="text-xl font-bold">Commission Flow</h3>
                                <p class="text-sm text-[#f5f2ed]/40">Monthly booking activity</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="px-4 py-2 glass rounded-xl text-xs font-bold">30D</button>
                                <button class="px-4 py-2 glass rounded-xl text-xs font-bold opacity-30">90D</button>
                            </div>
                        </div>
                        <div class="flex items-end h-36 lg:h-48 gap-2 lg:gap-4 px-2 lg:px-4 overflow-hidden">
                            <div class="w-full bg-[#f5f2ed]/10 rounded-2xl h-1/2 hover:h-[70%] transition-all duration-500"></div>
                            <div class="w-full bg-[#f5f2ed]/20 rounded-2xl h-2/3 hover:h-[80%] transition-all duration-500"></div>
                            <div class="w-full bg-[#f5f2ed]/10 rounded-2xl h-1/3 hover:h-[50%] transition-all duration-500"></div>
                            <div class="w-full bg-[#f5f2ed] rounded-2xl h-4/5"></div>
                            <div class="w-full bg-[#f5f2ed]/20 rounded-2xl h-2/5 hover:h-[60%] transition-all duration-500"></div>
                            <div class="w-full bg-[#f5f2ed]/10 rounded-2xl h-3/4 hover:h-[90%] transition-all duration-500"></div>
                            <div class="w-full bg-[#f5f2ed]/10 rounded-2xl h-1/2 hover:h-[70%] transition-all duration-500"></div>
                        </div>
                    </div>

                    <div class="glass rounded-[2.5rem] p-6 lg:p-10 flex flex-col justify-center items-center text-center">
                        <div class="relative w-40 h-40 lg:w-48 lg:h-48 mb-6 lg:mb-8">
                            <div class="absolute inset-0 rounded-full border-8 border-[#f5f2ed]/10"></div>
                            <div class="absolute inset-0 rounded-full border-8 border-t-transparent border-r-transparent border-l-transparent border-b-[#f5f2ed] rotate-45"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <p class="text-4xl font-bold tracking-tighter">92%</p>
                                <p class="text-[10px] uppercase tracking-widest text-[#f5f2ed]/40">Satisfaction</p>
                            </div>
                        </div>
                        <h4 class="font-bold mb-2">Client Retention</h4>
                        <p class="text-xs text-[#f5f2ed]/40">Repeat clients across all studio locations.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
