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
            background: rgba(245, 242, 237, 0.1);
            transform: rotate(-15deg);
            z-index: 0;
            pointer-events: none;
        }
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 32px;
        }
        .project-card {
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .project-card:hover {
            transform: translateY(-8px);
        }
        .filter-btn {
            position: relative;
            transition: all 0.3s ease;
        }
        .filter-btn.active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: #f5f2ed;
        }
        .price-card {
            border: 1px solid #e5e5e5;
            background: #ffffff;
            transition: all 0.4s ease;
        }
        .price-card:hover {
            border-color: #d4d4d8;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
    <title>Noir/Studio - Works & Services</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line" style="top: 5%;"></div>
        <div class="diagonal-line" style="top: 15%; transform: rotate(15deg);"></div>
        <div class="diagonal-line" style="top: 40%; transform: rotate(-5deg);"></div>
        <div class="diagonal-line" style="top: 75%; transform: rotate(10deg);"></div>

        <x-layout.header />

        <main class="relative pt-48 px-6 md:px-12 lg:px-20 z-10 pb-32">
            <!-- Header -->
            <header class="mb-32">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12">
                    <div class="max-w-3xl">
                        <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-6">Studio Archive v.2.4</span>
                        <h1 class="text-6xl md:text-8xl lg:text-9xl font-display font-black leading-none tracking-tighter uppercase">Selected<br/><span class="font-serif italic capitalize text-zinc-500">Masterpieces</span></h1>
                        <p class="mt-8 text-zinc-400 font-light max-w-xl text-lg leading-relaxed">Sebuah kurasi visual dari momen-momen paling berpengaruh. Noir/Studio menghadirkan perspektif baru dalam fotografi komersial dan seni murni.</p>
                    </div>
                    <div class="hidden lg:block pb-4">
                        <div class="flex space-x-12">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-zinc-600 uppercase tracking-widest">Total Projects</span>
                                <span class="text-2xl font-bold">150+</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] text-zinc-600 uppercase tracking-widest">Countries</span>
                                <span class="text-2xl font-bold">12</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Featured Projects -->
            <section class="mb-40">
                <div class="flex items-center space-x-4 mb-12">
                    <div class="w-12 h-[1px] bg-zinc-800"></div>
                    <h2 class="text-[10px] font-bold uppercase tracking-[0.4em] text-zinc-500">Featured Projects</h2>
                </div>
                <div class="grid lg:grid-cols-2 gap-12">
                    <div class="group relative aspect-[16/10] overflow-hidden rounded-sm bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=1600" alt="Featured 1" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent p-12 flex flex-col justify-end">
                            <div class="flex justify-between items-end">
                                <div class="space-y-4">
                                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-white/60">Campaign / 2024</span>
                                    <h3 class="text-4xl lg:text-5xl font-display font-black uppercase tracking-tighter">The Ethereal Bloom</h3>
                                    <p class="text-zinc-400 max-w-sm text-sm">Commercial beauty campaign for international cosmetics brand. Focused on organic textures and soft lighting.</p>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[10px] text-zinc-500 uppercase">Client</span>
                                    <span class="font-bold">Bloom Paris</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group relative aspect-[16/10] overflow-hidden rounded-sm bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=1600" alt="Featured 2" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent p-12 flex flex-col justify-end">
                            <div class="flex justify-between items-end">
                                <div class="space-y-4">
                                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-white/60">Editorial / 2023</span>
                                    <h3 class="text-4xl lg:text-5xl font-display font-black uppercase tracking-tighter">Concrete Silence</h3>
                                    <p class="text-zinc-400 max-w-sm text-sm">Urban fashion editorial exploring the intersection of brutalist architecture and soft fabrics.</p>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[10px] text-zinc-500 uppercase">Client</span>
                                    <span class="font-bold">Vogue Italia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Service Tags -->
            <section class="mb-20 bg-zinc-900/50 py-20 px-12 border-y border-zinc-900">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-200">Fine Art</h4>
                        <p class="text-sm text-zinc-500 leading-relaxed">Eksplorasi emosi melalui cahaya minimalis dan komposisi dramatis.</p>
                    </div>
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-200">Editorial</h4>
                        <p class="text-sm text-zinc-500 leading-relaxed">Narasi visual untuk publikasi mode dan seni kelas dunia.</p>
                    </div>
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-200">Commercial</h4>
                        <p class="text-sm text-zinc-500 leading-relaxed">Visual berdampak tinggi yang dirancai untuk memperkuat identitas brand.</p>
                    </div>
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-200">Product</h4>
                        <p class="text-sm text-zinc-500 leading-relaxed">Detail makro dan pencahayaan presisi untuk produk mewah.</p>
                    </div>
                </div>
            </section>

            <!-- Portfolio Grid -->
            <section class="mb-24">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 border-b border-zinc-900 pb-12 mb-16">
                    <div class="flex flex-wrap gap-x-8 gap-y-4 text-[10px] font-bold uppercase tracking-[0.2em]">
                        <button class="filter-btn active hover:text-white">All Work</button>
                        <button class="filter-btn text-zinc-500 hover:text-white">Portrait</button>
                        <button class="filter-btn text-zinc-500 hover:text-white">Editorial</button>
                        <button class="filter-btn text-zinc-500 hover:text-white">Fashion</button>
                        <button class="filter-btn text-zinc-500 hover:text-white">Lifestyle</button>
                        <button class="filter-btn text-zinc-500 hover:text-white">Fine Art</button>
                        <button class="filter-btn text-zinc-500 hover:text-white">Commercial</button>
                        <button class="filter-btn text-zinc-500 hover:text-white">Product</button>
                    </div>
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-3">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-600">Sort By</span>
                            <select class="bg-transparent border-none text-[10px] font-bold uppercase tracking-widest text-white outline-none cursor-pointer">
                                <option class="bg-zinc-900">Latest</option>
                                <option class="bg-zinc-900">Popular</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-600">Price Range</span>
                            <select class="bg-transparent border-none text-[10px] font-bold uppercase tracking-widest text-white outline-none cursor-pointer">
                                <option class="bg-zinc-900">All Levels</option>
                                <option class="bg-zinc-900">Premium</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="portfolio-grid">
                    <a href="#" class="project-card col-span-12 md:col-span-6 lg:col-span-8 group relative aspect-[16/9] overflow-hidden bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=1400" alt="P1" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-12">
                            <div class="overlay-text opacity-0 transform translate-y-4 transition-all duration-500">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-zinc-400">Portrait / 2.4K views</span>
                                    <span class="text-xs text-zinc-500">2024</span>
                                </div>
                                <h3 class="text-4xl lg:text-6xl font-display font-black uppercase tracking-tighter">Aura of Silence</h3>
                                <p class="text-sm text-zinc-400 mt-4">Model: Sophia K.</p>
                            </div>
                        </div>
                    </a>

                    <a href="#" class="project-card col-span-12 md:col-span-6 lg:col-span-4 group relative aspect-[3/4] overflow-hidden bg-zinc-900">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=1000" alt="P2" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-10">
                            <div class="overlay-text opacity-0 transform translate-y-4 transition-all duration-500">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-zinc-400">Editorial / 1.8K views</span>
                                    <span class="text-xs text-zinc-500">2023</span>
                                </div>
                                <h3 class="text-4xl font-display font-black uppercase tracking-tighter">Street Ethos</h3>
                                <p class="text-sm text-zinc-400 mt-4">Model: Julian M.</p>
                            </div>
                        </div>
                    </a>

                    <!-- ... more project cards ... -->
                </div>

                <div class="mt-24 text-center">
                    <button class="px-12 py-5 border border-zinc-800 text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all duration-500">Load More Projects</button>
                </div>
            </section>

            <!-- Pricing Section -->
            <section class="py-40 bg-white text-black">
                <div class="max-w-7xl mx-auto px-12">
                    <div class="mb-24 text-center">
                        <span class="text-[10px] font-bold uppercase tracking-[0.5em] text-zinc-500 block mb-6">Investment & Value</span>
                        <h2 class="text-6xl md:text-8xl font-display font-black tracking-tighter uppercase">Pricing Tiers</h2>
                    </div>
                    <div class="grid md:grid-cols-3 gap-12">
                        <div class="price-card p-12 flex flex-col justify-between h-full rounded-sm bg-white border border-zinc-200">
                            <div class="space-y-8">
                                <div>
                                    <h4 class="text-xs font-bold uppercase tracking-[0.3em] mb-4 text-zinc-600">Essential</h4>
                                    <span class="text-5xl font-display font-black tracking-tighter text-black">$450</span>
                                </div>
                                <ul class="space-y-4 text-sm text-zinc-500">
                                    <li>— 2 Hours Session</li>
                                    <li>— 1 Local Location</li>
                                    <li>— 15 High-End Edits</li>
                                    <li>— Online Gallery Access</li>
                                </ul>
                            </div>
                            <button class="mt-12 w-full py-4 border border-black text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-black hover:text-white transition-all">Request Booking</button>
                        </div>

                        <div class="price-card p-12 flex flex-col justify-between h-full border-2 border-black rounded-sm" style="background: #f8f8f8;">
                            <div class="space-y-8">
                                <div>
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="text-xs font-bold uppercase tracking-[0.3em] text-black">Editorial</h4>
                                        <span class="bg-black text-white px-3 py-1 text-[8px] font-bold uppercase">Popular</span>
                                    </div>
                                    <span class="text-5xl font-display font-black tracking-tighter text-black">$850</span>
                                </div>
                                <ul class="space-y-4 text-sm text-zinc-600">
                                    <li>— 4 Hours Session</li>
                                    <li>— Studio + Location</li>
                                    <li>— 40 High-End Edits</li>
                                    <li>— Full Wardrobe Assistance</li>
                                    <li>— 48h Preview Access</li>
                                </ul>
                            </div>
                            <button class="mt-12 w-full py-4 bg-black text-white text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-zinc-800 transition-all">Request Booking</button>
                        </div>

                        <div class="price-card p-12 flex flex-col justify-between h-full rounded-sm bg-white border border-zinc-200">
                            <div class="space-y-8">
                                <div>
                                    <h4 class="text-xs font-bold uppercase tracking-[0.3em] mb-4 text-zinc-600">Premium</h4>
                                    <span class="text-5xl font-display font-black tracking-tighter italic font-serif capitalize text-black">Custom</span>
                                </div>
                                <ul class="space-y-4 text-sm text-zinc-500">
                                    <li>— Multi-Day Session</li>
                                    <li>— Global Locations</li>
                                    <li>— Unlimited Edits</li>
                                    <li>— Creative Direction Team</li>
                                    <li>— Physical Print Box</li>
                                </ul>
                            </div>
                            <button class="mt-12 w-full py-4 border border-black text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-black hover:text-white transition-all">Inquire Now</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Commission Process -->
            <section class="py-40 border-t border-zinc-900">
                <div class="max-w-7xl mx-auto px-12">
                    <div class="grid lg:grid-cols-12 gap-24">
                        <div class="lg:col-span-5">
                            <span class="text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase block mb-8">The Workflow</span>
                            <h2 class="text-6xl font-display font-black leading-none tracking-tighter uppercase mb-12">Commission<br/>Process</h2>
                            <p class="font-serif italic text-2xl text-zinc-400">Sebuah perjalanan kolaboratif untuk mencapai keunggulan visual.</p>
                        </div>
                        <div class="lg:col-span-7">
                            <div class="space-y-20">
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">01</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">Discovery & Concept</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Konsultasi awal untuk memahami visi, tujuan brand, dan moodboard proyek Anda.</p>
                                    </div>
                                </div>
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">02</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">Pre-Production</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Penentuan lokasi, pemilihan talent, dan teknis pencahayaan yang disesuaikan dengan konsep.</p>
                                    </div>
                                </div>
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">03</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">The Session</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Eksekusi kreatif di set dengan arahan yang presisi untuk hasil terbaik.</p>
                                    </div>
                                </div>
                                <div class="flex gap-12">
                                    <span class="text-4xl font-display font-black text-zinc-800">04</span>
                                    <div class="space-y-4">
                                        <h5 class="text-lg font-bold uppercase tracking-widest">Mastering</h5>
                                        <p class="text-zinc-500 text-sm leading-relaxed">Proses kurasi dan color grading profesional untuk mencapai estetika signature Noir/Studio.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-32 text-center pb-40">
                <a href="#" class="inline-flex flex-col items-center group">
                    <span class="text-[10px] font-bold uppercase tracking-[0.4em] mb-4 text-zinc-500">Ready to work together?</span>
                    <span class="text-4xl md:text-6xl font-display font-black uppercase border-b-2 border-zinc-800 pb-2 group-hover:text-zinc-400 group-hover:border-zinc-500 transition-all">Start a Commission</span>
                </a>
            </div>
        </main>

        <x-layout.footer />
    </div>
</body>
</html>