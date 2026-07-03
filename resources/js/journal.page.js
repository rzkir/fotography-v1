import { createPagination } from './hooks/pagination';

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text ?? '';

    return div.innerHTML;
}

function renderFeatured(featuredSlot, article) {
    if (!featuredSlot) {
        return;
    }

    if (!article) {
        featuredSlot.classList.add('hidden');
        featuredSlot.innerHTML = '';

        return;
    }

    featuredSlot.classList.remove('hidden');
    featuredSlot.innerHTML = `
        <a href="${article.url}" class="group block article-card">
            <div class="aspect-[16/9] overflow-hidden bg-zinc-900 mb-8 rounded-sm">
                ${article.thumbnail ? `<img src="${article.thumbnail}" alt="${escapeHtml(article.title)}" class="article-image w-full h-full object-cover">` : ''}
            </div>
            <div class="flex justify-between items-start mb-6 gap-4">
                <div class="flex flex-wrap gap-x-6 gap-y-2 text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                    <span>${escapeHtml(article.date)}</span>
                    <span>${article.readTime} Min Read</span>
                    ${article.category ? `<span class="text-zinc-300">${escapeHtml(article.category)}</span>` : ''}
                </div>
                <div class="w-12 h-12 rounded-full border border-zinc-800 flex items-center justify-center shrink-0 group-hover:bg-white group-hover:border-white transition-all duration-500">
                    <iconify-icon icon="lucide:arrow-up-right" class="text-xl group-hover:text-black"></iconify-icon>
                </div>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-7xl font-display font-black uppercase tracking-tighter leading-none mb-6 group-hover:text-zinc-300 transition-colors">
                ${escapeHtml(article.title)}
            </h2>
            ${article.description ? `<p class="text-zinc-500 text-lg font-light leading-relaxed max-w-3xl mb-8">${escapeHtml(article.description)}</p>` : ''}
            ${article.author ? `
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center">
                        <iconify-icon icon="lucide:user" class="text-zinc-600"></iconify-icon>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest">By ${escapeHtml(article.author)}</span>
                </div>
            ` : ''}
        </a>
    `;
}

function renderPinned(pinnedColumn, pinnedItems, pinnedArticles) {
    if (!pinnedColumn || !pinnedItems) {
        return;
    }

    if (pinnedArticles.length === 0) {
        pinnedColumn.classList.add('hidden');
        pinnedItems.innerHTML = '';

        return;
    }

    pinnedColumn.classList.remove('hidden');
    pinnedItems.innerHTML = pinnedArticles.map((article) => `
        <div class="article-pinned">
            <a href="${article.url}" class="group block article-card">
                <div class="aspect-square overflow-hidden bg-zinc-900 mb-6 rounded-sm">
                    ${article.thumbnail ? `<img src="${article.thumbnail}" alt="${escapeHtml(article.title)}" class="article-image w-full h-full object-cover">` : ''}
                </div>
                ${article.category ? `<span class="text-[10px] font-bold uppercase tracking-widest text-zinc-300 block mb-3">${escapeHtml(article.category)}</span>` : ''}
                <h4 class="text-2xl font-display font-black uppercase tracking-tight mb-4 group-hover:text-zinc-400 transition-colors">${escapeHtml(article.title)}</h4>
                ${article.description ? `<p class="text-xs text-zinc-500 font-light leading-relaxed line-clamp-2">${escapeHtml(article.description)}</p>` : ''}
            </a>
        </div>
    `).join('');
}

function renderGrid(grid, gridArticles) {
    if (!grid) {
        return;
    }

    grid.innerHTML = gridArticles.map((article, index) => {
        const offsetClass = index % 3 === 1 ? 'lg:mt-24' : index % 3 === 2 ? 'lg:-mt-24' : '';

        return `
            <div class="article-grid ${offsetClass}">
                <a href="${article.url}" class="group article-card block">
                    <div class="aspect-[4/5] overflow-hidden bg-zinc-900 mb-8 rounded-sm">
                        ${article.thumbnail ? `<img src="${article.thumbnail}" alt="${escapeHtml(article.title)}" class="article-image w-full h-full object-cover">` : ''}
                    </div>
                    <div class="flex space-x-4 text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-4">
                        <span>${escapeHtml(article.dateShort)}</span>
                        <span>${article.readTime} Min</span>
                    </div>
                    <h3 class="text-3xl font-display font-black uppercase mb-4 leading-tight group-hover:text-zinc-300 transition-colors">${escapeHtml(article.title)}</h3>
                    ${article.description ? `<p class="text-sm text-zinc-500 font-light leading-relaxed mb-6 line-clamp-3">${escapeHtml(article.description)}</p>` : ''}
                    <span class="text-[10px] font-bold uppercase text-zinc-400">Read Article</span>
                </a>
            </div>
        `;
    }).join('');
}

export function initJournalIndex() {
    const root = document.querySelector('[data-journal-index]');

    if (!root) {
        return;
    }

    const articlesData = document.getElementById('journal-articles-data');

    if (!articlesData) {
        return;
    }

    const articles = JSON.parse(articlesData.textContent);
    const searchInput = document.getElementById('journal-search');
    const sortSelect = document.getElementById('journal-sort');
    const filterButtons = document.querySelectorAll('#category-filters .filter-btn');
    const featuredSlot = document.getElementById('featured-slot');
    const pinnedColumn = document.getElementById('pinned-slot');
    const pinnedItems = document.getElementById('pinned-items');
    const noResults = document.getElementById('no-results');
    const articleCount = document.getElementById('article-count');
    const grid = document.getElementById('journal-grid');
    const paginationRoot = document.getElementById('journal-pagination');

    if (!paginationRoot) {
        return;
    }

    let activeCategory = 'all';
    let searchQuery = '';

    const sortArticles = (items) => {
        const sortBy = sortSelect?.value ?? 'latest';

        return [...items].sort((a, b) => {
            if (sortBy === 'latest') {
                return b.timestamp - a.timestamp;
            }

            if (sortBy === 'oldest') {
                return a.timestamp - b.timestamp;
            }

            return a.title.localeCompare(b.title);
        });
    };

    const getFilteredArticles = () => {
        return sortArticles(articles.filter((article) => {
            const matchesCategory = activeCategory === 'all' || article.categoryId === activeCategory;
            const matchesSearch = !searchQuery || article.search.includes(searchQuery);

            return matchesCategory && matchesSearch;
        }));
    };

    const renderPage = (pageArticles) => {
        renderFeatured(featuredSlot, pageArticles[0] ?? null);
        renderPinned(pinnedColumn, pinnedItems, pageArticles.slice(1, 3));
        renderGrid(grid, pageArticles.slice(3, 9));
    };

    const pagination = createPagination({
        root: paginationRoot,
        perPage: Number(paginationRoot.dataset.perPage ?? 9),
        scrollTarget: document.getElementById('journal-content'),
        onNavigate: () => {
            renderCurrentPage();
        },
    });

    const renderCurrentPage = () => {
        const filtered = getFilteredArticles();
        const { items } = pagination.paginate(filtered);

        renderPage(items);

        if (articleCount) {
            articleCount.textContent = String(filtered.length);
        }

        if (noResults) {
            noResults.classList.toggle('hidden', filtered.length > 0);
        }
    };

    const resetAndApply = () => {
        pagination.resetPage();
        renderCurrentPage();
    };

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((btn) => btn.classList.remove('active'));
            button.classList.add('active');
            activeCategory = button.dataset.category;
            resetAndApply();
        });
    });

    searchInput?.addEventListener('input', () => {
        searchQuery = searchInput.value.trim().toLowerCase();
        resetAndApply();
    });

    sortSelect?.addEventListener('change', resetAndApply);

    renderCurrentPage();
}
