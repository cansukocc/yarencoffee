import { ScrollTrigger, gsap } from './shared';

const DURATION = 0.35;

export function animateFaq(signal) {
    document.querySelectorAll('[data-faq-item]').forEach((item) => {
        const content = item.querySelector('[data-faq-content]');
        let closing = false;

        const close = () => {
            closing = true;

            gsap.to(content, {
                height: 0,
                opacity: 0,
                duration: DURATION,
                ease: 'power2.inOut',
                overwrite: true,
                onComplete: () => {
                    item.open = false;
                    closing = false;
                    gsap.set(content, { clearProps: 'height,opacity' });
                    ScrollTrigger.refresh();
                },
            });
        };

        const open = () => {
            const startHeight = closing ? content.offsetHeight : 0;

            closing = false;
            item.open = true;

            gsap.fromTo(
                content,
                { height: startHeight, opacity: 0 },
                {
                    height: 'auto',
                    opacity: 1,
                    duration: DURATION,
                    ease: 'power2.out',
                    overwrite: true,
                    clearProps: 'height,opacity',
                    onComplete: () => ScrollTrigger.refresh(),
                },
            );
        };

        item.querySelector('summary').addEventListener(
            'click',
            (event) => {
                event.preventDefault();

                if (item.open && !closing) {
                    close();
                } else {
                    open();
                }
            },
            { signal },
        );
    });
}
