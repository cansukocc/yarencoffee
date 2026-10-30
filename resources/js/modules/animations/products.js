import { gsap } from './shared';

const MAX_TILT = 4;

export function animateProductTilt(signal) {
    document.querySelectorAll('[data-tilt]').forEach((card) => {
        const rotateX = gsap.quickTo(card, 'rotationX', { duration: 0.4, ease: 'power2.out' });
        const rotateY = gsap.quickTo(card, 'rotationY', { duration: 0.4, ease: 'power2.out' });

        card.style.transitionProperty = 'translate, box-shadow';
        gsap.set(card, { transformPerspective: 900 });

        card.addEventListener(
            'pointermove',
            (event) => {
                const { left, top, width, height } = card.getBoundingClientRect();

                rotateY(((event.clientX - left) / width - 0.5) * 2 * MAX_TILT);
                rotateX(((event.clientY - top) / height - 0.5) * -2 * MAX_TILT);
            },
            { signal },
        );

        card.addEventListener(
            'pointerleave',
            () => {
                rotateX(0);
                rotateY(0);
            },
            { signal },
        );
    });
}
