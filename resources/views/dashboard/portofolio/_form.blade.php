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
@endphp

<div class="glass rounded-[3rem] p-6 lg:p-10 relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/[0.02] rounded-full blur-[80px]"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
        <div class="space-y-6">
            <h3 class="text-lg font-bold flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:file-text" class="text-[#f5f2ed]/40"></iconify-icon>
                Basic Information
            </h3>

            <x-input name="title" id="title" label="Project Title" :value="$portfolio?->title" placeholder="Midnight Soul" required />
            <div class="space-y-2">
                <x-input name="slug" id="slug" label="Slug" :value="$portfolio?->slug" placeholder="midnight-soul" />
                <p class="text-[10px] text-[#f5f2ed]/30 px-1">Auto-generated from title. Edit manually if needed.</p>
            </div>
            <x-input name="subtitle" label="Subtitle (Italic)" :value="$portfolio?->subtitle" placeholder="soul" />
            <x-input name="client" label="Client" :value="$portfolio?->client" placeholder="Personal Editorial" />
            <x-input name="year" label="Year" type="number" :value="$portfolio?->year ?? date('Y')" required />

            <div class="grid grid-cols-2 gap-4">
                <x-input name="category" label="Category" :value="$portfolio?->category" placeholder="Fine Art Portrait" />
                <x-input name="location" label="Location" :value="$portfolio?->location" placeholder="Jakarta, ID" />
            </div>

            <x-textarea name="quote" label="Conceptual Quote" :value="$portfolio?->quote" rows="3" placeholder="In the darkness, the truth of the soul reveals itself..." />

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
            <h3 class="text-lg font-bold flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:image" class="text-[#f5f2ed]/40"></iconify-icon>
                Hero & Gallery
            </h3>

            <x-upload
                name="hero_image"
                id="hero_image"
                label="Hero Image"
                :preview="$portfolio?->heroImageUrl()"
                hint="Main case study banner · 21:9 recommended"
            />
            <x-input name="hero_caption" label="Hero Caption" :value="$portfolio?->hero_caption" placeholder="Shot 01: The Gaze · f/2.0 · ISO 200" />

            <x-upload
                name="gallery_images[]"
                id="gallery_images"
                label="Gallery Images"
                :multiple="true"
                hint="Add images one by one · upload button stays available"
            />

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
                    <input type="hidden" name="existing_gallery" id="existing_gallery" value="{{ json_encode($portfolio->gallery_images ?? []) }}">
                </div>
            @endif
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold flex items-center gap-2">
                <iconify-icon icon="lucide:book-open" class="text-[#f5f2ed]/40"></iconify-icon>
                Conceptual Framework
            </h3>
            <button
                type="button"
                id="add-content-section"
                class="px-4 py-2 glass rounded-xl text-xs font-bold glass-hover flex items-center gap-2"
            >
                <iconify-icon icon="lucide:plus"></iconify-icon>
                Add Section
            </button>
        </div>

        <div id="content-sections-list" class="space-y-4">
            @foreach ($contentSections as $index => $section)
                <div class="content-section-item glass rounded-2xl p-6 space-y-4" data-section-item>
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
                    <x-input
                        name="content_sections[{{ $index }}][title]"
                        label="Title"
                        :value="$section['title']"
                        placeholder="Concept Overview"
                    />
                    <x-textarea
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
            <div class="content-section-item glass rounded-2xl p-6 space-y-4" data-section-item>
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
        <h3 class="text-lg font-bold flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:bar-chart-3" class="text-[#f5f2ed]/40"></iconify-icon>
            Project Metrics
        </h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <x-input name="metrics_shots_taken" label="Shots Taken" :value="$metrics['shots_taken'] ?? null" placeholder="1.2k+" />
            <x-input name="metrics_final_selects" label="Final Selects" :value="$metrics['final_selects'] ?? null" placeholder="18" />
            <x-input name="metrics_total_hours" label="Total Hours" :value="$metrics['total_hours'] ?? null" placeholder="72h" />
            <x-input name="metrics_team_members" label="Team Members" :value="$metrics['team_members'] ?? null" placeholder="6" />
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <h3 class="text-lg font-bold flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:camera" class="text-[#f5f2ed]/40"></iconify-icon>
            Technical Specifications
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-input name="camera_setup" label="Camera Setup" :value="$specs['camera_setup'] ?? null" placeholder="Leica M11 / Summilux 50mm f/1.4" />
            <x-input name="camera_settings" label="Camera Settings" :value="$specs['camera_settings'] ?? null" placeholder="ISO 100-400 · 1/125s - 1/250s" />
            <x-input name="lighting_array" label="Lighting Array" :value="$specs['lighting_array'] ?? null" placeholder="Profoto B10X + 3' Deep Octa" />
            <x-textarea name="lighting_notes" label="Lighting Notes" :value="$specs['lighting_notes'] ?? null" rows="3" />
            <x-textarea name="post_processing" label="Post-Processing Workflow" :value="$specs['post_processing'] ?? null" rows="3" placeholder="Curation & RAW · Color Grading · Retouching" />
            <x-textarea name="retouching_notes" label="Retouching Notes" :value="$specs['retouching_notes'] ?? null" rows="3" />
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <h3 class="text-lg font-bold flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:git-branch" class="text-[#f5f2ed]/40"></iconify-icon>
            Timeline & Contributors (JSON)
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-textarea
                name="timeline_json"
                label="Production Timeline"
                rows="8"
                :value="old('timeline_json', $portfolio ? json_encode($portfolio->timeline ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '')"
                hint='[{"title":"Week 01: Ideation","description":"...","active":true}]'
            />
            <x-textarea
                name="contributors_json"
                label="Contributors"
                rows="8"
                :value="old('contributors_json', $portfolio ? json_encode($portfolio->contributors ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '')"
                hint='[{"name":"Evan W.","role":"Lead Photographer","bio":"...","image":"https://..."}]'
            />
        </div>
    </div>

    <div class="mt-12 pt-8 border-t border-white/5">
        <h3 class="text-lg font-bold flex items-center gap-2 mb-6">
            <iconify-icon icon="lucide:message-circle" class="text-[#f5f2ed]/40"></iconify-icon>
            Client Testimonial
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <x-textarea name="testimonial_quote" label="Quote" :value="$testimonial['quote'] ?? null" rows="4" />
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

@if ($portfolio)
<script>
    document.querySelectorAll('.gallery-remove').forEach((button) => {
        button.addEventListener('click', () => {
            const index = parseInt(button.dataset.index, 10);
            const input = document.getElementById('existing_gallery');
            const gallery = JSON.parse(input.value || '[]');
            gallery.splice(index, 1);
            input.value = JSON.stringify(gallery);
            button.closest('[data-gallery-index]').remove();
        });
    });
</script>
@endif

<script>
    (function () {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        if (!titleInput || !slugInput) {
            return;
        }

        let slugTouched = Boolean(slugInput.value);

        slugInput.addEventListener('input', () => {
            slugTouched = true;
        });

        titleInput.addEventListener('input', () => {
            if (!slugTouched) {
                slugInput.value = slugify(titleInput.value);
            }
        });

        function slugify(text) {
            return text
                .toLowerCase()
                .trim()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/[\s_]+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    })();

    (function () {
        const list = document.getElementById('content-sections-list');
        const template = document.getElementById('content-section-template');
        const addButton = document.getElementById('add-content-section');

        if (!list || !template || !addButton) {
            return;
        }

        const reindexSections = () => {
            const items = list.querySelectorAll('[data-section-item]');

            items.forEach((item, index) => {
                const label = item.querySelector('.section-label');
                if (label) {
                    label.textContent = `Section ${index + 1}`;
                }

                const titleInput = item.querySelector('[data-field="title"]') || item.querySelector('input[name*="[title]"]');
                const descriptionInput = item.querySelector('[data-field="description"]') || item.querySelector('textarea[name*="[description]"]');

                if (titleInput) {
                    titleInput.name = `content_sections[${index}][title]`;
                }

                if (descriptionInput) {
                    descriptionInput.name = `content_sections[${index}][description]`;
                }

                const removeBtn = item.querySelector('[data-remove-section]');
                if (removeBtn) {
                    removeBtn.classList.toggle('hidden', items.length === 1);
                }
            });
        };

        addButton.addEventListener('click', () => {
            const clone = template.content.cloneNode(true);
            list.appendChild(clone);
            reindexSections();
        });

        list.addEventListener('click', (event) => {
            const removeBtn = event.target.closest('[data-remove-section]');

            if (!removeBtn) {
                return;
            }

            const items = list.querySelectorAll('[data-section-item]');

            if (items.length <= 1) {
                return;
            }

            removeBtn.closest('[data-section-item]')?.remove();
            reindexSections();
        });
    })();
</script>
