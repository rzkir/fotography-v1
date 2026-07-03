@php
    $team = $team ?? null;
    $socialMedia = old('social_media', $team?->social_media ?? [['type' => 'instagram', 'label' => '', 'link' => '']]);
    $socialMedia = collect($socialMedia)->map(fn (array $item): array => [
        'type' => $item['type'] ?? 'instagram',
        'label' => $item['label'] ?? '',
        'link' => $item['link'] ?? '',
    ])->values()->all();

    if ($socialMedia === []) {
        $socialMedia = [['type' => 'instagram', 'label' => '', 'link' => '']];
    }

    $socialTypeLabels = [
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'tiktok' => 'TikTok',
        'linkedin' => 'LinkedIn',
    ];
@endphp

<div class="card-photography rounded-[3rem] p-6 lg:p-10 relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#ff6b35]/5 rounded-full blur-[80px]"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
        <div class="space-y-6">
            <h3 class="text-lg font-display font-black flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:user-round" class="text-[#ff6b35]"></iconify-icon>
                Member Information
            </h3>

            <x-ui.input name="name" label="Name" :value="$team?->name" placeholder="Evan W." required />
            <x-ui.input name="job" label="Job Title" :value="$team?->job" placeholder="Lead Photographer" required />
        </div>

        <div class="space-y-6">
            <h3 class="text-lg font-display font-black flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:image" class="text-[#ff6b35]"></iconify-icon>
                Profile Picture
            </h3>

            <x-ui.upload
                name="picture"
                id="picture"
                label="Photo"
                :preview="$team?->pictureUrl()"
                hint="Square portrait recommended"
                previewAspect="1/1"
            />
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-display font-black flex items-center gap-2">
                <iconify-icon icon="lucide:share-2" class="text-[#ff6b35]"></iconify-icon>
                Social Media
            </h3>
            <button
                type="button"
                id="add-social-media"
                class="px-4 py-2 rounded-xl border border-white/5 text-xs font-black hover:bg-white/5 transition-all flex items-center gap-2"
            >
                <iconify-icon icon="lucide:plus"></iconify-icon>
                Add Link
            </button>
        </div>

        <div id="social-media-list" class="space-y-4">
            @foreach ($socialMedia as $index => $social)
                <div class="social-media-item card-photography rounded-2xl p-6 space-y-4" data-social-media-item>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 social-media-label">Link {{ $index + 1 }}</span>
                        <button
                            type="button"
                            data-remove-social-media
                            @class([
                                'text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors',
                                'hidden' => count($socialMedia) === 1,
                            ])
                        >
                            Remove
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Platform</label>
                            <select name="social_media[{{ $index }}][type]" data-field="type" class="input-field appearance-none cursor-pointer">
                                @foreach ($socialTypeLabels as $value => $label)
                                    <option value="{{ $value }}" @selected(($social['type'] ?? '') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-ui.input
                            name="social_media[{{ $index }}][label]"
                            label="Label"
                            :value="$social['label']"
                            placeholder="@evanw"
                            data-field="label"
                        />
                        <x-ui.input
                            name="social_media[{{ $index }}][link]"
                            label="Link"
                            type="url"
                            :value="$social['link']"
                            placeholder="https://instagram.com/evanw"
                            data-field="link"
                        />
                    </div>
                </div>
            @endforeach
        </div>

        <template id="social-media-template">
            <div class="social-media-item card-photography rounded-2xl p-6 space-y-4" data-social-media-item>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 social-media-label">Link</span>
                    <button type="button" data-remove-social-media class="text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors">
                        Remove
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Platform</label>
                        <select data-field="type" class="input-field appearance-none cursor-pointer">
                            @foreach ($socialTypeLabels as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Label</label>
                        <input type="text" data-field="label" class="input-field" placeholder="@evanw">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Link</label>
                        <input type="url" data-field="link" class="input-field" placeholder="https://instagram.com/evanw">
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
