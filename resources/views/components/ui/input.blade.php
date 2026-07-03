@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'icon' => null,
])

@php
    $inputId = $attributes->get('id', $name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'space-y-2']) }}>
    @if ($label)
        <label for="{{ $inputId }}" class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">
            {{ $label }}
        </label>
    @endif

    <div @class(['relative' => filled($icon)])>
        @if ($icon)
            <iconify-icon icon="{{ $icon }}" class="absolute left-5 top-1/2 -translate-y-1/2 opacity-30 pointer-events-none"></iconify-icon>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $inputId }}"
            value="{{ old($name, $value) }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($required) required @endif
            {{ $attributes->except('class')->merge(['class' => 'input-field' . ($icon ? ' pl-12' : '')]) }}
        >
    </div>

    @error($name)
        <p class="text-xs text-red-400 px-1">{{ $message }}</p>
    @enderror
</div>
