@props([
    'width' => 'w-full',
    'height' => 'h-4',
    'rounded' => 'rounded-xl',
])

<div {{ $attributes->merge(['class' => "skeleton-shimmer {$width} {$height} {$rounded}"]) }}></div>
