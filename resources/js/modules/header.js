const SCROLL_THRESHOLD = 24;
const BACKGROUND_CLASSES = ['bg-cream/85', 'backdrop-blur-md', 'shadow-[0_1px_0_0_var(--border)]'];
const MENU_OPEN_CLASSES = ['visible', 'opacity-100'];
const MENU_CLOSED_CLASSES = ['invisible', '-translate-y-4', 'opacity-0'];

function trackActiveSection() {
    const links = document.querySelectorAll('[data-nav-link]');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                links.forEach((link) => {
                    if (link.hash === `#${entry.target.id}`) {
                        link.toggleAttribute('aria-current', entry.isIntersecting);
                    }
                });
            });
        },
        { rootMargin: '-45% 0px -50% 0px' },
    );

    links.forEach((link) => observer.observe(document.querySelector(link.hash)));
}

export function initHeader() {
    trackActiveSection();

    const background = document.querySelector('[data-header-background]');
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('#mobile-menu');
    const closedIcon = toggle.querySelector('[data-menu-icon="closed"]');
    const openIcon = toggle.querySelector('[data-menu-icon="open"]');

    let open = false;

    const updateBackground = () => {
        const solid = open || window.scrollY > SCROLL_THRESHOLD;

        BACKGROUND_CLASSES.forEach((name) => background.classList.toggle(name, solid));
    };

    const setOpen = (next) => {
        open = next;

        menu.classList.remove(...(open ? MENU_CLOSED_CLASSES : MENU_OPEN_CLASSES));
        menu.classList.add(...(open ? MENU_OPEN_CLASSES : MENU_CLOSED_CLASSES));

        closedIcon.toggleAttribute('hidden', open);
        openIcon.toggleAttribute('hidden', !open);

        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Menüyü kapat' : 'Menüyü aç');

        document.body.style.overflow = open ? 'hidden' : '';
        updateBackground();
    };

    toggle.addEventListener('click', () => setOpen(!open));

    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && open) {
            setOpen(false);
            toggle.focus();
        }
    });

    window.matchMedia('(min-width: 48rem)').addEventListener('change', (event) => {
        if (event.matches) {
            setOpen(false);
        }
    });

    window.addEventListener('scroll', updateBackground, { passive: true });
    updateBackground();
}
