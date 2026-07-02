<div class="space-y-6">
    <div class="glass rounded-[3rem] p-6 lg:p-10 space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
            <div class="space-y-6">
                <x-skeleton width="w-40" height="h-6" />
                @foreach (range(1, 8) as $item)
                    <div class="space-y-2">
                        <x-skeleton width="w-24" height="h-3" rounded="rounded-md" />
                        <x-skeleton height="h-12" />
                    </div>
                @endforeach
            </div>

            <div class="space-y-6">
                <x-skeleton width="w-36" height="h-6" />
                <div class="space-y-2">
                    <x-skeleton width="w-28" height="h-3" rounded="rounded-md" />
                    <x-skeleton height="h-36" rounded="rounded-[1.25rem]" />
                </div>
                <div class="space-y-2">
                    <x-skeleton width="w-28" height="h-3" rounded="rounded-md" />
                    <x-skeleton height="h-12" />
                </div>
                <div class="grid grid-cols-3 gap-2">
                    @foreach (range(1, 3) as $item)
                        <x-skeleton height="h-24" rounded="rounded-xl" />
                    @endforeach
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-white/5 space-y-4">
            <x-skeleton width="w-48" height="h-6" />
            @foreach (range(1, 2) as $item)
                <div class="glass rounded-2xl p-6 space-y-4">
                    <x-skeleton width="w-20" height="h-3" rounded="rounded-md" />
                    <x-skeleton height="h-12" />
                    <x-skeleton height="h-24" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach (range(1, 3) as $item)
            <div class="glass rounded-[2rem] p-6 flex flex-col items-center gap-3">
                <x-skeleton width="w-10" height="h-10" rounded="rounded-2xl" />
                <x-skeleton width="w-24" height="h-3" rounded="rounded-md" />
                <x-skeleton width="w-32" height="h-4" />
            </div>
        @endforeach
    </div>

    <div class="flex justify-end gap-4">
        <x-skeleton width="w-36" height="h-14" rounded="rounded-2xl" />
        <x-skeleton width="w-48" height="h-14" rounded="rounded-2xl" />
    </div>
</div>
