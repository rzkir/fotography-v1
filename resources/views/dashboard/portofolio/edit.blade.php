<x-layout.dashboard title="Edit Project" active="projects" contentClass="pr-4">
    <x-slot:header>
        <div data-page-loading>
            <div data-page-skeleton>
                <x-skeleton.portfolio-header />
            </div>

            <header data-page-content class="hidden h-24 glass rounded-[2.5rem] flex items-center justify-between px-6 lg:px-10 flex-shrink-0 min-w-0 gap-4">
                <div class="flex items-center gap-4 min-w-0">
                    <a href="{{ route('dashboard.portofolio.index') }}" class="w-12 h-12 rounded-2xl glass flex items-center justify-center hover:bg-white/10 transition-colors flex-shrink-0">
                        <iconify-icon icon="lucide:chevron-left" class="text-xl"></iconify-icon>
                    </a>
                    <div class="min-w-0">
                        <h1 class="text-xl lg:text-2xl font-bold tracking-tight truncate">Edit Project</h1>
                        <p class="text-xs text-[#f5f2ed]/40 font-light truncate">
                            Modify specifications for <span class="text-[#f5f2ed] font-medium">{{ $portfolio->title }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="{{ route('dashboard.portofolio.index') }}" class="px-4 lg:px-6 py-3 rounded-2xl glass-hover opacity-60 text-sm font-semibold hidden sm:inline-flex">
                        Discard Changes
                    </a>
                    <button form="portfolio-form" type="submit" class="px-6 lg:px-8 py-3 bg-[#f5f2ed] text-[#0d0d0d] rounded-2xl text-sm font-bold shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Save Updates
                    </button>
                </div>
            </header>
        </div>
    </x-slot:header>

    <div data-page-loading>
        <div data-page-skeleton>
            <x-skeleton.portfolio-form />
        </div>

        <div data-page-content class="hidden space-y-6">
            <form id="portfolio-form" method="POST" action="{{ route('dashboard.portofolio.update', $portfolio) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                @include('dashboard.portofolio._form', ['portfolio' => $portfolio])

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="glass rounded-[2rem] p-6 flex flex-col items-center text-center">
                        <iconify-icon icon="lucide:history" class="text-2xl mb-3 opacity-30"></iconify-icon>
                        <h4 class="text-xs font-bold uppercase tracking-widest mb-1">Last Edited</h4>
                        <p class="text-sm opacity-60">{{ $portfolio->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="glass rounded-[2rem] p-6 flex flex-col items-center text-center">
                        <iconify-icon icon="lucide:images" class="text-2xl mb-3 opacity-30"></iconify-icon>
                        <h4 class="text-xs font-bold uppercase tracking-widest mb-1">Gallery Items</h4>
                        <p class="text-sm opacity-60">{{ count($portfolio->gallery_images ?? []) }} images</p>
                    </div>
                    <div class="glass rounded-[2rem] p-6 flex flex-col items-center text-center">
                        <iconify-icon icon="lucide:link" class="text-2xl mb-3 opacity-30"></iconify-icon>
                        <h4 class="text-xs font-bold uppercase tracking-widest mb-1">Slug</h4>
                        <p class="text-sm opacity-60 truncate max-w-full">{{ $portfolio->slug }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('dashboard.portofolio.index') }}" class="px-8 py-4 rounded-2xl glass transition-all hover:bg-white/10 text-sm font-bold">
                        Cancel Changes
                    </a>
                    <button type="submit" class="px-10 py-4 bg-[#f5f2ed] text-[#0d0d0d] rounded-2xl text-sm font-bold hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-white/5">
                        Confirm & Save Updates
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout.dashboard>
