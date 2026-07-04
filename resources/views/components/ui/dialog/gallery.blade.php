@props([
    'id' => 'gallery-dialog',
    'storeRoute',
    'uploadMaxLabel' => '5 MB',
])

<x-ui.dialog :id="$id" title="Add Gallery Item" maxWidth="max-w-2xl">
    <form
        id="{{ $id }}-form"
        method="POST"
        action="{{ $storeRoute }}"
        enctype="multipart/form-data"
        class="flex flex-col min-h-0"
        data-gallery-form
        data-store-route="{{ $storeRoute }}"
        data-auto-open="{{ $errors->any() ? 'true' : 'false' }}"
        data-initial-mode="{{ old('_gallery_mode', 'create') }}"
        data-initial-update-url="{{ old('_gallery_update_url', '') }}"
        data-initial-title="{{ old('title', '') }}"
        data-initial-image-url="{{ old('_gallery_image_url', '') }}"
    >
        @csrf
        <input type="hidden" name="_method" value="POST" data-gallery-method>
        <input type="hidden" name="_gallery_mode" value="{{ old('_gallery_mode', 'create') }}" data-gallery-mode-field>
        <input type="hidden" name="_gallery_update_url" value="{{ old('_gallery_update_url', '') }}" data-gallery-update-url-field>
        <input type="hidden" name="_gallery_image_url" value="{{ old('_gallery_image_url', '') }}" data-gallery-image-url-field>

        <div class="space-y-5 overflow-y-auto custom-scroll pr-1 max-h-[calc(90vh-14rem)]">
            <x-ui.input
                name="title"
                id="{{ $id }}-title-input"
                label="Title"
                placeholder="Golden Hour Portrait"
                required
                data-gallery-title
            />

            <x-ui.upload
                name="image"
                id="{{ $id }}-image-input"
                label="Image"
                hint="JPG, PNG, WEBP, HEIC up to {{ $uploadMaxLabel }}"
                previewHeight="min(300px, 42vh)"
            />
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 mt-2 shrink-0 border-t border-white/5">
            <button
                type="button"
                data-dialog-close
                class="px-5 py-3 rounded-xl border border-white/5 text-sm font-bold text-zinc-400 hover:text-white hover:bg-white/5 transition-all"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="px-6 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all"
                data-gallery-submit
            >
                Save Gallery Item
            </button>
        </div>
    </form>
</x-ui.dialog>
