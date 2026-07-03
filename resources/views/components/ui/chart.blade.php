@props([
    'bars' => [50, 66, 95, 45, 70, 55, 85, 40, 75, 60],
    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
    'highlightIndex' => 2,
    'shoots' => [],
])

<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <div class="xl:col-span-3 card-photography p-6 lg:p-10 rounded-[3rem]">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-10">
            <h2 class="text-2xl font-display font-black">Growth Analytics</h2>
            <div class="flex gap-2">
                <button type="button" class="px-4 py-2 bg-white/5 rounded-xl text-xs font-bold hover:bg-white/10 transition-colors">Week</button>
                <button type="button" class="px-4 py-2 bg-[#ff6b35] text-white rounded-xl text-xs font-bold">Month</button>
            </div>
        </div>

        <div class="h-[220px] lg:h-[280px] flex items-end justify-between gap-2 lg:gap-4">
            @foreach ($bars as $index => $height)
                <div
                    @class([
                        'flex-1 rounded-2xl relative group transition-all cursor-help',
                        'bg-gradient-to-t from-[#ff6b35]/20 to-[#ff6b35] shadow-[0_0_30px_rgba(255,107,53,0.3)]' => $index === $highlightIndex,
                        'bg-white/5 hover:h-[calc(var(--bar-h)+10%)]' => $index !== $highlightIndex,
                    ])
                    style="height: {{ $height }}%; --bar-h: {{ $height }}%;"
                >
                    @if ($index === $highlightIndex)
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white text-black text-[10px] font-black px-2 py-1 rounded scale-0 group-hover:scale-100 transition-all">
                            +12%
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex justify-between mt-8 text-[10px] text-zinc-600 font-black tracking-widest uppercase">
            @foreach ($labels as $label)
                <span>{{ $label }}</span>
            @endforeach
        </div>
    </div>

    <div class="card-photography p-6 lg:p-10 rounded-[3rem] bg-linear-to-br from-white/5 to-transparent">
        <h2 class="text-2xl font-display font-black mb-8">Upcoming Shoots</h2>

        <div class="space-y-8">
            @forelse ($shoots as $shoot)
                <div @class(['flex gap-5', 'opacity-50' => ($shoot['dimmed'] ?? false)])>
                    <div class="flex flex-col items-center justify-center w-14 h-14 bg-white/5 rounded-2xl shrink-0 border border-white/10">
                        <span class="text-xs font-black text-zinc-500 uppercase">{{ $shoot['month'] }}</span>
                        <span @class([
                            'text-xl font-display font-black',
                            'text-[#ff6b35]' => ($shoot['accent'] ?? 'orange') === 'orange',
                            'text-[#fb7185]' => ($shoot['accent'] ?? 'orange') === 'coral',
                        ])>{{ $shoot['day'] }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-black mb-0.5">{{ $shoot['title'] }}</p>
                        <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider">{{ $shoot['meta'] }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <iconify-icon icon="lucide:calendar-off" class="text-3xl text-zinc-600 mb-3"></iconify-icon>
                    <p class="text-sm text-zinc-500">No shoots scheduled yet</p>
                </div>
            @endforelse
        </div>

        <a href="/contact" class="block w-full mt-12 py-4 rounded-3xl bg-white text-black text-xs font-black tracking-[0.2em] text-center hover:bg-[#ff6b35] hover:text-white transition-all">
            OPEN CALENDAR
        </a>
    </div>
</div>
