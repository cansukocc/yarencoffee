import { gsap } from './shared';

export function animateProgress() {
    gsap.to('[data-scroll-progress]', {
        scaleX: 1,
        ease: 'none',
        scrollTrigger: { start: 0, end: 'max', scrub: 0.2 },
    });
}
