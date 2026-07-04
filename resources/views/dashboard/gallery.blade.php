<x-layout.dashboard title="Gallery" active="gallery">
    <x-slot:header>
        <header class="sticky top-0 z-40 bg-[#0d0d0d]/90 backdrop-blur-xl px-6 lg:px-10 h-24 flex items-center justify-between border-b border-white/5">
            <div class="flex flex-col min-w-0">
                <h1 class="text-2xl font-display font-black tracking-tight leading-none uppercase">Cloud Assets</h1>
                <p class="text-xs text-zinc-500 font-bold tracking-[0.2em] mt-1 uppercase">Gallery & Visual Archive</p>
            </div>
            <x-layout.dashboard-header-actions>
                <button
                    type="button"
                    data-gallery-open="gallery-dialog"
                    data-gallery-mode="create"
                    class="px-6 py-3 bg-[#ff6b35] text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-orange-500/20 hover:scale-105 transition-all"
                >
                    Add Gallery Item
                </button>
            </x-layout.dashboard-header-actions>
        </header>
    </x-slot:header>

    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
    </style>

    <div class="space-y-16">
        @if ($errors->any())
            <div class="px-6 py-4 rounded-2xl border border-red-500/20 bg-red-500/10 text-red-300 text-sm space-y-2">
                <p>There was a problem saving the gallery item:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="card-photography p-8 rounded-[2.5rem] bg-linear-to-br from-rose-500/10 to-transparent border-rose-500/20 text-center">
                <h3 class="text-zinc-500 text-[10px] font-black tracking-widest uppercase mb-3">Total Assets</h3>
                <iconify-icon icon="lucide:images" class="text-4xl text-rose-400 mb-3"></iconify-icon>
                <p class="text-5xl font-display font-black">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-zinc-500 font-bold mt-2">Images stored in your cloud gallery</p>
            </div>

            <div class="card-photography p-8 rounded-[2.5rem] text-center flex flex-col justify-center items-center">
                <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-4">
                    <iconify-icon icon="lucide:cloud-upload" class="text-2xl text-[#ff6b35]"></iconify-icon>
                </div>
                <p class="text-xs font-black uppercase tracking-widest">Latest Update</p>
                <p class="text-sm text-zinc-400 font-medium mt-2">
                    {{ $stats['latest']?->diffForHumans() ?? 'No gallery item yet' }}
                </p>
                <button
                    type="button"
                    data-gallery-open="gallery-dialog"
                    data-gallery-mode="create"
                    class="text-[10px] font-bold text-[#ff6b35] hover:underline mt-3 tracking-widest uppercase"
                >
                    Upload New Image
                </button>
            </div>
        </div>

        <section class="space-y-8">
            <div class="flex justify-between items-end gap-4">
                <div>
                    <h2 class="text-4xl font-display font-black tracking-tighter">Visual Archive</h2>
                    <p class="text-zinc-500 font-medium mt-2">Manage gallery images with title and account-scoped storage.</p>
                </div>
            </div>

            @if ($galleries->isEmpty())
                <div class="card-photography rounded-[3rem] p-16 text-center">
                    <iconify-icon icon="lucide:image-plus" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                    <h3 class="text-2xl font-display font-black mb-2">No gallery items yet</h3>
                    <p class="text-sm text-zinc-500 mb-8 max-w-xl mx-auto">Start building your visual archive by uploading an image and giving it a title.</p>
                    <button
                        type="button"
                        data-gallery-open="gallery-dialog"
                        data-gallery-mode="create"
                        class="inline-flex px-8 py-4 bg-[#ff6b35] text-white rounded-2xl text-sm font-black hover:scale-[1.02] transition-all"
                    >
                        Create Gallery Item
                    </button>
                </div>
            @else
                <div class="gallery-grid">
                    @foreach ($galleries as $gallery)
                        <article class="card-photography rounded-4xl overflow-hidden group">
                            <div class="relative overflow-hidden">
                                <img
                                    src="{{ $gallery->imageUrl() }}"
                                    alt="{{ $gallery->title }}"
                                    class="w-full aspect-4/5 object-cover transition-transform duration-500 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                            </div>

                            <div class="p-6 space-y-4">
                                <div class="min-w-0">
                                    <p class="font-black text-sm uppercase truncate">{{ $gallery->title }}</p>
                                    <p class="text-[10px] text-zinc-600 uppercase tracking-[0.2em] mt-2">
                                        Updated {{ $gallery->updated_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        data-gallery-open="gallery-dialog"
                                        data-gallery-mode="edit"
                                        data-gallery-title="{{ $gallery->title }}"
                                        data-gallery-image-url="{{ $gallery->imageUrl() }}"
                                        data-gallery-update-url="{{ route('dashboard.gallery.update', $gallery) }}"
                                        class="flex-1 h-11 rounded-xl bg-white/5 hover:bg-[#ff6b35] transition-all flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest"
                                        title="Edit gallery item"
                                    >
                                        <iconify-icon icon="lucide:pencil" class="text-lg"></iconify-icon>
                                        Edit
                                    </button>

                                    <form id="delete-gallery-{{ $gallery->id }}" method="POST" action="{{ route('dashboard.gallery.destroy', $gallery) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button
                                        type="button"
                                        data-alert-open="gallery-delete-dialog"
                                        data-alert-title="Delete {{ $gallery->title }}?"
                                        data-alert-description="This gallery item will be permanently removed from your archive."
                                        data-alert-confirm="Delete Gallery Item"
                                        data-alert-form="delete-gallery-{{ $gallery->id }}"
                                        class="w-11 h-11 rounded-xl bg-white/5 hover:bg-red-500/20 text-red-400 transition-all flex items-center justify-center shrink-0"
                                        title="Delete gallery item"
                                    >
                                        <iconify-icon icon="lucide:trash-2" class="text-lg"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    @push('modals')
        <x-ui.dialog.gallery
            id="gallery-dialog"
            :store-route="route('dashboard.gallery.store')"
            :upload-max-label="$uploadMaxLabel"
        />

        <x-ui.alert-dialog
            id="gallery-delete-dialog"
            title="Delete this gallery item?"
            description="This image will be permanently removed from your archive. This action cannot be undone."
            confirm-label="Delete Gallery Item"
        />
    @endpush
</x-layout.dashboard>
