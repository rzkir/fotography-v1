@props([
    'size' => 'md',
    'class' => '',
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'w-4 h-4 border-2',
        'lg' => 'w-8 h-8 border-[3px]',
        default => 'w-5 h-5 border-2',
    };
@endphp

<span
    role="status"
    aria-live="polite"
    {{ $attributes->class([
        'inline-block animate-spin rounded-full border-white/20 border-t-[#ff6b35]',
        $sizeClasses,
        $class,
    ]) }}
></span>
