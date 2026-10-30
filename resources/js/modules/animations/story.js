import { gsap } from './shared';

export function animateStory() {
    const heading = document.querySelector('[data-words]');

    gsap.fromTo(
        heading.querySelectorAll('[data-word]'),
        { y: 24, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: 0.7,
            stagger: 0.08,
            ease: 'power3.out',
            scrollTrigger: { trigger: heading, start: 'top 85%', once: true },
        },
    );
}
