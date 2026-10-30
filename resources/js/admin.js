function initMenu() {
    const toggle = document.querySelector('[data-admin-menu-toggle]');
    const menu = document.querySelector('[data-admin-menu]');

    toggle?.addEventListener('click', () => {
        const open = menu.classList.toggle('hidden') === false;

        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Menüyü kapat' : 'Menüyü aç');
    });
}

function initDeleteConfirmation() {
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });
}

function initImagePreview() {
    const input = document.querySelector('[data-image-input]');
    const preview = document.querySelector('[data-image-preview]');

    input?.addEventListener('change', () => {
        const [file] = input.files;

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
        }
    });
}

initMenu();
initDeleteConfirmation();
initImagePreview();
