@php
    $portfolio = $portfolio ?? null;
    $metrics = $portfolio?->metrics ?? [];
    $specs = $portfolio?->technical_specs ?? [];
    $testimonial = $portfolio?->testimonial ?? [];
    $contentSections = old('content_sections', $portfolio?->content_sections ?? [['title' => '', 'description' => '']]);
    $contentSections = collect($contentSections)->map(fn (array $section): array => [
        'title' => $section['title'] ?? '',
        'description' => $section['description'] ?? ($section['content'] ?? ''),
    ])->values()->all();

    if ($contentSections === []) {
        $contentSections = [['title' => '', 'description' => '']];
    }

    $postProcessingRaw = old('post_processing', $specs['post_processing'] ?? [['title' => '', 'text' => '']]);
    if (is_string($postProcessingRaw)) {
        $postProcessingRaw = [['title' => '', 'text' => $postProcessingRaw]];
    }
    $postProcessingSteps = collect($postProcessingRaw)->map(function (mixed $step): array {
        if (! is_array($step)) {
            return ['title' => '', 'text' => (string) $step];
        }

        return [
            'title' => $step['title'] ?? '',
            'text' => $step['text'] ?? ($step['description'] ?? ''),
        ];
    })->values()->all();

    if ($postProcessingSteps === []) {
        $postProcessingSteps = [['title' => '', 'text' => '']];
    }

    $timelineItems = old('timeline', $portfolio?->timeline ?? [['title' => '', 'text' => '']]);
    $timelineItems = collect($timelineItems)->map(fn (array $item): array => [
        'title' => $item['title'] ?? '',
        'text' => $item['text'] ?? ($item['description'] ?? ''),
    ])->values()->all();

    if ($timelineItems === []) {
        $timelineItems = [['title' => '', 'text' => '']];
    }

    $teamOptions = $teams ?? collect();
    $teamMembersRaw = old('team_members');

    if ($teamMembersRaw === null && $portfolio?->relationLoaded('teams')) {
        $teamMembersRaw = $portfolio->teams->map(fn ($team): array => [
            'team_id' => $team->id,
            'description' => $team->pivot->description ?? '',
        ])->values()->all();
    }

    $teamMembers = collect($teamMembersRaw ?? [])->map(fn (array $member): array => [
        'team_id' => $member['team_id'] ?? '',
        'description' => $member['description'] ?? '',
    ])->values()->all();

    if ($teamMembers === []) {
        $teamMembers = [['team_id' => '', 'description' => '']];
    }
@endphp

<div class="card-photography rounded-[3rem] p-6 lg:p-10 relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#ff6b35]/5 rounded-full blur-[80px]"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
        <div class="space-y-6">
            <h3 class="text-lg font-display font-black flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:file-text" class="text-[#ff6b35]"></iconify-icon>
                Basic Information
            </h3>

            <x-ui.input name="title" id="title" label="Project Title" :value="$portfolio?->title" placeholder="Midnight Soul" required />
            <div class="space-y-2">
                <x-ui.input name="slug" id="slug" label="Slug" :value="$portfolio?->slug" placeholder="midnight-soul" />
                <p class="text-[10px] text-[#f5f2ed]/30 px-1">Auto-generated from title. Edit manually if needed.</p>
            </div>
            <x-ui.input name="subtitle" label="Subtitle (Italic)" :value="$portfolio?->subtitle" placeholder="soul" />
            <x-ui.input name="client" label="Client" :value="$portfolio?->client" placeholder="Personal Editorial" />
            <x-ui.input name="year" label="Year" type="number" :value="$portfolio?->year ?? date('Y')" required />

            <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label for="category_id" class="text-[10px] uppercase tracking-widest font-black text-zinc-500 px-1">Category</label>
                @if (($categories ?? collect())->isNotEmpty())
                    <select name="category_id" id="category_id" class="input-field appearance-none cursor-pointer">
                        <option value="">Select category</option>
                        @foreach ($categories as $categoryOption)
                            <option value="{{ $categoryOption->category_id }}" @selected(old('category_id', $portfolio?->category_id) === $categoryOption->category_id)>
                                {{ $categoryOption->title }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-zinc-600 px-1">
                        <a href="{{ route('dashboard.portofolio.category.index') }}" class="text-[#ff6b35] hover:underline">Manage categories</a>
                    </p>
                @else
                    <p class="text-sm text-zinc-500 px-1">
                        <a href="{{ route('dashboard.portofolio.category.index') }}" class="text-[#ff6b35] hover:underline">Create categories</a> before assigning a project category.
                    </p>
                @endif
            </div>
                <x-ui.input name="location" label="Location" :value="$portfolio?->location" placeholder="Jakarta, ID" />
            </div>

            <x-ui.textarea name="quote" label="Conceptual Quote" :value="$portfolio?->quote" rows="3" placeholder="In the darkness, the truth of the soul reveals itself..." />

            <div class="space-y-2">
                <label for="status" class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Status</label>
                <select name="status" id="status" class="input-field appearance-none cursor-pointer">
                    @foreach (['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $portfolio?->status ?? 'draft') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" class="sr-only peer" @checked(old('is_published', $portfolio?->is_published ?? false))>
                <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-[#f5f2ed] after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500/20 relative"></div>
                <span class="ml-3 text-xs font-medium opacity-60">Publish to public gallery</span>
            </label>
        </div>

        <div class="space-y-6">
            <h3 class="text-lg font-display font-black flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:image" class="text-[#ff6b35]"></iconify-icon>
                Hero & Gallery
            </h3>

            <x-ui.upload
                name="hero_image"
                id="hero_image"
                label="Hero Image"
                :preview="$portfolio?->heroImageUrl()"
                hint="Main case study banner · 21:9 recommended"
            />
            <x-ui.input name="hero_caption" label="Hero Caption" :value="$portfolio?->hero_caption" placeholder="Shot 01: The Gaze · f/2.0 · ISO 200" />

            <x-ui.upload
                name="gallery_images[]"
                id="gallery_images"
                label="Gallery Images"
                :multiple="true"
                hint="Add images one by one · upload button stays available"
            />

            @if ($portfolio)
                <input type="hidden" name="existing_gallery" id="existing_gallery" value='@json($portfolio->gallery_images ?? [])'>
            @endif

            @if ($portfolio && count($portfolio->galleryImageUrls()))
                <div class="space-y-2">
                    <p class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Saved Gallery</p>
                    <div class="grid grid-cols-3 gap-2" id="gallery-preview">
                        @foreach ($portfolio->galleryImageUrls() as $index => $image)
                            <div class="relative aspect-square rounded-xl overflow-hidden border border-white/10 group" data-gallery-index="{{ $index }}">
                                <img src="{{ $image['url'] }}" alt="{{ $image['alt'] }}" class="w-full h-full object-cover">
                                <button type="button" class="absolute top-1 right-1 w-6 h-6 bg-black/60 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity gallery-remove" data-index="{{ $index }}">
                                    <iconify-icon icon="lucide:x" class="text-xs"></iconify-icon>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-display font-black flex items-center gap-2">
                <iconify-icon icon="lucide:book-open" class="text-[#ff6b35]"></iconify-icon>
                Conceptual Framework
            </h3>
            <button
                type="button"
                id="add-content-section"
                class="px-4 py-2 rounded-xl border border-white/5 text-xs font-black hover:bg-white/5 transition-all flex items-center gap-2"
            >
                <iconify-icon icon="lucide:plus"></iconify-icon>
                Add Section
            </button>
        </div>

        <div id="content-sections-list" class="space-y-4">
            @foreach ($contentSections as $index => $section)
                <div class="content-section-item card-photography rounded-2xl p-6 space-y-4" data-section-item>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 section-label">Section {{ $index + 1 }}</span>
                        <button
                            type="button"
                            data-remove-section
                            @class([
                                'text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors',
                                'hidden' => count($contentSections) === 1,
                            ])
                        >
                            Remove
                        </button>
                    </div>
                    <x-ui.input
                        name="content_sections[{{ $index }}][title]"
                        label="Title"
                        :value="$section['title']"
                        placeholder="Concept Overview"
                    />
                    <x-ui.textarea
                        name="content_sections[{{ $index }}][description]"
                        label="Description"
                        :value="$section['description']"
                        rows="4"
                        placeholder="Describe this section..."
                    />
                </div>
            @endforeach
        </div>

        <template id="content-section-template">
            <div class="content-section-item card-photography rounded-2xl p-6 space-y-4" data-section-item>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 section-label">Section</span>
                    <button type="button" data-remove-section class="text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors">
                        Remove
                    </button>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Title</label>
                    <input type="text" data-field="title" class="input-field" placeholder="Concept Overview">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Description</label>
                    <textarea data-field="description" rows="4" class="input-field resize-none" placeholder="Describe this section..."></textarea>
                </div>
            </div>
        </template>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <h3 class="text-lg font-display font-black flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:bar-chart-3" class="text-[#ff6b35]"></iconify-icon>
            Project Metrics
        </h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-ui.input name="metrics_shots_taken" label="Shots Taken" :value="$metrics['shots_taken'] ?? null" placeholder="1.2k+" />
            <x-ui.input name="metrics_final_selects" label="Final Selects" :value="$metrics['final_selects'] ?? null" placeholder="18" />
            <x-ui.input name="metrics_total_hours" label="Total Hours" :value="$metrics['total_hours'] ?? null" placeholder="72h" />
            <x-ui.input name="metrics_team_members" label="Team Members" :value="$metrics['team_members'] ?? null" placeholder="6" />
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <h3 class="text-lg font-display font-black flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:camera" class="text-[#ff6b35]"></iconify-icon>
            Technical Specifications
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-ui.input name="camera_setup" label="Camera Setup" :value="$specs['camera_setup'] ?? null" placeholder="Leica M11 / Summilux 50mm f/1.4" />
            <x-ui.input name="camera_settings" label="Camera Settings" :value="$specs['camera_settings'] ?? null" placeholder="ISO 100-400 · 1/125s - 1/250s" />
            <x-ui.input name="lighting_array" label="Lighting Array" :value="$specs['lighting_array'] ?? null" placeholder="Profoto B10X + 3' Deep Octa" />
            <x-ui.textarea name="lighting_notes" label="Lighting Notes" :value="$specs['lighting_notes'] ?? null" rows="3" />
            <x-ui.textarea name="retouching_notes" label="Retouching Notes" :value="$specs['retouching_notes'] ?? null" rows="3" />
        </div>

        <div class="mt-8 pt-8 border-t border-white/5">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-display font-black flex items-center gap-2">
                    <iconify-icon icon="lucide:layers" class="text-[#ff6b35]"></iconify-icon>
                    Post-Processing Workflow
                </h4>
                <button
                    type="button"
                    id="add-post-processing-step"
                    class="px-4 py-2 rounded-xl border border-white/5 text-xs font-black hover:bg-white/5 transition-all flex items-center gap-2"
                >
                    <iconify-icon icon="lucide:plus"></iconify-icon>
                    Add Step
                </button>
            </div>

            <div id="post-processing-list" class="space-y-4">
                @foreach ($postProcessingSteps as $index => $step)
                    <div class="post-processing-item card-photography rounded-2xl p-6 space-y-4" data-post-processing-item>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 post-processing-label">Step {{ $index + 1 }}</span>
                            <button
                                type="button"
                                data-remove-post-processing
                                @class([
                                    'text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors',
                                    'hidden' => count($postProcessingSteps) === 1,
                                ])
                            >
                                Remove
                            </button>
                        </div>
                        <x-ui.input
                            name="post_processing[{{ $index }}][title]"
                            label="Title"
                            :value="$step['title']"
                            placeholder="Color Grading"
                        />
                        <x-ui.textarea
                            name="post_processing[{{ $index }}][text]"
                            label="Text"
                            :value="$step['text']"
                            rows="3"
                            placeholder="Custom LUTs, curve adjustments, and tonal balance..."
                        />
                    </div>
                @endforeach
            </div>

            <template id="post-processing-template">
                <div class="post-processing-item card-photography rounded-2xl p-6 space-y-4" data-post-processing-item>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 post-processing-label">Step</span>
                        <button type="button" data-remove-post-processing class="text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors">
                            Remove
                        </button>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Title</label>
                        <input type="text" data-field="title" class="input-field" placeholder="Color Grading">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Text</label>
                        <textarea data-field="text" rows="3" class="input-field resize-none" placeholder="Custom LUTs, curve adjustments, and tonal balance..."></textarea>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <h3 class="text-lg font-display font-black flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:git-branch" class="text-[#ff6b35]"></iconify-icon>
            Timeline & Contributors
        </h3>

        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-display font-black flex items-center gap-2">
                    <iconify-icon icon="lucide:calendar-range" class="text-[#ff6b35]"></iconify-icon>
                    Production Timeline
                </h4>
                <button
                    type="button"
                    id="add-timeline-item"
                    class="px-4 py-2 rounded-xl border border-white/5 text-xs font-black hover:bg-white/5 transition-all flex items-center gap-2"
                >
                    <iconify-icon icon="lucide:plus"></iconify-icon>
                    Add Phase
                </button>
            </div>

            <div id="timeline-list" class="space-y-4">
                @foreach ($timelineItems as $index => $item)
                    <div class="timeline-item card-photography rounded-2xl p-6 space-y-4" data-timeline-item>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 timeline-label">Phase {{ $index + 1 }}</span>
                            <button
                                type="button"
                                data-remove-timeline
                                @class([
                                    'text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors',
                                    'hidden' => count($timelineItems) === 1,
                                ])
                            >
                                Remove
                            </button>
                        </div>
                        <x-ui.input
                            name="timeline[{{ $index }}][title]"
                            label="Title"
                            :value="$item['title']"
                            placeholder="Week 01: Ideation"
                        />
                        <x-ui.textarea
                            name="timeline[{{ $index }}][text]"
                            label="Text"
                            :value="$item['text']"
                            rows="3"
                            placeholder="Moodboarding and location scouting..."
                        />
                    </div>
                @endforeach
            </div>

            <template id="timeline-template">
                <div class="timeline-item card-photography rounded-2xl p-6 space-y-4" data-timeline-item>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 timeline-label">Phase</span>
                        <button type="button" data-remove-timeline class="text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors">
                            Remove
                        </button>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Title</label>
                        <input type="text" data-field="title" class="input-field" placeholder="Week 01: Ideation">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Text</label>
                        <textarea data-field="text" rows="3" class="input-field resize-none" placeholder="Moodboarding and location scouting..."></textarea>
                    </div>
                </div>
            </template>
        </div>

        <div>
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-sm font-display font-black flex items-center gap-2">
                    <iconify-icon icon="lucide:users" class="text-[#ff6b35]"></iconify-icon>
                    Contributors
                </h4>
                <button
                    type="button"
                    id="add-team-member"
                    class="px-4 py-2 rounded-xl border border-white/5 text-xs font-black hover:bg-white/5 transition-all flex items-center gap-2"
                    @disabled($teamOptions->isEmpty())
                >
                    <iconify-icon icon="lucide:plus"></iconify-icon>
                    Add Team Member
                </button>
            </div>

            @if ($teamOptions->isEmpty())
                <div class="card-photography rounded-2xl p-6 text-sm text-zinc-500">
                    No studio team members yet.
                    <a href="{{ route('dashboard.teams.create') }}" class="text-[#ff6b35] hover:underline font-bold">Create a team profile</a> before assigning contributors to this project.
                </div>
            @else
                <div id="team-members-list" class="space-y-4">
                    @foreach ($teamMembers as $index => $member)
                        @php
                            $selectedTeam = $teamOptions->firstWhere('id', (int) ($member['team_id'] ?? 0));
                        @endphp
                        <div class="team-member-item card-photography rounded-2xl p-6 space-y-4" data-team-member-item>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 team-member-label">Contributor {{ $index + 1 }}</span>
                                <button
                                    type="button"
                                    data-remove-team-member
                                    @class([
                                        'text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors',
                                        'hidden' => count($teamMembers) === 1,
                                    ])
                                >
                                    Remove
                                </button>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                @if ($selectedTeam?->pictureUrl())
                                    <div class="aspect-square rounded-xl overflow-hidden border border-white/10">
                                        <img src="{{ $selectedTeam->pictureUrl() }}" alt="{{ $selectedTeam->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="aspect-square rounded-xl border border-white/10 bg-zinc-900 flex items-center justify-center">
                                        <iconify-icon icon="lucide:user-round" class="text-3xl text-zinc-700"></iconify-icon>
                                    </div>
                                @endif

                                <div class="lg:col-span-2 space-y-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Team Member</label>
                                        <select name="team_members[{{ $index }}][team_id]" data-field="team_id" class="input-field appearance-none cursor-pointer">
                                            <option value="">Select team member</option>
                                            @foreach ($teamOptions as $teamOption)
                                                <option value="{{ $teamOption->id }}" @selected((string) ($member['team_id'] ?? '') === (string) $teamOption->id)>
                                                    {{ $teamOption->name }} — {{ $teamOption->job }} ({{ $teamOption->number }} projects)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-ui.textarea
                                        name="team_members[{{ $index }}][description]"
                                        label="Project Notes"
                                        :value="$member['description']"
                                        rows="3"
                                        placeholder="Brief contribution notes for this project..."
                                        data-field="description"
                                    />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <template id="team-member-template">
                    <div class="team-member-item card-photography rounded-2xl p-6 space-y-4" data-team-member-item>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase tracking-widest font-bold opacity-40 team-member-label">Contributor</span>
                            <button type="button" data-remove-team-member class="text-[10px] uppercase tracking-widest font-bold opacity-40 hover:opacity-100 hover:text-red-400 transition-colors">
                                Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="aspect-square rounded-xl border border-white/10 bg-zinc-900 flex items-center justify-center">
                                <iconify-icon icon="lucide:user-round" class="text-3xl text-zinc-700"></iconify-icon>
                            </div>

                            <div class="lg:col-span-2 space-y-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Team Member</label>
                                    <select data-field="team_id" class="input-field appearance-none cursor-pointer">
                                        <option value="">Select team member</option>
                                        @foreach ($teamOptions as $teamOption)
                                            <option value="{{ $teamOption->id }}">{{ $teamOption->name }} — {{ $teamOption->job }} ({{ $teamOption->number }} projects)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Project Notes</label>
                                    <textarea data-field="description" rows="3" class="input-field resize-none" placeholder="Brief contribution notes for this project..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            @endif
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <h3 class="text-lg font-display font-black flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:message-circle" class="text-[#ff6b35]"></iconify-icon>
            Client Testimonial
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <x-ui.textarea name="testimonial_quote" label="Quote" :value="$testimonial['quote'] ?? null" rows="4" />
            </div>
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Author</label>
                <div class="input-field opacity-60 cursor-not-allowed flex items-center gap-2">
                    <iconify-icon icon="lucide:user" class="opacity-40"></iconify-icon>
                    {{ auth()->user()->name }}
                </div>
                <p class="text-[10px] text-[#f5f2ed]/30 px-1">Auto-filled from your account</p>
            </div>
        </div>
    </div>
</div>
