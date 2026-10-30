import { MOTION_QUERY, gsap } from './shared';

const DESKTOP_QUERY = `${MOTION_QUERY} and (min-width: 48rem)`;
const MOBILE_QUERY = `${MOTION_QUERY} and (max-width: 47.99rem)`;

function animateFill({ scaleProperty, side, length }) {
    const timeline = document.querySelector('[data-timeline]');
    const fill = timeline.querySelector('[data-timeline-fill]');
    const badges = gsap.utils.toArray(timeline.querySelectorAll('[data-timeline-badge]'));
    const rings = badges.map((badge) => badge.querySelector('[data-timeline-ring]'));
    const reached = badges.map(() => false);

    const badgeProgress = (badge) => {
        const offset = badge.getBoundingClientRect()[side] - timeline.getBoundingClientRect()[side];

        return offset / timeline.getBoundingClientRect()[length];
    };

    const highlight = (index, active) => {
        reached[index] = active;
        gsap.to(badges[index], { scale: active ? 1.08 : 1, duration: 0.4, ease: 'back.out(2)', overwrite: true });
        gsap.to(rings[index], { opacity: active ? 1 : 0, duration: 0.3, overwrite: true });
    };

    gsap.set(fill, { opacity: 1 });
    gsap.fromTo(
        fill,
        { [scaleProperty]: 0 },
        {
            [scaleProperty]: 1,
            ease: 'none',
            scrollTrigger: {
                trigger: timeline,
                start: 'top 70%',
                end: 'bottom 70%',
                scrub: true,
                onUpdate: ({ progress }) => {
                    badges.forEach((badge, index) => {
                        const active = progress > 0 && progress >= badgeProgress(badge);

                        if (active !== reached[index]) {
                            highlight(index, active);
                        }
                    });
                },
            },
        },
    );
}

export function animateTimeline(media) {
    media.add(DESKTOP_QUERY, () => animateFill({ scaleProperty: 'scaleX', side: 'left', length: 'width' }));
    media.add(MOBILE_QUERY, () => animateFill({ scaleProperty: 'scaleY', side: 'top', length: 'height' }));
}
