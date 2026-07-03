@props([
    'id' => 'category-dialog',
    'storeRoute',
    'updateRoute',
    'titleLabel' => 'Category',
])

<x-ui.dialog :id="$id" title="New Category">
    <form
        id="{{ $id }}-form"
        method="POST"
        action="{{ $storeRoute }}"
        data-category-form
        data-store-route="{{ $storeRoute }}"
        data-update-route="{{ $updateRoute }}"
    >
        @csrf
        <input type="hidden" name="_method" value="POST" data-category-method>

        <div class="space-y-5">
            <x-ui.input
                name="title"
                id="{{ $id }}-title-input"
                label="Title"
                placeholder="Fine Art Portrait"
                required
                data-category-title
            />

            <div class="space-y-2">
                <x-ui.input
                    name="category_id"
                    id="{{ $id }}-category-id-input"
                    label="Category ID"
                    placeholder="fine-art-portrait"
                    required
                    data-category-id
                />
                <p class="text-[10px] text-zinc-600 px-1">Auto-generated from title. Edit manually if needed.</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8">
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
                data-category-submit
            >
                Save Category
            </button>
        </div>
    </form>
</x-ui.dialog>
