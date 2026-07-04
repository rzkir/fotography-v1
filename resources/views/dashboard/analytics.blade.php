<x-layout.dashboard title="Analytics" active="analytics">
    <x-slot:header>
        <x-layout.page-header title="Web Analytics" :back="route('dashboard.index')">
            <x-slot:subtitle>Visitor insights, geography, and traffic sources</x-slot:subtitle>
            <x-slot:actions>
                <span class="hidden sm:inline-flex text-[10px] font-black bg-zinc-900 text-zinc-500 px-3 py-1.5 rounded-lg border border-white/5 uppercase tracking-widest">
                    Last 30 days
                </span>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    <div class="space-y-12">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <x-ui.card
                icon="lucide:users"
                label="Unique Visitors"
                :value="number_format($stats['visitors'])"
                theme="orange"
                badge="LIVE"
            >
                <x-slot:footer>
                    @php
                        $visitorTrendUp = $stats['visitors_change'] >= 0;
                    @endphp
                    <div @class([
                        'flex items-center gap-2 text-xs font-bold',
                        'text-emerald-400' => $visitorTrendUp,
                        'text-rose-400' => ! $visitorTrendUp,
                    ])>
                        <iconify-icon icon="{{ $visitorTrendUp ? 'lucide:trending-up' : 'lucide:trending-down' }}"></iconify-icon>
                        <span>{{ $visitorTrendUp ? '+' : '' }}{{ number_format($stats['visitors_change'], 1) }}% vs previous period</span>
                    </div>
                </x-slot:footer>
            </x-ui.card>

            <x-ui.card
                icon="lucide:eye"
                label="Page Views"
                :value="number_format($stats['page_views'])"
                theme="teal"
            >
                <x-slot:footer>
                    @php
                        $pageViewTrendUp = $stats['page_views_change'] >= 0;
                    @endphp
                    <div @class([
                        'flex items-center gap-2 text-xs font-bold',
                        'text-teal-400' => $pageViewTrendUp,
                        'text-rose-400' => ! $pageViewTrendUp,
                    ])>
                        <iconify-icon icon="{{ $pageViewTrendUp ? 'lucide:activity' : 'lucide:activity' }}"></iconify-icon>
                        <span>{{ $pageViewTrendUp ? '+' : '' }}{{ number_format($stats['page_views_change'], 1) }}% vs previous period</span>
                    </div>
                </x-slot:footer>
            </x-ui.card>

            <x-ui.card
                icon="lucide:door-open"
                label="Bounce Rate"
                :value="number_format($stats['bounce_rate'], 1).'%'"
                theme="coral"
            >
                <x-slot:footer>
                    <div class="flex items-center gap-2 text-zinc-500 text-xs font-bold">
                        <iconify-icon icon="lucide:clock-3"></iconify-icon>
                        <span>Last 30 days of public traffic</span>
                    </div>
                </x-slot:footer>
            </x-ui.card>

            <x-ui.card
                icon="lucide:timer"
                label="Avg. Session"
                :value="$stats['avg_session']"
                theme="indigo"
            >
                <x-slot:footer>
                    <div class="flex items-center gap-2 text-indigo-400 text-xs font-bold">
                        <span>Multi-page sessions only</span>
                    </div>
                </x-slot:footer>
            </x-ui.card>
        </div>

        <x-ui.chart
            title="Visitor Traffic"
            :bars="$traffic_bars"
            :labels="$traffic_labels"
            :highlight-index="$highlight_index"
            :highlight-label="$highlight_label"
        >
            <x-slot:sidebar>
                <div class="flex items-center justify-between gap-4 mb-8">
                    <h2 class="text-2xl font-display font-black">Top Countries</h2>
                    <iconify-icon icon="lucide:globe-2" class="text-2xl text-[#ff6b35]"></iconify-icon>
                </div>

                <div class="space-y-5">
                    @forelse ($countries as $country)
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-2">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-[10px] font-black shrink-0">
                                        {{ $country['code'] }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-black truncate">{{ $country['name'] }}</p>
                                        <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider">
                                            {{ number_format($country['visitors']) }} visitors
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs font-black text-[#ff6b35] shrink-0">
                                    {{ number_format($country['percent'], 1) }}%
                                </span>
                            </div>
                            <x-ui.progress
                                :value="$country['percent']"
                                size="sm"
                                theme="orange"
                                :animated="false"
                            />
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <iconify-icon icon="lucide:globe" class="text-3xl text-zinc-600 mb-3"></iconify-icon>
                            <p class="text-sm text-zinc-500">No visitor data yet</p>
                        </div>
                    @endforelse
                </div>

                <p class="mt-8 text-[10px] text-zinc-600 font-bold uppercase tracking-widest">
                    Live data from public site visits
                </p>
            </x-slot:sidebar>
        </x-ui.chart>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 card-photography p-6 lg:p-10 rounded-[3rem]">
                <div class="flex items-center justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-2xl font-display font-black">Top Pages</h2>
                        <p class="text-sm text-zinc-500 mt-1">Most visited routes on your public site</p>
                    </div>
                    <iconify-icon icon="lucide:file-bar-chart" class="text-2xl text-teal-400"></iconify-icon>
                </div>

                <div class="space-y-4">
                    @forelse ($top_pages as $index => $page)
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/2 border border-white/5 hover:bg-white/4 transition-colors">
                            <span class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center text-xs font-black text-zinc-500 shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black truncate">{{ $page['title'] }}</p>
                                <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider truncate">{{ $page['path'] }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-black">{{ number_format($page['views']) }}</p>
                                <p class="text-[10px] text-zinc-500 font-bold">{{ number_format($page['percent'], 1) }}%</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <iconify-icon icon="lucide:file-x" class="text-3xl text-zinc-600 mb-3"></iconify-icon>
                            <p class="text-sm text-zinc-500">Visit your public pages to start collecting data</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-8">
                <div class="card-photography p-6 lg:p-8 rounded-[3rem]">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h2 class="text-xl font-display font-black">Devices</h2>
                        <iconify-icon icon="lucide:layers" class="text-xl text-indigo-400"></iconify-icon>
                    </div>

                    <div class="space-y-5">
                        @forelse ($devices as $device)
                            <div>
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <div class="flex items-center gap-2">
                                        <iconify-icon icon="{{ $device['icon'] }}" class="text-lg text-zinc-400"></iconify-icon>
                                        <span class="text-sm font-black">{{ $device['name'] }}</span>
                                    </div>
                                    <span class="text-xs font-black text-indigo-400">{{ number_format($device['percent'], 1) }}%</span>
                                </div>
                                <x-ui.progress
                                    :value="$device['percent']"
                                    size="sm"
                                    theme="indigo"
                                    :animated="false"
                                />
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 text-center py-4">No device data yet</p>
                        @endforelse
                    </div>
                </div>

                <div class="card-photography p-6 lg:p-8 rounded-[3rem]">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h2 class="text-xl font-display font-black">Traffic Sources</h2>
                        <iconify-icon icon="lucide:share-2" class="text-xl text-[#fb7185]"></iconify-icon>
                    </div>

                    <div class="space-y-5">
                        @forelse ($referrers as $referrer)
                            <div>
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <span class="text-sm font-black">{{ $referrer['name'] }}</span>
                                    <span class="text-xs font-black text-[#fb7185]">{{ number_format($referrer['percent'], 1) }}%</span>
                                </div>
                                <x-ui.progress
                                    :value="$referrer['percent']"
                                    size="sm"
                                    theme="coral"
                                    :animated="false"
                                />
                                <p class="text-[10px] text-zinc-600 font-bold uppercase tracking-wider mt-1">
                                    {{ number_format($referrer['visitors']) }} visitors
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 text-center py-4">No referrer data yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.dashboard>
