<x-layout.dashboard title="Edit Team Member" active="teams" contentClass="pr-4">
    <x-slot:header>
        <x-layout.page-header title="Edit Team Member" :back="route('dashboard.teams.index')">
            <x-slot:subtitle>
                Update profile for <span class="text-[#ff6b35]">{{ $team->name }}</span>
            </x-slot:subtitle>
            <x-slot:actions>
                <a href="{{ route('dashboard.teams.index') }}" class="px-4 lg:px-6 py-3 rounded-xl border border-white/5 text-zinc-400 hover:text-white hover:bg-white/5 text-sm font-bold hidden sm:inline-flex transition-all">
                    Discard Changes
                </a>
                <button form="team-form" type="submit" class="px-6 lg:px-8 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Save Updates
                </button>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    <form id="team-form" method="POST" action="{{ route('dashboard.teams.update', $team) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('dashboard.teams._form', ['team' => $team])

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="card-photography rounded-[2rem] p-6 flex flex-col items-center text-center">
                <iconify-icon icon="lucide:history" class="text-2xl mb-3 text-zinc-600"></iconify-icon>
                <h4 class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Last Edited</h4>
                <p class="text-sm font-bold">{{ $team->updated_at->diffForHumans() }}</p>
            </div>
            <div class="card-photography rounded-[2rem] p-6 flex flex-col items-center text-center">
                <iconify-icon icon="lucide:briefcase" class="text-2xl mb-3 text-zinc-600"></iconify-icon>
                <h4 class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Projects Joined</h4>
                <p class="text-sm font-bold">{{ $team->number }}</p>
            </div>
            <div class="card-photography rounded-[2rem] p-6 flex flex-col items-center text-center">
                <iconify-icon icon="lucide:share-2" class="text-2xl mb-3 text-zinc-600"></iconify-icon>
                <h4 class="text-[10px] font-black uppercase tracking-widest text-zinc-500 mb-1">Social Links</h4>
                <p class="text-sm font-bold">{{ count($team->social_media ?? []) }} links</p>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('dashboard.teams.index') }}" class="px-8 py-4 rounded-xl border border-white/5 text-sm font-bold hover:bg-white/5 transition-all">
                Cancel Changes
            </a>
            <button type="submit" class="px-10 py-4 bg-[#ff6b35] text-white rounded-xl text-sm font-black hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-orange-500/20">
                Confirm & Save Updates
            </button>
        </div>
    </form>
</x-layout.dashboard>
