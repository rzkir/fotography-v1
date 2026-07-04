export const SPLASH_STORAGE_KEY = 'noir-splash-seen';
const MIN_DURATION_MS = 2200;
const EXIT_DURATION_MS = 900;

export function isSplashSeen() {
    try {
        return sessionStorage.getItem(SPLASH_STORAGE_KEY) === '1';
    } catch {
        return false;
    }
}

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function formatCounter(value) {
    return String(Math.min(100, Math.max(0, Math.round(value)))).padStart(3, '0');
}

function waitForWindowLoad() {
    if (document.readyState === 'complete') {
        return Promise.resolve();
    }

    return new Promise((resolve) => {
        window.addEventListener('load', resolve, { once: true });
    });
}

function animateCounter(progressEl, counterEl, durationMs) {
    const start = performance.now();

    const tick = (now) => {
        const elapsed = now - start;
        const progress = Math.min(elapsed / durationMs, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = eased * 100;

        if (progressEl) {
            progressEl.style.width = `${value}%`;
        }

        if (counterEl) {
            counterEl.textContent = formatCounter(value);
        }

        if (progress < 1) {
            requestAnimationFrame(tick);
        }
    };

    requestAnimationFrame(tick);
}

function dismissSplash(root) {
    root.classList.remove('splash-screen--active');
    root.classList.add('splash-screen--exit');

    window.setTimeout(() => {
        root.remove();
        document.documentElement.classList.remove('splash-active');
        document.body.classList.remove('splash-active');
        window.dispatchEvent(new CustomEvent('splash:complete'));
    }, EXIT_DURATION_MS);
}

function skipSplash(root) {
    root.remove();
    window.dispatchEvent(new CustomEvent('splash:complete'));
}

export function initSplashScreen() {
    const root = document.querySelector('[data-splash-screen]');

    if (! root) {
        window.dispatchEvent(new CustomEvent('splash:complete'));

        return;
    }

    if (isSplashSeen()) {
        skipSplash(root);

        return;
    }

    const progressEl = root.querySelector('[data-splash-progress]');
    const counterEl = root.querySelector('[data-splash-counter]');

    root.classList.add('splash-screen--active');
    document.documentElement.classList.add('splash-active');
    document.body.classList.add('splash-active');
    root.setAttribute('aria-hidden', 'false');

    const reducedMotion = prefersReducedMotion();
    const durationMs = reducedMotion ? 600 : MIN_DURATION_MS;

    animateCounter(progressEl, counterEl, durationMs);

    Promise.all([
        waitForWindowLoad(),
        new Promise((resolve) => window.setTimeout(resolve, durationMs)),
    ]).then(() => {
        try {
            sessionStorage.setItem(SPLASH_STORAGE_KEY, '1');
            document.documentElement.classList.add('splash-seen');
        } catch {
            //
        }

        if (reducedMotion) {
            skipSplash(root);

            return;
        }

        dismissSplash(root);
    });
}
