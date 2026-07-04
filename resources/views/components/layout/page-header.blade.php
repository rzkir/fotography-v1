@props([
    'title',
    'back' => null,
])

<header {{ $attributes->merge(['class' => 'sticky top-0 z-40 bg-[#0d0d0d]/90 backdrop-blur-xl px-6 lg:px-10 h-24 flex items-center justify-between gap-4']) }}>
    <div class="flex items-center gap-4 min-w-0">
        @if ($back)
            <a href="{{ $back }}" class="w-12 h-12 rounded-xl border border-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/5 transition-all shrink-0">
                <iconify-icon icon="lucide:chevron-left" class="text-xl"></iconify-icon>
            </a>
        @endif
        <div class="min-w-0">
            <h1 class="text-xl lg:text-2xl font-display font-black tracking-tight truncate">{{ $title }}</h1>
            @isset($subtitle)
                <p class="text-xs text-zinc-500 font-bold truncate mt-0.5">{{ $subtitle }}</p>
            @endisset
        </div>
    </div>
    <div class="flex items-center gap-3 shrink-0">
        @isset($actions)
            {{ $actions }}
        @endisset
        <x-layout.profile />
    </div>
</header>
