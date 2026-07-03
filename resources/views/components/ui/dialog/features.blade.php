@props([
    'id' => 'feature-dialog',
    'storeRoute',
])

<x-ui.dialog :id="$id" title="Add Feature" maxWidth="max-w-lg">
    <form
        id="{{ $id }}-form"
        method="POST"
        action="{{ $storeRoute }}"
        data-feature-form
        data-store-route="{{ $storeRoute }}"
        data-auto-open="{{ $errors->any() ? 'true' : 'false' }}"
        data-initial-mode="{{ old('_feature_mode', 'create') }}"
        data-initial-update-url="{{ old('_feature_update_url', '') }}"
    >
        @csrf
        <input type="hidden" name="_method" value="POST" data-feature-method>
        <input type="hidden" name="_feature_mode" value="{{ old('_feature_mode', 'create') }}" data-feature-mode-field>
        <input type="hidden" name="_feature_update_url" value="{{ old('_feature_update_url', '') }}" data-feature-update-url-field>

        <div class="space-y-5">
            <x-ui.input
                name="number"
                id="{{ $id }}-number-input"
                label="Number"
                placeholder="4.92"
                required
                data-feature-number
            />

            <x-ui.input
                name="title"
                id="{{ $id }}-title-input"
                label="Title"
                placeholder="Average Rating"
                required
                data-feature-title
            />
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
                data-feature-submit
            >
                Save Feature
            </button>
        </div>
    </form>
</x-ui.dialog>
