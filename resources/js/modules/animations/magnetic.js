import { gsap } from './shared';

const STRENGTH = 0.2;

export function animateMagnetic(signal) {
    document.querySelectorAll('[data-magnetic]').forEach((button) => {
        const moveX = gsap.quickTo(button, 'x', { duration: 0.4, ease: 'power3.out' });
        const moveY = gsap.quickTo(button, 'y', { duration: 0.4, ease: 'power3.out' });

        button.addEventListener(
            'pointermove',
            (event) => {
                const { left, top, width, height } = button.getBoundingClientRect();

                moveX((event.clientX - left - width / 2) * STRENGTH);
                moveY((event.clientY - top - height / 2) * STRENGTH);
            },
            { signal },
        );

        button.addEventListener(
            'pointerleave',
            () => {
                moveX(0);
                moveY(0);
            },
            { signal },
        );
    });
}
