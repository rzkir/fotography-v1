<x-layout.dashboard title="Team" active="teams">
    <x-slot:header>
        <x-layout.page-header title="Studio Team" :back="route('dashboard.index')">
            <x-slot:subtitle>Manage contributors and crew members</x-slot:subtitle>
            <x-slot:actions>
                <a href="{{ route('dashboard.teams.create') }}" class="px-6 lg:px-8 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Add Member
                </a>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    <div class="space-y-8">
        @if ($teams->isEmpty())
            <div class="card-photography rounded-[2.5rem] p-16 text-center">
                <iconify-icon icon="lucide:users" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                <h3 class="text-xl font-display font-black mb-2">No team members yet</h3>
                <p class="text-sm text-zinc-500 mb-8">Add your first studio contributor with photo, role, and social links.</p>
                <a href="{{ route('dashboard.teams.create') }}" class="inline-flex px-8 py-4 bg-[#ff6b35] text-white rounded-2xl text-sm font-black hover:scale-[1.02] transition-all">
                    Add Team Member
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach ($teams as $team)
                    <article class="card-photography rounded-[2.5rem] overflow-hidden">
                        <div class="aspect-square bg-zinc-900 overflow-hidden">
                            @if ($team->pictureUrl())
                                <img src="{{ $team->pictureUrl() }}" alt="{{ $team->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <iconify-icon icon="lucide:user-round" class="text-5xl text-zinc-700"></iconify-icon>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 lg:p-8 space-y-4">
                            <div>
                                <h3 class="text-xl font-display font-black uppercase">{{ $team->name }}</h3>
                                <p class="text-[10px] text-zinc-500 uppercase tracking-widest mt-1">{{ $team->job }}</p>
                                <p class="text-[10px] text-zinc-600 uppercase tracking-widest mt-2">{{ $team->number }} {{ Str::plural('project', $team->number) }}</p>
                            </div>

                            @if (count($team->social_media ?? []) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($team->social_media as $social)
                                        @php
                                            $icon = match ($social['type'] ?? '') {
                                                'facebook' => 'mdi:facebook',
                                                'tiktok' => 'ic:baseline-tiktok',
                                                'linkedin' => 'mdi:linkedin',
                                                default => 'mdi:instagram',
                                            };
                                        @endphp
                                        <a
                                            href="{{ $social['link'] }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 text-[10px] font-bold uppercase tracking-widest text-zinc-400 hover:text-white hover:border-white/20 transition-colors"
                                            title="{{ $social['label'] ?? $social['type'] }}"
                                        >
                                            <iconify-icon icon="{{ $icon }}"></iconify-icon>
                                            {{ $social['label'] ?? ucfirst($social['type']) }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <div class="flex items-center gap-2 pt-2">
                                <a href="{{ route('dashboard.teams.edit', $team) }}" class="flex-1 text-center py-3 bg-white/5 rounded-xl text-xs font-black hover:bg-[#ff6b35] hover:text-white transition-all">
                                    Edit
                                </a>
                                <form id="delete-team-{{ $team->id }}" method="POST" action="{{ route('dashboard.teams.destroy', $team) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button
                                    type="button"
                                    data-alert-open="team-delete-dialog"
                                    data-alert-title="Delete {{ $team->name }}?"
                                    data-alert-description="This team member will be permanently removed along with their profile photo."
                                    data-alert-confirm="Delete Member"
                                    data-alert-form="delete-team-{{ $team->id }}"
                                    class="w-11 h-11 flex items-center justify-center bg-white/5 rounded-xl hover:bg-red-500/20 text-red-400 transition-all"
                                    title="Delete member"
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

    @push('modals')
        <x-ui.alert-dialog
            id="team-delete-dialog"
            title="Delete this team member?"
            description="This team member will be permanently removed. This action cannot be undone."
            confirm-label="Delete Member"
        />
    @endpush
</x-layout.dashboard>
