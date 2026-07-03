import AOS from 'aos';
import 'aos/dist/aos.css';

function playHeroAnimations() {
    const heroElements = document.querySelectorAll('[data-aos-hero] [data-aos]');

    heroElements.forEach((element) => {
        element.classList.remove('aos-animate');

        const delay = Number(element.getAttribute('data-aos-delay')) || 0;

        window.setTimeout(() => {
            element.classList.add('aos-animate');
        }, 80 + delay);
    });

    document.querySelectorAll('[data-aos-hero] img').forEach((image) => {
        image.style.transform = '';
    });
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

    if (document.querySelector('[data-aos-hero]')) {
        playHeroAnimations();
    }

    requestAnimationFrame(() => AOS.refresh());
}

export function initAnimations() {
    if (document.readyState === 'complete') {
        startAos();
    } else {
        window.addEventListener('load', startAos, { once: true });
    }
}

export function refreshAnimations() {
    if (! document.querySelector('[data-aos]')) {
        return;
    }

    AOS.refresh();
}
