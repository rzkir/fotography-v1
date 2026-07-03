@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'rows' => 4,
    'required' => false,
    'hint' => null,
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

    <textarea
        name="{{ $name }}"
        id="{{ $inputId }}"
        rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        {{ $attributes->except('class')->merge(['class' => 'input-field resize-none']) }}
    >{{ old($name, $value) }}</textarea>

    @if ($hint)
        <p class="text-[10px] text-[#f5f2ed]/30 px-1">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="text-xs text-red-400 px-1">{{ $message }}</p>
    @enderror
</div>
