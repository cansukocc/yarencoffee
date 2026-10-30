import { ScrollTrigger, gsap } from './shared';

const MAX_RATE = 5;
const VELOCITY_DIVISOR = 500;

export function animateMarquee() {
    const [animation] = document.querySelector('.marquee').getAnimations();
    const speed = { rate: 1 };

    const applyRate = () => {
        animation.playbackRate = speed.rate;
    };

    ScrollTrigger.create({
        start: 0,
        end: 'max',
        onUpdate: (self) => {
            const boost = gsap.utils.clamp(1, MAX_RATE, 1 + Math.abs(self.getVelocity()) / VELOCITY_DIVISOR);

            speed.rate = self.direction * boost;
            applyRate();
            gsap.to(speed, { rate: self.direction, duration: 0.8, ease: 'power2.out', overwrite: true, onUpdate: applyRate });
        },
    });
}
