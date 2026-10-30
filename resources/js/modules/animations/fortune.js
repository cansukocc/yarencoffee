import { gsap, prefersMotion, splitWords } from './shared';

const SVG_NAMESPACE = 'http://www.w3.org/2000/svg';
const GRAIN_COUNT = 26;
const SAUCER = { x: 130, y: 196, radiusX: 52, radiusY: 7 };

function createGrains(cup) {
    const group = document.createElementNS(SVG_NAMESPACE, 'g');

    group.setAttribute('fill', '#3B2418');
    cup.before(group);

    return Array.from({ length: GRAIN_COUNT }, () => {
        const grain = document.createElementNS(SVG_NAMESPACE, 'circle');

        grain.setAttribute('cx', SAUCER.x);
        grain.setAttribute('cy', SAUCER.y);
        grain.setAttribute('r', gsap.utils.random(0.7, 1.9));
        group.append(grain);

        return grain;
    });
}

export function createFortuneAnimator(section) {
    if (!prefersMotion()) {
        return null;
    }

    const cup = section.querySelector('[data-fortune-cup]');
    const steam = section.querySelector('[data-fortune-steam]');
    const text = section.querySelector('[data-fortune-text]');
    const grains = createGrains(cup);

    cup.classList.remove('transition-transform', 'duration-1000');
    gsap.set(cup, { svgOrigin: '130 131' });
    gsap.set(grains, { opacity: 0 });

    const lower = () => {
        gsap.to(cup, { x: 0, y: 0, rotation: 0, scale: 1, duration: 0.6, ease: 'power2.inOut', overwrite: true });
        gsap.to(steam, { opacity: 0.35, duration: 0.4, overwrite: true });
        gsap.to(grains, { x: 0, y: 0, opacity: 0, duration: 0.4, overwrite: true });
    };

    const lift = () => {
        gsap.to(steam, { opacity: 0, duration: 0.3, overwrite: true });
        gsap.to(cup, { x: 60, y: -36, rotation: 180, scale: 0.62, duration: 1, ease: 'power2.inOut', overwrite: true });

        gsap.to(grains, {
            x: () => gsap.utils.random(-SAUCER.radiusX, SAUCER.radiusX),
            y: () => gsap.utils.random(-SAUCER.radiusY, SAUCER.radiusY),
            opacity: 0.9,
            duration: 0.7,
            delay: 0.35,
            stagger: 0.012,
            ease: 'power2.out',
            overwrite: true,
        });

        gsap.fromTo(
            splitWords(text),
            { y: 8, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.45, stagger: 0.05, delay: 0.2, ease: 'power2.out' },
        );
    };

    return { lower, lift };
}
