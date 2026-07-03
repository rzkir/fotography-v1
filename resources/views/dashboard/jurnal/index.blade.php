<x-layout.dashboard title="Journal" active="journal">
    <x-slot:header>
        <x-layout.page-header title="Studio Journal" :back="route('dashboard.index')">
            <x-slot:subtitle>Manage articles, essays, and editorial writing</x-slot:subtitle>
            <x-slot:actions>
                <a href="{{ route('dashboard.jurnal.create') }}" class="px-6 lg:px-8 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    New Article
                </a>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    <div class="space-y-8">
        @if ($jurnals->isEmpty())
            <div class="card-photography rounded-[2.5rem] p-16 text-center">
                <iconify-icon icon="lucide:book-open" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                <h3 class="text-xl font-display font-black mb-2">No articles yet</h3>
                <p class="text-sm text-zinc-500 mb-8">Write your first journal entry — craft essays, technique notes, or editorial stories for the public Journal page.</p>
                <a href="{{ route('dashboard.jurnal.create') }}" class="inline-flex px-8 py-4 bg-[#ff6b35] text-white rounded-2xl text-sm font-black hover:scale-[1.02] transition-all">
                    Create Article
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach ($jurnals as $jurnal)
                    @php
                        $statusConfig = match ($jurnal->status) {
                            'published' => ['tag' => 'LIVE', 'tagClass' => 'bg-teal-500/20 text-teal-300 border-teal-500/20'],
                            'draft' => ['tag' => 'DRAFT', 'tagClass' => 'bg-orange-500/20 text-orange-300 border-orange-500/20'],
                            default => ['tag' => 'ARCHIVED', 'tagClass' => 'bg-zinc-500/20 text-zinc-400 border-zinc-500/20'],
                        };
                    @endphp
                    <article class="group relative aspect-[4/3] rounded-[2.5rem] overflow-hidden card-photography border-0">
                        @if ($jurnal->thumbnailUrl())
                            <img src="{{ $jurnal->thumbnailUrl() }}" alt="{{ $jurnal->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-zinc-900 flex items-center justify-center">
                                <iconify-icon icon="lucide:book-open" class="text-5xl text-zinc-700"></iconify-icon>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 p-6 lg:p-8 w-full">
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <span class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-bold border border-white/10 uppercase">
                                    {{ $jurnal->category ?? 'Uncategorized' }}
                                </span>
                                <span class="px-3 py-1 backdrop-blur-md rounded-full text-[10px] font-bold border {{ $statusConfig['tagClass'] }}">
                                    {{ $statusConfig['tag'] }}
                                </span>
                            </div>
                            <h3 class="text-xl lg:text-2xl font-display font-black mb-1 uppercase">{{ $jurnal->title }}</h3>
                            @if ($jurnal->description)
                                <p class="text-zinc-400 text-xs line-clamp-2 mb-4">{{ $jurnal->description }}</p>
                            @else
                                <p class="text-zinc-400 text-xs mb-4">{{ $jurnal->created_at->format('M d, Y') }}</p>
                            @endif
                            <div class="flex items-center gap-2">
                                <a href="{{ route('dashboard.jurnal.edit', $jurnal) }}" class="flex-1 text-center py-3 bg-white/10 backdrop-blur-md rounded-xl text-xs font-black hover:bg-[#ff6b35] hover:text-white transition-all">
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
                                    class="w-11 h-11 flex items-center justify-center bg-white/10 backdrop-blur-md rounded-xl hover:bg-red-500/20 text-red-400 transition-all"
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

    <x-ui.alert-dialog
        id="jurnal-delete-dialog"
        title="Delete this article?"
        description="This article and its thumbnail will be permanently removed. This action cannot be undone."
        confirm-label="Delete Article"
    />
</x-layout.dashboard>
