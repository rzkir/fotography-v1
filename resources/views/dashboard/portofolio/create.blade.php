<x-layout.dashboard title="Create Project" active="projects" contentClass="pr-4">
    <x-slot:header>
        <header class="h-24 glass rounded-[2.5rem] flex items-center justify-between px-6 lg:px-10 flex-shrink-0 min-w-0 gap-4">
            <div class="flex items-center gap-4 min-w-0">
                <a href="{{ route('dashboard.portofolio.index') }}" class="w-12 h-12 rounded-2xl glass flex items-center justify-center hover:bg-white/10 transition-colors flex-shrink-0">
                    <iconify-icon icon="lucide:chevron-left" class="text-xl"></iconify-icon>
                </a>
                <div class="min-w-0">
                    <h1 class="text-xl lg:text-2xl font-bold tracking-tight truncate">Create Project</h1>
                    <p class="text-xs text-[#f5f2ed]/40 font-light truncate">Add a new portfolio case study</p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('dashboard.portofolio.index') }}" class="px-4 lg:px-6 py-3 rounded-2xl glass-hover opacity-60 text-sm font-semibold hidden sm:inline-flex">
                    Discard
                </a>
                <button form="portfolio-form" type="submit" class="px-6 lg:px-8 py-3 bg-[#f5f2ed] text-[#0d0d0d] rounded-2xl text-sm font-bold shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Save Project
                </button>
            </div>
        </header>
    </x-slot:header>

    <form id="portfolio-form" method="POST" action="{{ route('dashboard.portofolio.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('dashboard.portofolio._form')

        <div class="flex justify-end gap-4">
            <a href="{{ route('dashboard.portofolio.index') }}" class="px-8 py-4 rounded-2xl glass transition-all hover:bg-white/10 text-sm font-bold">
                Cancel
            </a>
            <button type="submit" class="px-10 py-4 bg-[#f5f2ed] text-[#0d0d0d] rounded-2xl text-sm font-bold hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-white/5">
                Confirm & Save Project
            </button>
        </div>
    </form>
</x-layout.dashboard>
