@php
    $jurnal = $jurnal ?? null;
@endphp

<div class="glass rounded-[3rem] p-6 lg:p-10 relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/[0.02] rounded-full blur-[80px]"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
        <div class="space-y-6">
            <h3 class="text-lg font-bold flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:file-text" class="text-[#f5f2ed]/40"></iconify-icon>
                Article Details
            </h3>

            <x-input name="title" id="title" label="Title" :value="$jurnal?->title" placeholder="The Alchemy of Chiaroscuro" required />
            <div class="space-y-2">
                <x-input name="slug" id="slug" label="Slug" :value="$jurnal?->slug" placeholder="the-alchemy-of-chiaroscuro" />
                <p class="text-[10px] text-[#f5f2ed]/30 px-1">Auto-generated from title. Edit manually if needed.</p>
            </div>

            <div class="space-y-2">
                <x-input
                    name="category"
                    id="category"
                    label="Category"
                    :value="$jurnal?->category"
                    placeholder="Craft & Technique"
                />
                <p class="text-[10px] text-[#f5f2ed]/30 px-1">e.g. Craft & Technique, Hardware / Gear, Lifestyle / Travel</p>
            </div>

            <x-textarea
                name="description"
                id="description"
                label="Description"
                :value="$jurnal?->description"
                rows="3"
                placeholder="A short excerpt shown on journal cards and article previews..."
                hint="Brief summary · max 500 characters"
            />

            <div class="space-y-2">
                <label for="status" class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Status</label>
                <select name="status" id="status" class="input-field appearance-none cursor-pointer">
                    @foreach (['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $jurnal?->status ?? 'draft') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-lg font-bold flex items-center gap-2 mb-4">
                <iconify-icon icon="lucide:image" class="text-[#f5f2ed]/40"></iconify-icon>
                Hero Thumbnail
            </h3>

            <x-upload
                name="thumbnail"
                id="thumbnail"
                label="Thumbnail"
                :preview="$jurnal?->thumbnailUrl()"
                hint="Article hero banner · 16:9 recommended · grayscale on public page"
            />

            <div class="glass rounded-2xl p-6 border border-white/5 space-y-3">
                <p class="text-[10px] uppercase tracking-widest font-bold opacity-40">Preview Reference</p>
                <p class="text-xs text-[#f5f2ed]/50 leading-relaxed">
                    This image appears as the full-width hero on the article detail page — behind the title, category badge, and metadata, with a gradient overlay from the bottom.
                </p>
            </div>
        </div>
    </div>

    <div class="mt-10 pt-10 border-t border-white/5 space-y-6">
        <h3 class="text-lg font-bold flex items-center gap-2">
            <iconify-icon icon="lucide:align-left" class="text-[#f5f2ed]/40"></iconify-icon>
            Article Content
        </h3>

        <div class="space-y-2">
            <label for="content" class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">Full Content</label>
            <x-quileditor
                name="content"
                id="content"
                :value="old('content', $jurnal?->content)"
                placeholder="Write your article body here. Sections, paragraphs, blockquotes — the full editorial narrative that appears below the hero on the public Journal detail page."
            />
            <p class="text-[10px] text-[#f5f2ed]/30 px-1">Rich text editor · supports headings, lists, blockquotes, images, and video embeds</p>
            @error('content')
                <p class="text-xs text-red-400 px-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
