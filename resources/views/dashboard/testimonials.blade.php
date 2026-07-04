<x-layout.dashboard title="Testimonials" active="testimonials">
    <x-slot:header>
        <header class="sticky top-0 z-40 bg-[#0d0d0d]/90 backdrop-blur-xl px-6 lg:px-10 h-24 flex items-center justify-between border-b border-white/5">
            <div class="flex flex-col min-w-0">
                <h1 class="text-2xl font-display font-black tracking-tight leading-none uppercase">Client Success</h1>
                <p class="text-xs text-zinc-500 font-bold tracking-[0.2em] mt-1 uppercase">Testimonials & Client Voices</p>
            </div>
            <x-layout.dashboard-header-actions>
                <button
                    type="button"
                    data-testimonial-open="testimonial-dialog"
                    data-testimonial-mode="create"
                    class="px-6 py-3 bg-[#ff6b35] text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-orange-500/20 hover:scale-105 transition-all"
                >
                    Add Testimonial
                </button>
            </x-layout.dashboard-header-actions>
        </header>
    </x-slot:header>

    <style>
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }
    </style>

    <div class="space-y-16">
        @if ($errors->any())
            <div class="px-6 py-4 rounded-2xl border border-red-500/20 bg-red-500/10 text-red-300 text-sm">
                There was a problem saving the testimonial. Reopen the dialog to review the highlighted fields.
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="card-photography p-8 rounded-[2.5rem] bg-linear-to-br from-orange-500/10 to-transparent border-orange-500/20 text-center">
                <h3 class="text-zinc-500 text-[10px] font-black tracking-widest uppercase mb-3">Verified Voices</h3>
                <div class="flex justify-center gap-1 mb-3">
                    @foreach (range(1, 5) as $star)
                        <iconify-icon icon="material-symbols:star" class="text-[#ff6b35] text-2xl"></iconify-icon>
                    @endforeach
                </div>
                <p class="text-5xl font-display font-black">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-zinc-500 font-bold mt-2">Curated client testimonials in your archive</p>
            </div>

            <div class="card-photography p-8 rounded-[2.5rem] bg-linear-to-br from-teal-500/10 to-transparent border-teal-500/20 text-center">
                <h3 class="text-zinc-500 text-[10px] font-black tracking-widest uppercase mb-2">Client Companies</h3>
                <iconify-icon icon="lucide:building-2" class="text-4xl text-teal-400 mb-2"></iconify-icon>
                <p class="text-5xl font-display font-black">{{ number_format($stats['companies']) }}</p>
                <p class="text-xs text-zinc-500 font-bold mt-2">Distinct brands represented here</p>
            </div>

            <div class="card-photography p-8 rounded-[2.5rem] bg-linear-to-br from-rose-500/10 to-transparent border-rose-500/20 text-center">
                <h3 class="text-zinc-500 text-[10px] font-black tracking-widest uppercase mb-2">Professional Roles</h3>
                <iconify-icon icon="lucide:briefcase-business" class="text-4xl text-rose-400 mb-2"></iconify-icon>
                <p class="text-5xl font-display font-black">{{ number_format($stats['roles']) }}</p>
                <p class="text-xs text-zinc-500 font-bold mt-2">Unique job titles across clients</p>
            </div>

            <div class="card-photography p-8 rounded-[2.5rem] text-center flex flex-col justify-center items-center">
                <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-4">
                    <iconify-icon icon="lucide:sparkles" class="text-2xl text-[#ff6b35]"></iconify-icon>
                </div>
                <p class="text-xs font-black uppercase tracking-widest">Latest Update</p>
                <p class="text-sm text-zinc-400 font-medium mt-2">
                    {{ $stats['latest']?->diffForHumans() ?? 'No testimonial yet' }}
                </p>
                <button
                    type="button"
                    data-testimonial-open="testimonial-dialog"
                    data-testimonial-mode="create"
                    class="text-[10px] font-bold text-[#ff6b35] hover:underline mt-3 tracking-widest uppercase"
                >
                    Add New Voice
                </button>
            </div>
        </div>

        <section class="space-y-8">
            <div class="flex justify-between items-end gap-4">
                <div>
                    <h2 class="text-4xl font-display font-black tracking-tighter">Verified Reviews</h2>
                    <p class="text-zinc-500 font-medium mt-2">Manage every client quote with dialog-based create, edit, and delete actions.</p>
                </div>
            </div>

            @if ($testimonials->isEmpty())
                <div class="card-photography rounded-[3rem] p-16 text-center">
                    <iconify-icon icon="lucide:message-square-quote" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                    <h3 class="text-2xl font-display font-black mb-2">No testimonials yet</h3>
                    <p class="text-sm text-zinc-500 mb-8 max-w-xl mx-auto">Start building your testimonial wall by adding a client message, their name, job title, and company.</p>
                    <button
                        type="button"
                        data-testimonial-open="testimonial-dialog"
                        data-testimonial-mode="create"
                        class="inline-flex px-8 py-4 bg-[#ff6b35] text-white rounded-2xl text-sm font-black hover:scale-[1.02] transition-all"
                    >
                        Create Testimonial
                    </button>
                </div>
            @else
                <div class="testimonials-grid">
                    @foreach ($testimonials as $testimonial)
                        <article class="card-photography p-10 rounded-[3rem] space-y-6">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex gap-1">
                                    @foreach (range(1, 5) as $star)
                                        <iconify-icon icon="material-symbols:star" class="text-yellow-500"></iconify-icon>
                                    @endforeach
                                </div>
                                <iconify-icon icon="ri:double-quotes-r" class="text-3xl text-white/10"></iconify-icon>
                            </div>

                            <p class="text-lg font-medium leading-relaxed">"{{ $testimonial->message }}"</p>

                            <div class="flex items-center justify-between gap-4 pt-4 border-t border-white/5">
                                <div class="min-w-0">
                                    <p class="font-black text-sm uppercase truncate">{{ $testimonial->name }}</p>
                                    <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest truncate">
                                        {{ $testimonial->jobs }}, {{ $testimonial->company }}
                                    </p>
                                    <p class="text-[10px] text-zinc-600 uppercase tracking-[0.2em] mt-3">
                                        Updated {{ $testimonial->updated_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <button
                                        type="button"
                                        data-testimonial-open="testimonial-dialog"
                                        data-testimonial-mode="edit"
                                        data-testimonial-name="{{ $testimonial->name }}"
                                        data-testimonial-jobs="{{ $testimonial->jobs }}"
                                        data-testimonial-company="{{ $testimonial->company }}"
                                        data-testimonial-message="{{ $testimonial->message }}"
                                        data-testimonial-update-url="{{ route('dashboard.testimonials.update', $testimonial) }}"
                                        class="w-11 h-11 rounded-xl bg-white/5 hover:bg-[#ff6b35] transition-all flex items-center justify-center"
                                        title="Edit testimonial"
                                    >
                                        <iconify-icon icon="lucide:pencil" class="text-lg"></iconify-icon>
                                    </button>

                                    <form id="delete-testimonial-{{ $testimonial->id }}" method="POST" action="{{ route('dashboard.testimonials.destroy', $testimonial) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button
                                        type="button"
                                        data-alert-open="testimonial-delete-dialog"
                                        data-alert-title="Delete {{ $testimonial->name }}?"
                                        data-alert-description="This testimonial will be permanently removed from your dashboard."
                                        data-alert-confirm="Delete Testimonial"
                                        data-alert-form="delete-testimonial-{{ $testimonial->id }}"
                                        class="w-11 h-11 rounded-xl bg-white/5 hover:bg-red-500/20 text-red-400 transition-all flex items-center justify-center"
                                        title="Delete testimonial"
                                    >
                                        <iconify-icon icon="lucide:trash-2" class="text-lg"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    @push('modals')
        <x-ui.dialog.testimonial
            id="testimonial-dialog"
            :store-route="route('dashboard.testimonials.store')"
        />

        <x-ui.alert-dialog
            id="testimonial-delete-dialog"
            title="Delete this testimonial?"
            description="This testimonial will be permanently removed. This action cannot be undone."
            confirm-label="Delete Testimonial"
        />
    @endpush
</x-layout.dashboard>
