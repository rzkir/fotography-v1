@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
$classes = match($variant) {
    'primary' => 'inline-flex items-center justify-center px-8 py-4 bg-white text-black font-bold uppercase tracking-widest text-xs hover:bg-zinc-200 transition-all duration-300',
    'secondary' => 'inline-flex items-center justify-center px-8 py-4 border border-zinc-800 text-white font-bold uppercase tracking-widest text-xs hover:bg-white hover:text-black hover:border-white transition-all duration-300',
    'outline' => 'inline-flex items-center justify-center px-8 py-4 border border-zinc-800 text-white font-bold uppercase tracking-widest text-xs hover:border-white transition-all duration-300',
    default => 'inline-flex items-center justify-center px-8 py-4 bg-white text-black font-bold uppercase tracking-widest text-xs hover:bg-zinc-200 transition-all duration-300',
};
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
@endif