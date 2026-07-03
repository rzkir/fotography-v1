<x-layout.dashboard title="Features" active="features">
    <x-slot:header>
        <header class="sticky top-0 z-40 bg-[#0d0d0d]/90 backdrop-blur-xl px-6 lg:px-10 h-24 flex items-center justify-between border-b border-white/5">
            <div class="flex flex-col min-w-0">
                <h1 class="text-2xl font-display font-black tracking-tight leading-none uppercase">Studio Highlights</h1>
                <p class="text-xs text-zinc-500 font-bold tracking-[0.2em] mt-1 uppercase">Features & Key Metrics</p>
            </div>
            <button
                type="button"
                data-feature-open="feature-dialog"
                data-feature-mode="create"
                class="px-6 py-3 bg-[#ff6b35] text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-orange-500/20 hover:scale-105 transition-all"
            >
                Add Feature
            </button>
        </header>
    </x-slot:header>

    <div class="space-y-10">
        @if ($errors->any())
            <div class="px-6 py-4 rounded-2xl border border-red-500/20 bg-red-500/10 text-red-300 text-sm">
                There was a problem saving the feature. Reopen the dialog to review the highlighted fields.
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h2 class="text-4xl font-display font-black tracking-tighter">Key Metrics</h2>
                <p class="text-zinc-500 font-medium mt-2">Manage highlight numbers and titles shown across your studio presence.</p>
            </div>
            <p class="text-[10px] text-zinc-600 font-black uppercase tracking-[0.2em]">
                {{ $features->count() }} {{ Str::plural('feature', $features->count()) }}
            </p>
        </div>

        @if ($features->isEmpty())
            <div class="card-photography rounded-[3rem] p-16 text-center">
                <iconify-icon icon="lucide:sparkles" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                <h3 class="text-2xl font-display font-black mb-2">No features yet</h3>
                <p class="text-sm text-zinc-500 mb-8 max-w-xl mx-auto">Add your first highlight with a number and title, such as <span class="text-zinc-300">4.92</span> and <span class="text-zinc-300">Average Rating</span>.</p>
                <button
                    type="button"
                    data-feature-open="feature-dialog"
                    data-feature-mode="create"
                    class="inline-flex px-8 py-4 bg-[#ff6b35] text-white rounded-2xl text-sm font-black hover:scale-[1.02] transition-all"
                >
                    Create Feature
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($features as $index => $feature)
                    @php
                        $accents = [
                            ['gradient' => 'from-orange-500/10', 'border' => 'border-orange-500/20', 'icon' => 'lucide:star', 'iconColor' => 'text-[#ff6b35]'],
                            ['gradient' => 'from-teal-500/10', 'border' => 'border-teal-500/20', 'icon' => 'lucide:thumbs-up', 'iconColor' => 'text-teal-400'],
                            ['gradient' => 'from-rose-500/10', 'border' => 'border-rose-500/20', 'icon' => 'lucide:award', 'iconColor' => 'text-rose-400'],
                        ];
                        $accent = $accents[$index % count($accents)];
                    @endphp

                    <article class="card-photography rounded-[2.5rem] p-8 bg-linear-to-br {{ $accent['gradient'] }} to-transparent {{ $accent['border'] }} flex flex-col gap-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <iconify-icon icon="{{ $accent['icon'] }}" class="text-2xl {{ $accent['iconColor'] }}"></iconify-icon>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button
                                    type="button"
                                    data-feature-open="feature-dialog"
                                    data-feature-mode="edit"
                                    data-feature-number="{{ $feature->number }}"
                                    data-feature-title="{{ $feature->title }}"
                                    data-feature-update-url="{{ route('dashboard.features.update', $feature) }}"
                                    class="w-10 h-10 rounded-xl bg-white/5 hover:bg-[#ff6b35] transition-all flex items-center justify-center"
                                    title="Edit feature"
                                >
                                    <iconify-icon icon="lucide:pencil" class="text-base"></iconify-icon>
                                </button>

                                <form id="delete-feature-{{ $feature->id }}" method="POST" action="{{ route('dashboard.features.destroy', $feature) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button
                                    type="button"
                                    data-alert-open="feature-delete-dialog"
                                    data-alert-title="Delete {{ $feature->title }}?"
                                    data-alert-description="This feature highlight will be permanently removed."
                                    data-alert-confirm="Delete Feature"
                                    data-alert-form="delete-feature-{{ $feature->id }}"
                                    class="w-10 h-10 rounded-xl bg-white/5 hover:bg-red-500/20 text-red-400 transition-all flex items-center justify-center"
                                    title="Delete feature"
                                >
                                    <iconify-icon icon="lucide:trash-2" class="text-base"></iconify-icon>
                                </button>
                            </div>
                        </div>

                        <div class="text-center space-y-2">
                            <p class="text-5xl font-display font-black tracking-tight">{{ $feature->number }}</p>
                            <p class="text-[10px] text-zinc-500 font-black uppercase tracking-[0.2em]">{{ $feature->title }}</p>
                        </div>

                        <p class="text-[10px] text-zinc-600 uppercase tracking-widest text-center">
                            Updated {{ $feature->updated_at->diffForHumans() }}
                        </p>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    @push('modals')
        <x-ui.dialog.features
            id="feature-dialog"
            :store-route="route('dashboard.features.store')"
        />

        <x-ui.alert-dialog
            id="feature-delete-dialog"
            title="Delete this feature?"
            description="This feature highlight will be permanently removed. This action cannot be undone."
            confirm-label="Delete Feature"
        />
    @endpush
</x-layout.dashboard>
