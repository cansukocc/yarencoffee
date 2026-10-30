import { gsap, prefersMotion } from './shared';

const FILL_DEPTH = 50;
const WAVE_LENGTH = 24;

function buildSuccessTimeline(panel) {
    const draw = panel.querySelectorAll('[data-success-draw]');
    const check = panel.querySelector('[data-success-check]');
    const fill = panel.querySelector('[data-success-fill]');
    const wave = panel.querySelector('[data-success-wave]');
    const foam = panel.querySelector('[data-success-foam]');
    const steam = panel.querySelectorAll('[data-success-steam]');
    const items = panel.querySelectorAll('[data-success-item]');

    gsap.set([...draw, check], { strokeDasharray: 1, strokeDashoffset: 1, opacity: 0 });
    gsap.set(fill, { y: FILL_DEPTH });
    gsap.set(wave, { x: 0 });
    gsap.set(foam, { opacity: 0 });
    gsap.set(steam, { y: 6, opacity: 0 });
    gsap.set(items, { y: 12, opacity: 0 });

    const timeline = gsap.timeline();

    timeline
        .set(draw, { opacity: 1 }, 0)
        .to(draw, { strokeDashoffset: 0, duration: 0.5, stagger: 0.08, ease: 'power1.inOut' }, 0)
        .to(fill, { y: 0, duration: 0.65, ease: 'power2.out' }, 0.45)
        .to(wave, { x: WAVE_LENGTH, duration: 0.7, ease: 'none', repeat: 3 }, 0.45)
        .to(foam, { opacity: 1, duration: 0.25 }, 0.9)
        .set(check, { opacity: 1 }, 1.05)
        .to(check, { strokeDashoffset: 0, duration: 0.3, ease: 'power2.out' }, 1.05)
        .to(steam, { y: -8, opacity: 0.8, duration: 0.5, stagger: 0.1, ease: 'power1.out' }, 1.05)
        .to(items, { y: 0, opacity: 1, duration: 0.35, stagger: 0.14, ease: 'power2.out' }, 1.3);

    return timeline;
}

export function createContactAnimator(form, success) {
    let timeline = null;

    const stop = () => {
        timeline?.kill();
        timeline = null;
        gsap.killTweensOf(form);
        gsap.set(form, { clearProps: 'opacity,transform' });
    };

    const revealPanel = () => {
        form.hidden = true;
        success.hidden = false;
    };

    return {
        showSuccess() {
            stop();

            if (!prefersMotion()) {
                revealPanel();

                return;
            }

            success.style.minHeight = `${form.offsetHeight}px`;

            gsap.to(form, {
                opacity: 0,
                y: -10,
                duration: 0.3,
                ease: 'power2.in',
                onComplete: () => {
                    revealPanel();
                    gsap.set(form, { clearProps: 'opacity,transform' });
                    timeline = buildSuccessTimeline(success);
                },
            });
        },

        showForm() {
            stop();
            success.hidden = true;
            success.style.minHeight = '';
            form.hidden = false;

            if (prefersMotion()) {
                gsap.fromTo(form, { y: 10, opacity: 0 }, { y: 0, opacity: 1, duration: 0.4, ease: 'power2.out', clearProps: 'opacity,transform' });
            }
        },
    };
}
