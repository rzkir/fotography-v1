<x-layout.dashboard title="Edit Article" active="journal" contentClass="pr-4">
    <x-slot:header>
        <div data-page-loading>
            <div data-page-skeleton>
                <x-ui.skeleton.portfolio-header />
            </div>

            <div data-page-content class="hidden">
                <x-layout.page-header title="Edit Article" :back="route('dashboard.jurnal.index')">
                    <x-slot:subtitle>
                        Modify <span class="text-[#ff6b35]">{{ $jurnal->title }}</span>
                    </x-slot:subtitle>
                    <x-slot:actions>
                        <a href="{{ route('dashboard.jurnal.index') }}" class="px-4 lg:px-6 py-3 rounded-xl border border-white/5 text-zinc-400 hover:text-white hover:bg-white/5 text-sm font-bold hidden sm:inline-flex transition-all">
                            Discard Changes
                        </a>
                        <button form="jurnal-form" type="submit" class="px-6 lg:px-8 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            Save Updates
                        </button>
                    </x-slot:actions>
                </x-layout.page-header>
            </div>
        </div>
    </x-slot:header>

    <div data-page-loading>
        <div data-page-skeleton>
            <x-ui.skeleton.portfolio-form />
        </div>

        <div data-page-content class="hidden space-y-6">
            <form id="jurnal-form" method="POST" action="{{ route('dashboard.jurnal.update', $jurnal) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                @include('dashboard.jurnal._form', ['jurnal' => $jurnal, 'categories' => $categories])

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="card-photography rounded-[2rem] p-6 flex flex-col items-center text-center">
                        <iconify-icon icon="lucide:history" class="text-2xl mb-3 text-zinc-600"></iconify-icon>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Last Edited</h4>
                        <p class="text-sm font-bold">{{ $jurnal->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="card-photography rounded-[2rem] p-6 flex flex-col items-center text-center">
                        <iconify-icon icon="lucide:calendar" class="text-2xl mb-3 text-zinc-600"></iconify-icon>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Published</h4>
                        <p class="text-sm font-bold">{{ $jurnal->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="card-photography rounded-[2rem] p-6 flex flex-col items-center text-center">
                        <iconify-icon icon="lucide:link" class="text-2xl mb-3 text-zinc-600"></iconify-icon>
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Slug</h4>
                        <p class="text-sm font-bold truncate max-w-full">{{ $jurnal->slug }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('dashboard.jurnal.index') }}" class="px-8 py-4 rounded-xl border border-white/5 text-sm font-bold hover:bg-white/5 transition-all">
                        Cancel Changes
                    </a>
                    <button type="submit" class="px-10 py-4 bg-[#ff6b35] text-white rounded-xl text-sm font-black hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-orange-500/20">
                        Confirm & Save Updates
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout.dashboard>
