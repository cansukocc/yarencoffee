import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export { gsap, ScrollTrigger };

export const MOTION_QUERY = '(prefers-reduced-motion: no-preference)';
export const FINE_POINTER_QUERY = `${MOTION_QUERY} and (pointer: fine)`;

export const prefersMotion = () => window.matchMedia(MOTION_QUERY).matches;

export function splitWords(element) {
    const words = element.textContent.trim().split(/\s+/);

    element.textContent = '';

    return words.map((word, index) => {
        const span = document.createElement('span');

        span.className = 'inline-block';
        span.textContent = word;
        element.append(span);

        if (index < words.length - 1) {
            element.append(' ');
        }

        return span;
    });
}
