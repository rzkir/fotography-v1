@props([
    'id' => 'dialog',
    'title' => null,
    'maxWidth' => 'max-w-lg',
])

<div
    id="{{ $id }}"
    data-dialog
    class="fixed inset-0 z-[200] hidden items-center justify-center p-4"
    role="dialog"
    aria-modal="true"
    @if ($title) aria-labelledby="{{ $id }}-title" @endif
>
    <div
        data-dialog-overlay
        class="absolute inset-0"
        style="background: rgba(0, 0, 0, 0.65); z-index: 0;"
    ></div>

    <div
        @class(['w-full rounded-[2rem] p-6 lg:p-8', $maxWidth])
        style="position: relative; z-index: 10; background: #181818; border: 1px solid rgba(255, 255, 255, 0.12); box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.35), 0 28px 64px rgba(0, 0, 0, 0.70);"
    >
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
