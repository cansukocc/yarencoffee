export function initContactForm() {
    const form = document.querySelector('[data-contact-form]');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
    });
}
