const READING_DURATION = 1600;
const WIGGLE_CLASS = 'animate-[wiggle_0.4s_ease-in-out_4]';
const LIFTED_TRANSFORM = 'translate(18px, -34px) rotate(-10deg)';

export function initFortune() {
    const section = document.querySelector('[data-fortune]');
    const fortunes = JSON.parse(section.dataset.fortune);

    const button = section.querySelector('[data-fortune-button]');
    const label = section.querySelector('[data-fortune-label]');
    const stage = section.querySelector('[data-fortune-stage]');
    const cup = section.querySelector('[data-fortune-cup]');
    const telve = section.querySelector('[data-fortune-telve]');
    const symbol = section.querySelector('[data-fortune-symbol]');
    const text = section.querySelector('[data-fortune-text]');
    const panels = section.querySelectorAll('[data-fortune-panel]');
    const readIcon = section.querySelector('[data-fortune-icon="read"]');
    const againIcon = section.querySelector('[data-fortune-icon="again"]');

    let index = 0;

    const setPhase = (phase) => {
        const done = phase === 'done';

        panels.forEach((panel) => {
            panel.toggleAttribute('hidden', panel.dataset.fortunePanel !== phase);
        });

        button.disabled = phase === 'reading';
        label.textContent = done ? 'Tekrar Bak' : 'Falına Bak';
        readIcon.toggleAttribute('hidden', done);
        againIcon.toggleAttribute('hidden', !done);

        stage.classList.toggle(WIGGLE_CLASS, phase === 'reading');
        cup.style.transform = done ? LIFTED_TRANSFORM : 'none';
        telve.classList.toggle('opacity-100', done);
        telve.classList.toggle('opacity-0', !done);
    };

    const nextIndex = () => {
        const next = Math.floor(Math.random() * fortunes.length);

        return next === index ? (next + 1) % fortunes.length : next;
    };

    button.addEventListener('click', () => {
        index = nextIndex();
        symbol.textContent = fortunes[index].symbol;
        text.textContent = fortunes[index].text;

        setPhase('reading');
        window.setTimeout(() => setPhase('done'), READING_DURATION);
    });
}
