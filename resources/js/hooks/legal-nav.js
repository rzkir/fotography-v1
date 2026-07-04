export function initLegalNav() {
    const root = document.querySelector('[data-legal-page]');

    if (! root) {
        return;
    }

    const nav = root.querySelector('[data-legal-nav]');

    if (! nav) {
        return;
    }

    const links = [...nav.querySelectorAll('a[href^="#"]')];
    const sections = links
        .map((link) => document.getElementById(link.getAttribute('href').slice(1)))
        .filter(Boolean);

    if (sections.length === 0) {
        return;
    }

    let ticking = false;

    const setActive = (id) => {
        links.forEach((link) => {
            const isActive = link.getAttribute('href') === `#${id}`;

            link.classList.toggle('is-active', isActive);
            link.parentElement?.classList.toggle('is-active', isActive);
        });
    };

    const updateActive = () => {
        const offset = window.matchMedia('(min-width: 1024px)').matches ? 168 : 136;
        let activeId = sections[0].id;

        for (const section of sections) {
            if (section.getBoundingClientRect().top <= offset) {
                activeId = section.id;
            }
        }

        setActive(activeId);
        ticking = false;
    };

    const onScroll = () => {
        if (! ticking) {
            ticking = true;
            requestAnimationFrame(updateActive);
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    updateActive();
}
