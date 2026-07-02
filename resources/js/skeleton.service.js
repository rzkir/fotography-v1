export function initPageSkeletons() {
    document.querySelectorAll('[data-page-loading]').forEach((root) => {
        const skeletons = root.querySelectorAll('[data-page-skeleton]');
        const contents = root.querySelectorAll('[data-page-content]');

        if (skeletons.length === 0 || contents.length === 0) {
            return;
        }

        const reveal = () => {
            skeletons.forEach((element) => element.classList.add('hidden'));
            contents.forEach((element) => {
                element.classList.remove('hidden');
                element.classList.add('page-content-enter');
            });
        };

        requestAnimationFrame(() => {
            window.setTimeout(reveal, 200);
        });
    });
}
