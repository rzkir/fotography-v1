@props([
    'id' => 'gallery-preview-dialog',
])

<x-ui.dialog :id="$id" maxWidth="max-w-6xl">
    <div class="space-y-6">
        <div class="relative overflow-hidden rounded-2xl bg-black/40 border border-white/5">
            <img
                data-gallery-preview-image
                src=""
                alt=""
                class="w-full max-h-[70vh] object-contain mx-auto"
            >

            <button
                type="button"
                data-gallery-preview-prev
                class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/60 border border-white/10 text-white flex items-center justify-center hover:bg-[#ff6b35] transition-all disabled:opacity-30 disabled:pointer-events-none"
                title="Previous image"
            >
                <iconify-icon icon="lucide:chevron-left" class="text-xl"></iconify-icon>
            </button>

            <button
                type="button"
                data-gallery-preview-next
                class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/60 border border-white/10 text-white flex items-center justify-center hover:bg-[#ff6b35] transition-all disabled:opacity-30 disabled:pointer-events-none"
                title="Next image"
            >
                <iconify-icon icon="lucide:chevron-right" class="text-xl"></iconify-icon>
            </button>
        </div>

        <div class="flex items-end justify-between gap-6">
            <div class="min-w-0">
                <p data-gallery-preview-title class="font-display font-bold text-2xl uppercase tracking-tight truncate"></p>
                <p data-gallery-preview-date class="text-[10px] uppercase tracking-[0.3em] text-zinc-500 mt-2"></p>
            </div>
            <p data-gallery-preview-counter class="text-[10px] uppercase tracking-[0.3em] text-zinc-600 shrink-0"></p>
        </div>
    </div>
</x-ui.dialog>
