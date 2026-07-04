@props([
    'value' => 0,
    'max' => 100,
    'size' => 'sm',
    'theme' => 'orange',
    'animated' => true,
    'minVisible' => true,
])

@php
    $percent = $max > 0
        ? min(100, max(0, ((float) $value / (float) $max) * 100))
        : 0;

    $sizes = [
        'xs' => 'ui-progress--xs',
        'sm' => 'ui-progress--sm',
        'md' => 'ui-progress--md',
        'lg' => 'ui-progress--lg',
    ];

    $themes = [
        'orange',
        'teal',
        'coral',
        'indigo',
        'white',
    ];

    $trackSize = $sizes[$size] ?? $sizes['sm'];
    $fillTheme = in_array($theme, $themes, true) ? $theme : 'orange';
    $displayPercent = number_format($percent, fmod($percent, 1.0) === 0.0 ? 0 : 1, '.', '');
    $fillWidth = $minVisible && $percent > 0 && $percent < 1 ? '2%' : $displayPercent.'%';
@endphp

@once
    <style>
        .ui-progress {
            width: 100%;
            background: #27272a;
            border-radius: 9999px;
            overflow: hidden;
        }

        .ui-progress--xs { height: 3px; }
        .ui-progress--sm { height: 4px; }
        .ui-progress--md { height: 6px; }
        .ui-progress--lg { height: 8px; }

        @keyframes ui-progress-fill {
            from { width: 0; }
            to { width: var(--ui-progress-width); }
        }

        @keyframes ui-progress-shimmer {
            0% { transform: translateX(-120%); }
            100% { transform: translateX(220%); }
        }

        .ui-progress-fill {
            height: 100%;
            width: var(--ui-progress-width);
            border-radius: 9999px;
            transform-origin: left center;
        }

        .ui-progress-fill--theme-orange {
            background: linear-gradient(90deg, #ff6b35 0%, #fb7185 100%);
            box-shadow: 0 0 8px rgba(255, 107, 53, 0.45);
        }

        .ui-progress-fill--theme-teal {
            background: linear-gradient(90deg, #2dd4bf 0%, #0d9488 100%);
            box-shadow: 0 0 8px rgba(45, 212, 191, 0.35);
        }

        .ui-progress-fill--theme-coral {
            background: linear-gradient(90deg, #fb7185 0%, #f43f5e 100%);
            box-shadow: 0 0 8px rgba(251, 113, 133, 0.35);
        }

        .ui-progress-fill--theme-indigo {
            background: linear-gradient(90deg, #818cf8 0%, #4f46e5 100%);
            box-shadow: 0 0 8px rgba(129, 140, 248, 0.35);
        }

        .ui-progress-fill--theme-white {
            background: linear-gradient(90deg, rgba(245, 242, 237, 0.75) 0%, #f5f2ed 100%);
            box-shadow: 0 0 8px rgba(245, 242, 237, 0.2);
        }

        .ui-progress-fill--animated {
            animation: ui-progress-fill 1.1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .ui-progress-fill--shimmer::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.15) 45%,
                rgba(255, 255, 255, 0.35) 50%,
                rgba(255, 255, 255, 0.15) 55%,
                transparent 100%
            );
            animation: ui-progress-shimmer 2.4s ease-in-out infinite;
        }
    </style>
@endonce

<div
    {{ $attributes->merge(['class' => "ui-progress {$trackSize}"]) }}
    role="progressbar"
    aria-valuemin="0"
    aria-valuemax="{{ $max }}"
    aria-valuenow="{{ $value }}"
    aria-label="{{ $attributes->get('aria-label', 'Progress') }}"
>
    <div
        class="ui-progress-fill ui-progress-fill--theme-{{ $fillTheme }} relative {{ $animated ? 'ui-progress-fill--animated ui-progress-fill--shimmer' : '' }}"
        style="--ui-progress-width: {{ $fillWidth }};"
    ></div>
</div>
