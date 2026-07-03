<x-layout.dashboard title="Dashboard" active="workspace">
    <div class="space-y-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-ui.card
                icon="lucide:flame"
                label="Total Views"
                :value="number_format($stats['views'])"
                theme="orange"
                badge="HOT"
            >
                <x-slot:footer>
                    <div class="flex items-center gap-2 text-emerald-400 text-xs font-bold">
                        <iconify-icon icon="lucide:trending-up"></iconify-icon>
                        <span>+24% this week</span>
                    </div>
                </x-slot:footer>
            </x-ui.card>

            <x-ui.card
                icon="lucide:camera"
                label="Total Shoots"
                :value="(string) $stats['projects']"
                theme="teal"
            >
                <x-slot:footer>
                    <div class="w-full bg-zinc-800/50 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-teal-400 h-full" style="width: {{ min(100, $stats['projects'] > 0 ? ($stats['published'] / $stats['projects']) * 100 : 0) }}%"></div>
                    </div>
                </x-slot:footer>
            </x-ui.card>

            <x-ui.card
                icon="lucide:heart"
                label="Appreciations"
                :value="number_format($stats['appreciations'])"
                theme="coral"
            >
                <x-slot:footer>
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full border-2 border-[#0d0d0d] bg-zinc-800"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-[#0d0d0d] bg-zinc-700"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-[#0d0d0d] bg-zinc-600"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-[#0d0d0d] bg-zinc-900 flex items-center justify-center text-[10px] font-bold">+{{ number_format($stats['appreciations'] / 1000, 1) }}k</div>
                    </div>
                </x-slot:footer>
            </x-ui.card>

            <x-ui.card
                icon="lucide:zap"
                label="Est. Earnings"
                value="${{ number_format($stats['earnings'] / 1000, 1) }}k"
                theme="indigo"
            >
                <x-slot:footer>
                    <div class="flex items-center gap-2 text-indigo-400 text-xs font-bold">
                        <span>Payout in 2 days</span>
                    </div>
                </x-slot:footer>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <div class="flex flex-wrap justify-between items-end gap-4">
                <div class="space-y-1">
                    <h2 class="text-2xl lg:text-3xl font-display font-black tracking-tight">Active Projects</h2>
                    <p class="text-zinc-500">In-progress gallery management</p>
                </div>
                <a id="view-all-projects" href="{{ route('dashboard.portofolio.index') }}" class="text-xs font-black tracking-widest text-[#ff6b35] hover:underline underline-offset-8">
                    EXPLORE FULL ARCHIVE
                </a>
            </div>

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
                                'published' => ['label' => 'Published', 'color' => 'bg-teal-400', 'tag' => 'EDITING', 'tagClass' => 'bg-teal-500/20 text-teal-300 border-teal-500/20'],
                                'draft' => ['label' => 'Draft — In Progress', 'color' => 'bg-orange-400', 'tag' => 'URGENT', 'tagClass' => 'bg-orange-500/20 text-orange-300 border-orange-500/20'],
                                default => ['label' => 'Archived', 'color' => 'bg-zinc-600', 'tag' => 'NEW', 'tagClass' => 'bg-rose-500/20 text-rose-300 border border-rose-500/20'],
                            };
                        @endphp
                        <div class="group relative aspect-[4/3] rounded-[2.5rem] overflow-hidden card-photography border-0">
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
                                        {{ $portfolio->portfolioCategory?->title ?? 'General' }}
                                    </span>
                                    <span class="px-3 py-1 backdrop-blur-md rounded-full text-[10px] font-bold border {{ $statusConfig['tagClass'] }}">
                                        {{ $statusConfig['tag'] }}
                                    </span>
                                </div>
                                <h4 class="text-xl lg:text-2xl font-display font-black mb-1">{{ $portfolio->title }}</h4>
                                <p class="text-zinc-400 text-xs mb-6">
                                    {{ $photoCount }} photos
                                    @if ($portfolio->client)
                                        • Client: {{ $portfolio->client }}
                                    @endif
                                </p>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-2 text-xs font-bold">
                                        <div @class(['w-2 h-2 rounded-full', $statusConfig['color'], 'animate-pulse' => $portfolio->status === 'published'])></div>
                                        <span>Status: {{ $statusConfig['label'] }}</span>
                                    </div>
                                    <a href="{{ route('dashboard.portofolio.edit', $portfolio) }}" class="w-10 h-10 rounded-full bg-white text-black flex items-center justify-center hover:bg-[#ff6b35] hover:text-white transition-all">
                                        <iconify-icon icon="lucide:arrow-up-right" class="text-xl"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <x-ui.chart :shoots="$shoots" />
    </div>
</x-layout.dashboard>
