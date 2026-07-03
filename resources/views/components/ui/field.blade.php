@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'as' => 'input', // input | textarea | select
    'rows' => 4,
    'options' => [], // for select: list<array{value:string, label:string}>
])

@php
    $id = $attributes->get('id', $name);
    $baseClass = 'w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm font-medium focus:outline-none';
@endphp

<div class="space-y-2">
    @if ($label)
        <label for="{{ $id }}" class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em] ml-2">
            {{ $label }}
        </label>
    @endif

    @if ($as === 'textarea')
        <textarea
            id="{{ $id }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            @if ($required) required @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            {{ $attributes->except('class')->merge(['class' => $baseClass.' h-32']) }}
        >{{ old($name, $value) }}</textarea>
    @elseif ($as === 'select')
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            @if ($required) required @endif
            {{ $attributes->except('class')->merge(['class' => $baseClass.' appearance-none']) }}
        >
            @foreach ($options as $option)
                <option value="{{ $option['value'] }}" @selected(old($name, $value) == $option['value'])>
                    {{ $option['label'] }}
                </option>
            @endforeach
        </select>
    @else
        <input
            id="{{ $id }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if ($required) required @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            {{ $attributes->except('class')->merge(['class' => $baseClass]) }}
        >
    @endif

    @error($name)
        <p class="text-xs text-red-400 ml-2">{{ $message }}</p>
    @enderror
</div>
