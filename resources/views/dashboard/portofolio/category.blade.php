<x-layout.dashboard title="Portfolio Categories" active="portfolio-categories">
    <x-slot:header>
        <x-layout.page-header title="Portfolio Categories" :back="route('dashboard.portofolio.index')">
            <x-slot:subtitle>Organize project categories for your portfolio</x-slot:subtitle>
            <x-slot:actions>
                <button
                    type="button"
                    data-category-open="portfolio-category-dialog"
                    data-category-mode="create"
                    class="px-6 lg:px-8 py-3 bg-[#ff6b35] text-white rounded-xl text-sm font-black shadow-lg shadow-orange-500/20 hover:scale-[1.02] transition-all"
                >
                    New Category
                </button>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    @if ($errors->has('category'))
        <div class="mb-6 px-6 py-4 rounded-2xl border border-red-500/20 bg-red-500/10 text-red-300 text-sm">
            {{ $errors->first('category') }}
        </div>
    @endif

    <div class="space-y-8">
        @if ($categories->isEmpty())
            <div class="card-photography rounded-[2.5rem] p-16 text-center">
                <iconify-icon icon="lucide:tags" class="text-5xl text-zinc-600 mb-6"></iconify-icon>
                <h3 class="text-xl font-display font-black mb-2">No categories yet</h3>
                <p class="text-sm text-zinc-500 mb-8">Create categories to organize and filter your projects.</p>
                <button
                    type="button"
                    data-category-open="portfolio-category-dialog"
                    data-category-mode="create"
                    class="inline-flex px-8 py-4 bg-[#ff6b35] text-white rounded-2xl text-sm font-black hover:scale-[1.02] transition-all"
                >
                    Create Category
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <article class="card-photography rounded-[2rem] p-6 flex flex-col gap-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#ff6b35] mb-2 block">Category</span>
                                <h3 class="text-lg font-display font-black truncate">{{ $category->title }}</h3>
                                <p class="text-xs text-zinc-500 font-mono mt-1 truncate">{{ $category->category_id }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0">
                                <iconify-icon icon="lucide:tag" class="text-[#ff6b35]"></iconify-icon>
                            </div>
                        </div>

                        <p class="text-[10px] text-zinc-600 uppercase tracking-widest">
                            Updated {{ $category->updated_at->diffForHumans() }}
                        </p>

                        <div class="flex items-center gap-2 pt-2">
                            <button
                                type="button"
                                data-category-open="portfolio-category-dialog"
                                data-category-mode="edit"
                                data-category-title="{{ $category->title }}"
                                data-category-slug="{{ $category->category_id }}"
                                data-category-update-url="{{ route('dashboard.portofolio.category.update', $category) }}"
                                class="flex-1 text-center py-3 bg-white/5 rounded-xl text-xs font-black hover:bg-[#ff6b35] hover:text-white transition-all"
                            >
                                Edit
                            </button>
                            <form id="delete-portfolio-category-{{ $category->id }}" method="POST" action="{{ route('dashboard.portofolio.category.destroy', $category) }}" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button
                                type="button"
                                data-alert-open="portfolio-category-delete-dialog"
                                data-alert-title="Delete {{ $category->title }}?"
                                data-alert-description="This category will be permanently removed. Projects using it must be reassigned first."
                                data-alert-confirm="Delete Category"
                                data-alert-form="delete-portfolio-category-{{ $category->id }}"
                                class="w-11 h-11 flex items-center justify-center bg-white/5 rounded-xl hover:bg-red-500/20 text-red-400 transition-all"
                                title="Delete category"
                            >
                                <iconify-icon icon="lucide:trash-2"></iconify-icon>
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    <x-ui.dialog.category
        id="portfolio-category-dialog"
        :store-route="route('dashboard.portofolio.category.store')"
        :update-route="route('dashboard.portofolio.category.update', ['portfolioCategory' => '__ID__'])"
    />

    <x-ui.alert-dialog
        id="portfolio-category-delete-dialog"
        title="Delete this category?"
        description="This category will be permanently removed. This action cannot be undone."
        confirm-label="Delete Category"
    />
</x-layout.dashboard>
