<x-layout.dashboard title="Create Project" active="projects" contentClass="pr-4">
    <x-slot:header>
        <x-layout.page-header title="Create Project" :back="route('dashboard.portofolio.index')">
            <x-slot:subtitle>Add a new portfolio case study</x-slot:subtitle>
            <x-slot:actions>
                <a href="{{ route('dashboard.portofolio.index') }}" class="px-4 lg:px-6 py-3 rounded-xl border border-white/5 text-zinc-400 hover:text-white hover:bg-white/5 text-sm font-bold hidden sm:inline-flex transition-all">
                    Discard
                </a>
                <button form="portfolio-form" type="submit" class="px-6 lg:px-8 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Save Project
                </button>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    <form id="portfolio-form" method="POST" action="{{ route('dashboard.portofolio.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('dashboard.portofolio._form', ['categories' => $categories ?? collect()])

        <div class="flex justify-end gap-4">
            <a href="{{ route('dashboard.portofolio.index') }}" class="px-8 py-4 rounded-xl border border-white/5 text-sm font-bold hover:bg-white/5 transition-all">
                Cancel
            </a>
            <button type="submit" class="px-10 py-4 bg-[#ff6b35] text-white rounded-xl text-sm font-black hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-orange-500/20">
                Confirm & Save Project
            </button>
        </div>
    </form>
</x-layout.dashboard>
