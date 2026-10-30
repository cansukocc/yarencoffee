import { gsap } from './shared';

const SCALE = 1.12;
const TRAVEL = 4;

export function animateParallax() {
    gsap.utils.toArray('[data-parallax]').forEach((image) => {
        gsap.fromTo(
            image,
            { scale: SCALE, yPercent: -TRAVEL },
            {
                yPercent: TRAVEL,
                ease: 'none',
                scrollTrigger: { trigger: image.parentElement, start: 'top bottom', end: 'bottom top', scrub: true },
            },
        );
    });
}
