@props([
    'id' => 'pagination',
    'hidden' => true,
    'manual' => false,
])

<div
    id="{{ $id }}"
    data-pagination-root
    @if ($manual) data-pagination-manual @endif
    @class([
        'mt-32 flex justify-center items-center space-x-6 pb-8',
        'hidden' => $hidden,
    ])
    {{ $attributes }}
>
    <button
        type="button"
        data-pagination-prev
        class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center text-zinc-600 hover:border-white hover:text-white transition-all"
        aria-label="Previous page"
    >
        <iconify-icon icon="lucide:chevron-left"></iconify-icon>
    </button>

    <div data-pagination-pages class="flex space-x-4 text-xs font-bold uppercase tracking-widest"></div>

    <button
        type="button"
        data-pagination-next
        class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center text-zinc-600 hover:border-white hover:text-white transition-all"
        aria-label="Next page"
    >
        <iconify-icon icon="lucide:chevron-right"></iconify-icon>
    </button>
</div>
