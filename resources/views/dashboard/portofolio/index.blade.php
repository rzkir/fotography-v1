<x-layout.dashboard title="Projects" active="projects">
    <x-slot:header>
        <x-layout.page-header title="Portfolio Projects" :back="route('dashboard.index')">
            <x-slot:subtitle>Manage case studies and selected works</x-slot:subtitle>
            <x-slot:actions>
                <a href="{{ route('dashboard.portofolio.create') }}" class="px-6 lg:px-8 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    New Project
                </a>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    <div class="space-y-8">
        @if ($portfolios->isEmpty())
            <div class="card-photography rounded-[2.5rem] p-16 text-center">
                <iconify-icon icon="lucide:folder-open" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                <h3 class="text-xl font-display font-black mb-2">No projects yet</h3>
                <p class="text-sm text-zinc-500 mb-8">Create your first portfolio case study to showcase on Selected Works.</p>
                <a href="{{ route('dashboard.portofolio.create') }}" class="inline-flex px-8 py-4 bg-[#ff6b35] text-white rounded-2xl text-sm font-black hover:scale-[1.02] transition-all">
                    Create Project
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach ($portfolios as $portfolio)
                    @php
                        $photoCount = count($portfolio->gallery_images ?? []);
                        $statusConfig = match ($portfolio->status) {
                            'published' => ['label' => 'Published', 'color' => 'bg-teal-400', 'tag' => 'LIVE', 'tagClass' => 'bg-teal-500/20 text-teal-300 border-teal-500/20'],
                            'draft' => ['label' => 'Draft', 'color' => 'bg-orange-400', 'tag' => 'DRAFT', 'tagClass' => 'bg-orange-500/20 text-orange-300 border-orange-500/20'],
                            default => ['label' => 'Archived', 'color' => 'bg-zinc-600', 'tag' => 'ARCHIVED', 'tagClass' => 'bg-zinc-500/20 text-zinc-400 border-zinc-500/20'],
                        };
                    @endphp
                    <article class="group relative aspect-[4/3] rounded-[2.5rem] overflow-hidden card-photography border-0">
                        @if ($portfolio->heroImageUrl())
                            <img src="{{ $portfolio->heroImageUrl() }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-zinc-900 flex items-center justify-center">
                                <iconify-icon icon="lucide:image" class="text-5xl text-zinc-700"></iconify-icon>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-90"></div>
                        <div class="absolute bottom-0 left-0 p-6 lg:p-8 w-full">
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <span class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-bold border border-white/10 uppercase">
                                    {{ $portfolio->category ?? 'General' }}
                                </span>
                                <span class="px-3 py-1 backdrop-blur-md rounded-full text-[10px] font-bold border {{ $statusConfig['tagClass'] }}">
                                    {{ $statusConfig['tag'] }}
                                </span>
                            </div>
                            <h3 class="text-xl lg:text-2xl font-display font-black mb-1">{{ $portfolio->title }}</h3>
                            @if ($portfolio->subtitle)
                                <p class="text-zinc-400 text-xs italic mb-2">{{ $portfolio->subtitle }}</p>
                            @endif
                            <p class="text-zinc-400 text-xs mb-4">
                                {{ $photoCount }} photos
                                @if ($portfolio->year) • {{ $portfolio->year }} @endif
                                @if ($portfolio->location) • {{ $portfolio->location }} @endif
                            </p>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('dashboard.portofolio.edit', $portfolio) }}" class="flex-1 text-center py-3 bg-white/10 backdrop-blur-md rounded-xl text-xs font-black hover:bg-[#ff6b35] hover:text-white transition-all">
                                    Edit
                                </a>
                                <form id="delete-portfolio-{{ $portfolio->id }}" method="POST" action="{{ route('dashboard.portofolio.destroy', $portfolio) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button
                                    type="button"
                                    data-alert-open="portfolio-delete-dialog"
                                    data-alert-title="Delete {{ $portfolio->title }}?"
                                    data-alert-description="This project and all uploaded images will be permanently removed. This action cannot be undone."
                                    data-alert-confirm="Delete Project"
                                    data-alert-form="delete-portfolio-{{ $portfolio->id }}"
                                    class="w-11 h-11 flex items-center justify-center bg-white/10 backdrop-blur-md rounded-xl hover:bg-red-500/20 text-red-400 transition-all"
                                    title="Delete project"
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
        id="portfolio-delete-dialog"
        title="Delete this project?"
        description="This project and all uploaded images will be permanently removed. This action cannot be undone."
        confirm-label="Delete Project"
    />
</x-layout.dashboard>
