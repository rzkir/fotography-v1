<nav class="fixed top-0 left-0 w-full z-50 mix-blend-difference py-5 px-6 md:px-12 flex justify-between items-center">
    <a href="/" id="brand-logo" class="text-3xl font-display font-black tracking-tighter uppercase text-white">Noir<span class="text-zinc-600">/</span>Studio</a>
    <div class="flex items-center space-x-12">
        <div class="hidden md:flex space-x-8 text-[10px] font-bold uppercase tracking-[0.3em] text-white">
            <a href="/" id="nav-home" class="transition-colors hover:text-zinc-400">Home</a>
            <a href="/works" id="nav-works" class="transition-colors hover:text-zinc-400">Selected Works</a>
            <a href="/journal" id="nav-journal" class="transition-colors hover:text-zinc-400">Journal</a>
            <a href="/contact" id="nav-contact" class="transition-colors hover:text-zinc-400">Contact</a>
        </div>
        <button id="mobile-menu-btn" class="md:hidden flex items-center space-x-2 text-white">
            <span class="text-[10px] font-bold uppercase tracking-widest">Menu</span>
            <iconify-icon icon="lucide:menu" class="text-2xl" id="menu-icon"></iconify-icon>
        </button>
        <button type="button" class="hidden md:flex items-center space-x-2 text-white" aria-label="Open menu">
            <span class="text-[10px] font-bold uppercase tracking-widest">Menu</span>
            <iconify-icon icon="lucide:minus" class="text-2xl"></iconify-icon>
        </button>
    </div>
    <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-black/95 backdrop-blur-md p-12 flex-col space-y-8 text-[10px] font-bold uppercase tracking-[0.3em] text-white md:hidden z-50">
        <a href="/" class="block py-2">Home</a>
        <a href="/works" class="block py-2">Selected Works</a>
        <a href="/journal" class="block py-2">Journal</a>
        <a href="/contact" class="block py-2">Contact</a>
    </div>
</nav>
<script>
    const menuBtn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('menu-icon');
    
    menuBtn?.addEventListener('click', function() {
        menu.classList.toggle('hidden');
        if (menu.classList.contains('hidden')) {
            icon.setAttribute('icon', 'lucide:menu');
        } else {
            icon.setAttribute('icon', 'lucide:x');
        }
    });
</script>