@props([
    'id' => 'alert-dialog',
    'title' => 'Are you sure?',
    'description' => 'This action cannot be undone.',
    'confirmLabel' => 'Delete',
    'cancelLabel' => 'Cancel',
    'confirmVariant' => 'danger',
])

@php
    $confirmClasses = match ($confirmVariant) {
        'danger' => 'bg-red-500/90 hover:bg-red-500 text-white',
        'primary' => 'bg-[#f5f2ed] hover:bg-[#f5f2ed]/90 text-[#0d0d0d]',
        default => 'bg-[#f5f2ed] hover:bg-[#f5f2ed]/90 text-[#0d0d0d]',
    };
@endphp

<div
    id="{{ $id }}"
    data-alert-dialog
    class="fixed inset-0 z-[100] hidden items-center justify-center p-4"
    role="alertdialog"
    aria-modal="true"
    aria-labelledby="{{ $id }}-title"
    aria-describedby="{{ $id }}-description"
>
    <div data-alert-overlay class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="relative w-full max-w-md glass rounded-[2rem] p-8 shadow-2xl border border-white/10">
        <div class="flex items-start gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-red-500/10 border border-red-500/20 flex items-center justify-center flex-shrink-0">
                <iconify-icon icon="lucide:triangle-alert" class="text-xl text-red-400"></iconify-icon>
            </div>
            <div class="min-w-0 pt-1">
                <h3 id="{{ $id }}-title" data-alert-title class="text-lg font-bold tracking-tight">
                    {{ $title }}
                </h3>
                <p id="{{ $id }}-description" data-alert-description class="text-sm text-[#f5f2ed]/50 mt-2 leading-relaxed">
                    {{ $description }}
                </p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button
                type="button"
                data-alert-cancel
                class="px-5 py-3 rounded-2xl glass glass-hover text-sm font-semibold opacity-70 hover:opacity-100 transition-all"
            >
                {{ $cancelLabel }}
            </button>
            <button
                type="button"
                data-alert-confirm
                class="px-5 py-3 rounded-2xl text-sm font-bold transition-all hover:scale-[1.02] active:scale-[0.98] {{ $confirmClasses }}"
            >
                {{ $confirmLabel }}
            </button>
        </div>
    </div>
</div>
