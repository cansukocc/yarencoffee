export function initProductInquiry() {
    const contact = document.querySelector('#iletisim');
    const nameField = document.querySelector('#field-name');
    const messageField = document.querySelector('#field-message');

    document.querySelectorAll('[data-product-inquiry]').forEach((button) => {
        button.addEventListener('click', () => {
            if (messageField.value.trim() === '') {
                messageField.value = `Merhaba, ${button.dataset.productInquiry} hakkında bilgi almak istiyorum.`;
            }

            contact.scrollIntoView();
            nameField.focus({ preventScroll: true });
        });
    });
}
