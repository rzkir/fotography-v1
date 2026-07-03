@props([
    'icon',
    'label',
    'value',
    'theme' => 'orange',
    'badge' => null,
    'footer' => null,
])

@php
    $themes = [
        'orange' => [
            'gradient' => 'from-orange-500/10',
            'border' => 'border-orange-500/20',
            'icon' => 'text-orange-500',
            'badge' => 'bg-orange-500/20 text-orange-500',
            'accent' => 'text-orange-500',
        ],
        'teal' => [
            'gradient' => 'from-teal-500/10',
            'border' => 'border-teal-500/20',
            'icon' => 'text-teal-400',
            'badge' => 'bg-teal-500/20 text-teal-400',
            'accent' => 'text-teal-400',
        ],
        'coral' => [
            'gradient' => 'from-rose-500/10',
            'border' => 'border-rose-500/20',
            'icon' => 'text-rose-400',
            'badge' => 'bg-rose-500/20 text-rose-400',
            'accent' => 'text-rose-400',
        ],
        'indigo' => [
            'gradient' => 'from-indigo-500/10',
            'border' => 'border-indigo-500/20',
            'icon' => 'text-indigo-400',
            'badge' => 'bg-indigo-500/20 text-indigo-400',
            'accent' => 'text-indigo-400',
        ],
    ];

    $t = $themes[$theme] ?? $themes['orange'];
@endphp

<div {{ $attributes->merge(['class' => "card-photography p-6 rounded-[2rem] bg-gradient-to-br {$t['gradient']} to-transparent {$t['border']}"]) }}>
    <div class="flex justify-between items-center mb-6">
        <iconify-icon icon="{{ $icon }}" class="text-3xl {{ $t['icon'] }}"></iconify-icon>
        @if ($badge)
            <span class="{{ $t['badge'] }} text-[10px] font-black px-2 py-1 rounded-full">{{ $badge }}</span>
        @endif
    </div>

    <h3 class="text-zinc-500 text-xs font-black tracking-[0.1em] mb-1 uppercase">{{ $label }}</h3>
    <p class="text-4xl font-display font-black">{{ $value }}</p>

    @if ($footer)
        <div class="mt-4">
            {{ $footer }}
        </div>
    @endif
</div>
