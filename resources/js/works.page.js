export function initWorksIndex() {
    const root = document.querySelector('[data-works-index]');

    if (!root) {
        return;
    }

    const grid = document.getElementById('portfolio-grid');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const sortSelect = document.getElementById('sort-select');
    const filterButtons = document.querySelectorAll('#category-filters .filter-btn');
    const perPage = Number(root.dataset.perPage ?? 6);
    let visibleCount = perPage;
    let activeCategory = 'all';

    const getItems = () => Array.from(grid?.querySelectorAll('.portfolio-item') ?? []);

    const applyFilters = () => {
        const items = getItems();
        let shown = 0;

        items.forEach((item) => {
            const matchesCategory = activeCategory === 'all' || item.dataset.category === activeCategory;
            const withinLimit = shown < visibleCount;

            if (matchesCategory && withinLimit) {
                item.classList.remove('hidden-by-filter', 'hidden-by-load-more');
                shown++;
            } else if (!matchesCategory) {
                item.classList.add('hidden-by-filter');
                item.classList.remove('hidden-by-load-more');
            } else {
                item.classList.remove('hidden-by-filter');
                item.classList.add('hidden-by-load-more');
            }
        });

        if (loadMoreBtn) {
            const totalMatching = items.filter(
                (item) => activeCategory === 'all' || item.dataset.category === activeCategory,
            ).length;

            loadMoreBtn.classList.toggle('hidden', shown >= totalMatching);
        }
    };

    const sortItems = () => {
        if (!grid) {
            return;
        }

        const items = getItems();
        const sortBy = sortSelect?.value ?? 'latest';

        items.sort((a, b) => {
            if (sortBy === 'latest') {
                return Number(b.dataset.year) - Number(a.dataset.year);
            }

            if (sortBy === 'oldest') {
                return Number(a.dataset.year) - Number(b.dataset.year);
            }

            return a.dataset.title.localeCompare(b.dataset.title);
        });

        items.forEach((item) => grid.appendChild(item));
    };

    const scrollToPortfolio = () => {
        root.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((btn) => btn.classList.remove('active'));
            button.classList.add('active');
            activeCategory = button.dataset.category;
            visibleCount = perPage;
            applyFilters();
        });
    });

    sortSelect?.addEventListener('change', () => {
        sortItems();
        applyFilters();
    });

    loadMoreBtn?.addEventListener('click', () => {
        visibleCount += perPage;
        applyFilters();
        scrollToPortfolio();
    });

    if (grid) {
        sortItems();
        applyFilters();
    }
}
