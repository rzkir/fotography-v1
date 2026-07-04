import AOS from 'aos';
import 'aos/dist/aos.css';
import { isSplashSeen } from './splash-screen';
function playImmediateAnimations(selector) {
    document.querySelectorAll(`${selector} [data-aos]`).forEach((element) => {
        element.classList.remove('aos-animate');

        const delay = Number(element.getAttribute('data-aos-delay')) || 0;

        window.setTimeout(() => {
            element.classList.add('aos-animate');
        }, 80 + delay);
    });

    document.querySelectorAll(`${selector} img`).forEach((image) => {
        image.style.transform = '';
    });
}

function playHeroAnimations() {
    playImmediateAnimations('[data-aos-hero]');
    playImmediateAnimations('[data-aos-header]');
}

function startAos() {
    if (! document.querySelector('[data-aos]')) {
        return;
    }

    AOS.init({
        duration: 900,
        easing: 'ease-out-cubic',
        once: true,
        offset: 80,
        mirror: false,
    });

    if (document.querySelector('[data-aos-hero], [data-aos-header]')) {
        playHeroAnimations();
    }

    requestAnimationFrame(() => AOS.refresh());
}

function scheduleAosStart() {
    if (document.readyState === 'complete') {
        startAos();
    } else {
        window.addEventListener('load', startAos, { once: true });
    }
}

export function initAnimations() {
    const hasSplash = document.querySelector('[data-splash-screen]');

    if (hasSplash && ! isSplashSeen()) {
        window.addEventListener('splash:complete', scheduleAosStart, { once: true });

        return;
    }

    scheduleAosStart();
}

export function refreshAnimations() {
    if (! document.querySelector('[data-aos]')) {
        return;
    }

    AOS.refresh();
}
