@props([
    'id' => 'testimonial-dialog',
    'storeRoute',
])

<x-ui.dialog :id="$id" title="Add Testimonial" maxWidth="max-w-2xl">
    <form
        id="{{ $id }}-form"
        method="POST"
        action="{{ $storeRoute }}"
        data-testimonial-form
        data-store-route="{{ $storeRoute }}"
        data-auto-open="{{ $errors->any() ? 'true' : 'false' }}"
        data-initial-mode="{{ old('_testimonial_mode', 'create') }}"
        data-initial-update-url="{{ old('_testimonial_update_url', '') }}"
    >
        @csrf
        <input type="hidden" name="_method" value="POST" data-testimonial-method>
        <input type="hidden" name="_testimonial_mode" value="{{ old('_testimonial_mode', 'create') }}" data-testimonial-mode-field>
        <input type="hidden" name="_testimonial_update_url" value="{{ old('_testimonial_update_url', '') }}" data-testimonial-update-url-field>

        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-ui.input
                    name="name"
                    id="{{ $id }}-name-input"
                    label="Client Name"
                    placeholder="Claire Beaumont"
                    required
                    data-testimonial-name
                />

                <x-ui.input
                    name="company"
                    id="{{ $id }}-company-input"
                    label="Company"
                    placeholder="Vogue France"
                    required
                    data-testimonial-company
                />
            </div>

            <x-ui.input
                name="jobs"
                id="{{ $id }}-jobs-input"
                label="Job Title"
                placeholder="Creative Director"
                required
                data-testimonial-jobs
            />

            <x-ui.textarea
                name="message"
                id="{{ $id }}-message-input"
                label="Message"
                placeholder="Share the client feedback here..."
                rows="6"
                required
                data-testimonial-message
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
                data-testimonial-submit
            >
                Save Testimonial
            </button>
        </div>
    </form>
</x-ui.dialog>
