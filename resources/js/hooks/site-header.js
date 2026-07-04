export function initSiteHeader() {
    const header = document.querySelector('[data-site-header]');

    if (!header) {
        return;
    }

    const nav = header.querySelector('[data-site-nav]');
    const menu = header.querySelector('[data-site-menu]');
    const toggles = header.querySelectorAll('[data-menu-toggle]');
    const links = menu?.querySelectorAll('[data-menu-link]') ?? [];
    const icons = header.querySelectorAll('[data-menu-icon]');
    const labels = header.querySelectorAll('[data-menu-label]');

    if (!menu || toggles.length === 0) {
        return;
    }

    let isOpen = false;

    const setIcon = (open) => {
        icons.forEach((icon) => {
            icon.setAttribute('icon', open ? 'lucide:x' : 'lucide:menu');
        });

        labels.forEach((label) => {
            label.textContent = open ? 'Close' : 'Menu';
        });

        toggles.forEach((toggle) => {
            toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        });
    };

    const openMenu = () => {
        isOpen = true;
        menu.classList.add('site-menu--open');
        menu.setAttribute('aria-hidden', 'false');
        document.documentElement.classList.add('site-menu-active');
        document.body.classList.add('site-menu-active');
        nav?.classList.add('site-nav--menu-open');

        toggles.forEach((toggle) => {
            toggle.setAttribute('aria-expanded', 'true');
        });

        setIcon(true);
    };

    const closeMenu = () => {
        isOpen = false;
        menu.classList.remove('site-menu--open');
        menu.setAttribute('aria-hidden', 'true');
        document.documentElement.classList.remove('site-menu-active');
        document.body.classList.remove('site-menu-active');
        nav?.classList.remove('site-nav--menu-open');

        toggles.forEach((toggle) => {
            toggle.setAttribute('aria-expanded', 'false');
        });

        setIcon(false);
    };

    const toggleMenu = () => {
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    };

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', toggleMenu);
    });

    links.forEach((link) => {
        link.addEventListener('click', closeMenu);
    });

    menu.querySelector('[data-menu-backdrop]')?.addEventListener('click', closeMenu);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && isOpen) {
            closeMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768 && isOpen) {
            closeMenu();
        }
    });
}
