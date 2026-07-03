export function initHomePage() {
    const track = document.getElementById('testimonial-track');

    if (!track) {
        return;
    }

    const prevBtn = document.getElementById('testimonial-prev');
    const nextBtn = document.getElementById('testimonial-next');
    const dots = Array.from(document.querySelectorAll('.testimonial-dot'));
    const total = dots.length;

    if (total <= 1) {
        return;
    }

    let current = 0;
    let autoplayTimer;

    const goTo = (index) => {
        current = (index + total) % total;
        track.style.transform = `translateX(-${current * 100}%)`;

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === current);
            dot.setAttribute('aria-selected', i === current ? 'true' : 'false');
        });
    };

    const startAutoplay = () => {
        stopAutoplay();
        autoplayTimer = setInterval(() => goTo(current + 1), 6000);
    };

    const stopAutoplay = () => {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
        }
    };

    prevBtn?.addEventListener('click', () => {
        goTo(current - 1);
        startAutoplay();
    });

    nextBtn?.addEventListener('click', () => {
        goTo(current + 1);
        startAutoplay();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            goTo(Number(dot.dataset.slide));
            startAutoplay();
        });
    });

    const slider = document.getElementById('testimonials-slider');
    slider?.addEventListener('mouseenter', stopAutoplay);
    slider?.addEventListener('mouseleave', startAutoplay);

    document.addEventListener('keydown', (event) => {
        if (!slider) {
            return;
        }

        if (event.key === 'ArrowLeft') {
            goTo(current - 1);
            startAutoplay();
        }

        if (event.key === 'ArrowRight') {
            goTo(current + 1);
            startAutoplay();
        }
    });

    startAutoplay();
}

export function initWorksDetail() {
    const reveals = document.querySelectorAll('.scroll-reveal');

    if (reveals.length === 0) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    reveals.forEach((reveal) => observer.observe(reveal));
}
