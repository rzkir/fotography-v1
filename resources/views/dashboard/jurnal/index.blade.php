<x-layout.dashboard title="Journal" active="journal">
    <x-slot:header>
        <header class="h-24 glass rounded-[2.5rem] flex items-center justify-between px-6 lg:px-10 flex-shrink-0 min-w-0 gap-4">
            <div class="flex items-center gap-4 min-w-0">
                <a href="{{ route('dashboard.index') }}" class="w-12 h-12 rounded-2xl glass flex items-center justify-center hover:bg-white/10 transition-colors flex-shrink-0">
                    <iconify-icon icon="lucide:chevron-left" class="text-xl"></iconify-icon>
                </a>
                <div class="min-w-0">
                    <h1 class="text-xl lg:text-2xl font-bold tracking-tight truncate">Studio Journal</h1>
                    <p class="text-xs text-[#f5f2ed]/40 font-light truncate">Manage articles, essays, and editorial writing</p>
                </div>
            </div>
            <a href="{{ route('dashboard.jurnal.create') }}" class="px-6 lg:px-8 py-3 bg-[#f5f2ed] text-[#0d0d0d] rounded-2xl text-sm font-bold shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all flex-shrink-0">
                New Article
            </a>
        </header>
    </x-slot:header>

    <div class="space-y-6">
        @if ($jurnals->isEmpty())
            <div class="glass rounded-[2.5rem] p-16 text-center">
                <iconify-icon icon="lucide:book-open" class="text-5xl opacity-20 mb-6"></iconify-icon>
                <h3 class="text-xl font-bold mb-2">No articles yet</h3>
                <p class="text-sm text-[#f5f2ed]/40 mb-8">Write your first journal entry — craft essays, technique notes, or editorial stories for the public Journal page.</p>
                <a href="{{ route('dashboard.jurnal.create') }}" class="inline-flex px-8 py-4 bg-[#f5f2ed] text-[#0d0d0d] rounded-2xl text-sm font-bold hover:scale-[1.02] transition-all">
                    Create Article
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach ($jurnals as $jurnal)
                    <article class="glass rounded-[2rem] overflow-hidden card-gradient group">
                        <div class="aspect-video overflow-hidden bg-white/5 relative">
                            @if ($jurnal->thumbnailUrl())
                                <img src="{{ $jurnal->thumbnailUrl() }}" alt="{{ $jurnal->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <iconify-icon icon="lucide:image" class="text-4xl opacity-20"></iconify-icon>
                                </div>
                            @endif
                            <span @class([
                                'absolute top-4 left-4 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-widest',
                                'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' => $jurnal->status === 'published',
                                'bg-white/10 text-[#f5f2ed]/60 border border-white/10' => $jurnal->status === 'draft',
                                'bg-zinc-500/20 text-zinc-400 border border-zinc-500/30' => $jurnal->status === 'archived',
                            ])>
                                {{ $jurnal->status }}
                            </span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#f5f2ed]/40 mb-2 block">
                                    {{ $jurnal->category ?? 'Uncategorized' }}
                                </span>
                                <h3 class="text-lg font-bold tracking-tight uppercase">{{ $jurnal->title }}</h3>
                                @if ($jurnal->description)
                                    <p class="text-sm text-[#f5f2ed]/40 font-light line-clamp-2 mt-2">{{ $jurnal->description }}</p>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-4 text-[10px] uppercase tracking-widest text-[#f5f2ed]/40">
                                <span>{{ $jurnal->created_at->format('M d, Y') }}</span>
                                <span>{{ $jurnal->slug }}</span>
                            </div>
                            <div class="flex items-center gap-2 pt-2">
                                <a href="{{ route('dashboard.jurnal.edit', $jurnal) }}" class="flex-1 text-center py-3 glass rounded-xl text-xs font-bold glass-hover">
                                    Edit
                                </a>
                                <form id="delete-jurnal-{{ $jurnal->id }}" method="POST" action="{{ route('dashboard.jurnal.destroy', $jurnal) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button
                                    type="button"
                                    data-alert-open="jurnal-delete-dialog"
                                    data-alert-title="Delete {{ $jurnal->title }}?"
                                    data-alert-description="This article and its thumbnail will be permanently removed. This action cannot be undone."
                                    data-alert-confirm="Delete Article"
                                    data-alert-form="delete-jurnal-{{ $jurnal->id }}"
                                    class="w-11 h-11 flex items-center justify-center glass rounded-xl glass-hover text-red-400"
                                    title="Delete article"
                                >
                                    <iconify-icon icon="lucide:trash-2"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <x-alert-dialog
        id="jurnal-delete-dialog"
        title="Delete this article?"
        description="This article and its thumbnail will be permanently removed. This action cannot be undone."
        confirm-label="Delete Article"
    />
</x-layout.dashboard>
