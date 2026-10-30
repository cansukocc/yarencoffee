import { animateFaq } from './faq';
import { animateHero } from './hero';
import { animateMagnetic } from './magnetic';
import { animateMarquee } from './marquee';
import { animateParallax } from './parallax';
import { animateProductTilt } from './products';
import { animateProgress } from './progress';
import { FINE_POINTER_QUERY, MOTION_QUERY, ScrollTrigger, gsap } from './shared';
import { animateStory } from './story';
import { animateTimeline } from './timeline';

function refreshAfterImagesLoad() {
    const refresh = gsap.delayedCall(0.2, () => ScrollTrigger.refresh()).pause();

    [...document.images]
        .filter((image) => !image.complete)
        .forEach((image) => image.addEventListener('load', () => refresh.restart(true), { once: true }));
}

export function initAnimations() {
    const media = gsap.matchMedia();

    media.add(MOTION_QUERY, () => {
        animateHero();
        animateParallax();
        animateMarquee();
        animateStory();
        animateProgress();

        const controller = new AbortController();

        animateFaq(controller.signal);

        return () => controller.abort();
    });

    media.add(FINE_POINTER_QUERY, () => {
        const controller = new AbortController();

        animateProductTilt(controller.signal);
        animateMagnetic(controller.signal);

        return () => controller.abort();
    });

    animateTimeline(media);
    refreshAfterImagesLoad();
}
