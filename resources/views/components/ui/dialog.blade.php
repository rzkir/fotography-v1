@props([
    'id' => 'dialog',
    'title' => null,
    'maxWidth' => 'max-w-lg',
])

<div
    id="{{ $id }}"
    data-dialog
    class="fixed inset-0 z-[100] hidden items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    @if ($title) aria-labelledby="{{ $id }}-title" @endif
>
    <div data-dialog-overlay class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div @class(['relative w-full card-photography rounded-[2rem] p-6 lg:p-8 shadow-2xl border border-white/10', $maxWidth])>
        <div class="flex items-start justify-between gap-4 mb-6">
            @if ($title)
                <h3 id="{{ $id }}-title" data-dialog-title class="text-xl font-display font-black tracking-tight">
                    {{ $title }}
                </h3>
            @else
                <h3 id="{{ $id }}-title" data-dialog-title class="text-xl font-display font-black tracking-tight"></h3>
            @endif
            <button
                type="button"
                data-dialog-close
                class="w-10 h-10 rounded-xl border border-white/5 flex items-center justify-center text-zinc-400 hover:text-white hover:bg-white/5 transition-all flex-shrink-0"
                title="Close"
            >
                <iconify-icon icon="lucide:x" class="text-lg"></iconify-icon>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
