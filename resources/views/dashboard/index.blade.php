<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300;1,600&family=Epilogue:wght@700;900&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @import url('https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@800,900&f[]=satoshi@400,700&display=swap');
        :root {
            --bg-color: #0d0d0d;
            --accent-color: #f5f2ed;
        }
        body {
            background-color: var(--bg-color);
            color: var(--accent-color);
            font-family: 'Satoshi', sans-serif;
            overflow-x: hidden;
        }
        .font-display {
            font-family: 'Cabinet Grotesk', sans-serif;
        }
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }
        .diagonal-line {
            position: absolute;
            width: 150%;
            height: 1px;
            background: rgba(245, 242, 237, 0.05);
            transform: rotate(-15deg);
            top: 50%;
            left: -25%;
            z-index: 0;
            pointer-events: none;
        }
        .asymmetric-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .stats-card {
            border: 1px solid #e5e5e5;
            background: #ffffff;
            transition: all 0.4s ease;
        }
        .stats-card:hover {
            border-color: #d4d4d8;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
    <title>Noir/Studio - Dashboard</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line"></div>

        <x-layout.header />

        <main class="relative z-10 pt-40 px-12 pb-32">
            <header class="mb-32">
                <h1 class="text-7xl font-display font-black uppercase tracking-tighter mb-6">Dashboard</h1>
                <p class="font-serif italic text-2xl text-zinc-400">Manage your portfolio and commissions</p>
            </header>

            <section class="mb-32">
                <div class="asymmetric-grid">
                    <div class="col-span-12 lg:col-span-8">
                        <div class="space-y-8">
                            <h2 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500">Quick Actions</h2>
                            <div class="flex flex-wrap gap-4">
                                <a href="#" class="px-8 py-4 border border-zinc-800 text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-all">New Project</a>
                                <a href="#" class="px-8 py-4 border border-zinc-800 text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-all">View Gallery</a>
                                <a href="#" class="px-8 py-4 border border-zinc-800 text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition-all">Messages</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 mb-12">Statistics</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="stats-card p-12 bg-white text-black rounded-sm">
                        <h3 class="text-5xl font-display font-black mb-2">45</h3>
                        <p class="text-xs font-bold uppercase tracking-widest text-zinc-600">Active Projects</p>
                    </div>
                    <div class="stats-card p-12 bg-white text-black rounded-sm">
                        <h3 class="text-5xl font-display font-black mb-2">12</h3>
                        <p class="text-xs font-bold uppercase tracking-widest text-zinc-600">Upcoming Events</p>
                    </div>
                    <div class="stats-card p-12 bg-white text-black rounded-sm">
                        <h3 class="text-5xl font-display font-black mb-2">8</h3>
                        <p class="text-xs font-bold uppercase tracking-widest text-zinc-600">Pending Reviews</p>
                    </div>
                </div>
            </section>
        </main>

        <x-layout.footer />
    </div>
</body>
</html>