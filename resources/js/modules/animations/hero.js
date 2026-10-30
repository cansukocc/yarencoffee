import { gsap } from './shared';

export function animateHero() {
    gsap.timeline({ defaults: { ease: 'power3.out' } })
        .fromTo(
            '[data-hero-image]',
            { clipPath: 'inset(100% 0% 0% 0%)' },
            { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.2, ease: 'power3.inOut' },
            0,
        )
        .fromTo(
            '[data-hero-letter]',
            { yPercent: 70, opacity: 0 },
            { yPercent: 0, opacity: 1, duration: 0.8, stagger: 0.06 },
            0.1,
        )
        .fromTo(
            '[data-hero-item]',
            { y: 16, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.6, stagger: 0.08 },
            0.25,
        );
}
