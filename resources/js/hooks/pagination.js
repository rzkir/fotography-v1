/**
 * @typedef {Object} PaginationMeta
 * @property {number} page
 * @property {number} totalPages
 * @property {number} totalItems
 * @property {number} perPage
 */

/**
 * @typedef {Object} PaginationSlice
 * @property {Array<unknown>} items
 * @property {PaginationMeta} meta
 */

/**
 * @param {HTMLElement} root
 * @returns {HTMLElement|null}
 */
function resolveScrollTarget(root) {
    const selector = root.dataset.scrollTarget;

    if (!selector) {
        return null;
    }

    return document.querySelector(selector);
}

/**
 * @param {Object} options
 * @param {HTMLElement} options.root
 * @param {number} [options.perPage=9]
 * @param {HTMLElement|null} [options.scrollTarget=null]
 * @param {boolean} [options.padNumbers=true]
 * @param {(page: number, shouldScroll: boolean) => void} [options.onNavigate]
 */
export function createPagination({
    root,
    perPage = 9,
    scrollTarget = null,
    padNumbers = true,
    onNavigate = null,
}) {
    const prevButton = root.querySelector('[data-pagination-prev]');
    const nextButton = root.querySelector('[data-pagination-next]');
    const pagesContainer = root.querySelector('[data-pagination-pages]');
    const scrollElement = scrollTarget ?? resolveScrollTarget(root);

    let currentPage = 1;
    let totalItems = 0;

    const getTotalPages = (itemCount = totalItems) => {
        return Math.max(1, Math.ceil(itemCount / perPage));
    };

    const scrollToTarget = () => {
        scrollElement?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    const renderControls = () => {
        const totalPages = getTotalPages();

        root.classList.toggle('hidden', totalPages <= 1);

        if (!pagesContainer) {
            return;
        }

        pagesContainer.innerHTML = '';

        for (let page = 1; page <= totalPages; page++) {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = padNumbers ? String(page).padStart(2, '0') : String(page);
            button.className = page === currentPage
                ? 'w-10 h-10 flex items-center justify-center border-b-2 border-white'
                : 'w-10 h-10 flex items-center justify-center text-zinc-600 hover:text-white';
            button.addEventListener('click', () => {
                goToPage(page, true);
            });
            pagesContainer.appendChild(button);
        }
    };

    const goToPage = (page, shouldScroll = false) => {
        const totalPages = getTotalPages();
        currentPage = Math.min(Math.max(1, page), totalPages);
        renderControls();
        onNavigate?.(currentPage, shouldScroll);

        if (shouldScroll) {
            scrollToTarget();
        }
    };

    const resetPage = () => {
        currentPage = 1;
    };

    /**
     * @param {Array<unknown>} items
     * @returns {PaginationSlice}
     */
    const paginate = (items) => {
        totalItems = items.length;

        const totalPages = getTotalPages(totalItems);

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        const pageStart = (currentPage - 1) * perPage;

        renderControls();

        return {
            items: items.slice(pageStart, pageStart + perPage),
            meta: {
                page: currentPage,
                totalPages,
                totalItems,
                perPage,
            },
        };
    };

    const bindEvents = () => {
        prevButton?.addEventListener('click', () => {
            if (currentPage > 1) {
                goToPage(currentPage - 1, true);
            }
        });

        nextButton?.addEventListener('click', () => {
            if (currentPage < getTotalPages()) {
                goToPage(currentPage + 1, true);
            }
        });
    };

    bindEvents();

    return {
        paginate,
        goToPage,
        resetPage,
        getCurrentPage: () => currentPage,
        getTotalPages,
        renderControls,
    };
}

/**
 * @param {string} [selector='[data-pagination-root]']
 */
export function initPaginationRoots(selector = '[data-pagination-root]') {
    document.querySelectorAll(selector).forEach((root) => {
        if (root.dataset.paginationInitialized === 'true' || root.hasAttribute('data-pagination-manual')) {
            return;
        }

        const perPage = Number(root.dataset.perPage ?? 9);
        const padNumbers = root.dataset.padNumbers !== 'false';

        createPagination({
            root,
            perPage,
            padNumbers,
            onNavigate: () => {
                root.dispatchEvent(new CustomEvent('pagination:change', {
                    bubbles: true,
                    detail: { root },
                }));
            },
        });

        root.dataset.paginationInitialized = 'true';
    });
}
