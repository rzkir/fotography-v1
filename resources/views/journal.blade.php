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
            top: 20%;
            left: -25%;
            z-index: 0;
            pointer-events: none;
        }
        .journal-card {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .journal-card:hover {
            transform: translateY(-8px);
        }
    </style>
    <title>Noir/Studio - Journal</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d]">
        <div class="diagonal-line"></div>

        <x-layout.header />

        <main class="relative pt-48 px-6 md:px-12 lg:px-20 z-10 pb-32">
            <header class="mb-32">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-12">
                    <div class="max-w-3xl">
                        <span class="block text-[10px] font-bold tracking-[0.5em] text-zinc-500 uppercase mb-6">Editorial Journal</span>
                        <h1 class="text-7xl lg:text-9xl font-display font-black leading-[0.8] tracking-tighter uppercase mb-12">Latest<br/><span class="font-serif italic capitalize text-zinc-500">Stories</span></h1>
                        <p class="font-serif italic text-3xl lg:text-4xl text-zinc-400 leading-tight max-w-2xl">Insights, behind-the-scenes, and narratives from our creative journey.</p>
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                <article class="journal-card group">
                    <div class="relative aspect-[16/10] overflow-hidden rounded-sm mb-8">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=800" alt="Journal 1" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-4 block">Fashion / October 2024</span>
                    <h3 class="text-3xl font-display font-black uppercase mb-4">The Ethereal Bloom Campaign</h3>
                    <p class="text-zinc-400 text-sm mb-6">Behind the scenes of our latest beauty campaign for an international cosmetics brand, exploring organic textures and soft lighting techniques.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-800 pb-1 hover:border-white transition-all">Read Story</a>
                </article>

                <article class="journal-card group">
                    <div class="relative aspect-[16/10] overflow-hidden rounded-sm mb-8">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=800" alt="Journal 2" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-4 block">Editorial / September 2024</span>
                    <h3 class="text-3xl font-display font-black uppercase mb-4">Concrete Silence: Urban Fashion</h3>
                    <p class="text-zinc-400 text-sm mb-6">Exploring the intersection of brutalist architecture and soft fabrics in our latest editorial for Vogue Italia.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-800 pb-1 hover:border-white transition-all">Read Story</a>
                </article>

                <article class="journal-card group">
                    <div class="relative aspect-[16/10] overflow-hidden rounded-sm mb-8">
                        <img src="https://images.unsplash.com/photo-1509460913899-515f1df34fed?auto=format&fit=crop&q=80&w=800" alt="Journal 3" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-4 block">Studio / August 2024</span>
                    <h3 class="text-3xl font-display font-black uppercase mb-4">Midnight Soul Series</h3>
                    <p class="text-zinc-400 text-sm mb-6">A deep dive into our signature night portrait series, shot entirely on 35mm analog film with minimal lighting setup.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-800 pb-1 hover:border-white transition-all">Read Story</a>
                </article>

                <article class="journal-card group">
                    <div class="relative aspect-[16/10] overflow-hidden rounded-sm mb-8">
                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=800" alt="Journal 4" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-4 block">Portrait / July 2024</span>
                    <h3 class="text-3xl font-display font-black uppercase mb-4">Golden Hour Philosophy</h3>
                    <p class="text-zinc-400 text-sm mb-6">Understanding the importance of natural light timing in creating emotionally resonant portrait photography.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-800 pb-1 hover:border-white transition-all">Read Story</a>
                </article>

                <article class="journal-card group">
                    <div class="relative aspect-[16/10] overflow-hidden rounded-sm mb-8">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=800" alt="Journal 5" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-4 block">Commercial / June 2024</span>
                    <h3 class="text-3xl font-display font-black uppercase mb-4">Urban Flow Campaign</h3>
                    <p class="text-zinc-400 text-sm mb-6">Case study: How we captured the energy of urban movement for Nike's latest athletic wear campaign.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-800 pb-1 hover:border-white transition-all">Read Story</a>
                </article>

                <article class="journal-card group">
                    <div class="relative aspect-[16/10] overflow-hidden rounded-sm mb-8">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=800" alt="Journal 6" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    </div>
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-4 block">Fine Art / May 2024</span>
                    <h3 class="text-3xl font-display font-black uppercase mb-4">Shadow Play Exhibition</h3>
                    <p class="text-zinc-400 text-sm mb-6">Preview of our upcoming gallery exhibition featuring high-contrast portraits exploring human emotion through light.</p>
                    <a href="#" class="text-[10px] font-bold uppercase tracking-widest border-b border-zinc-800 pb-1 hover:border-white transition-all">Read Story</a>
                </article>
            </div>
        </main>

        <x-layout.footer />
    </div>
</body>
</html>