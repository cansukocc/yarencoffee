const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

const FORM_ERROR = 'Formda birkaç eksik var, lütfen kontrol edin.';
const RATE_LIMIT_ERROR = 'Çok fazla deneme yaptınız, lütfen biraz sonra tekrar deneyin.';
const SEND_ERROR = 'Mesajınız gönderilemedi, lütfen tekrar deneyin.';

const RULES = {
    name: { isValid: (value) => value.length >= 2, message: 'Lütfen adınızı yazın.' },
    email: { isValid: (value) => EMAIL_PATTERN.test(value), message: 'Geçerli bir e-posta adresi girin.' },
    message: { isValid: (value) => value.length >= 10, message: 'Mesajınız en az 10 karakter olmalı.' },
};

const FIELD_NAMES = Object.keys(RULES);

export function initContactForm() {
    const form = document.querySelector('[data-contact-form]');
    const success = document.querySelector('[data-contact-success]');
    const successMessage = document.querySelector('[data-contact-success-message]');
    const resetLink = document.querySelector('[data-contact-reset]');
    const alert = form.querySelector('[data-contact-alert]');
    const alertMessage = form.querySelector('[data-contact-alert-message]');
    const submitButton = form.querySelector('[type="submit"]');
    const idleLabel = form.querySelector('[data-contact-submit="idle"]');
    const pendingLabel = form.querySelector('[data-contact-submit="pending"]');
    const fields = Object.fromEntries(FIELD_NAMES.map((name) => [name, form.elements[name]]));
    const honeypot = form.elements.website;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const showAlert = (message) => {
        alertMessage.textContent = message;
        alert.hidden = false;
    };

    const hideAlert = () => {
        alert.hidden = true;
    };

    const setFieldError = (name, message) => {
        const field = fields[name];
        const errorId = `${field.id}-error`;
        const error = document.getElementById(errorId);
        const invalid = message !== null;

        error.querySelector('[data-field-error]').textContent = message ?? '';
        error.hidden = !invalid;

        field.setAttribute('aria-invalid', String(invalid));
        field.classList.toggle('border-destructive', invalid);
        field.classList.toggle('border-input', !invalid);

        if (invalid) {
            field.setAttribute('aria-describedby', errorId);
        } else {
            field.removeAttribute('aria-describedby');
        }
    };

    const fieldValue = (name) => fields[name].value.trim();

    const validate = () => {
        const errors = {};

        FIELD_NAMES.forEach((name) => {
            if (!RULES[name].isValid(fieldValue(name))) {
                errors[name] = RULES[name].message;
            }
        });

        return errors;
    };

    const showErrors = (errors) => {
        FIELD_NAMES.forEach((name) => setFieldError(name, errors[name] ?? null));
        showAlert(FORM_ERROR);
        fields[FIELD_NAMES.find((name) => errors[name])]?.focus();
    };

    const setPending = (pending) => {
        submitButton.disabled = pending;
        idleLabel.hidden = pending;
        pendingLabel.hidden = !pending;
    };

    const showSuccess = (message) => {
        successMessage.textContent = message;
        form.hidden = true;
        success.hidden = false;
    };

    const showForm = () => {
        FIELD_NAMES.forEach((name) => {
            fields[name].value = '';
            setFieldError(name, null);
        });
        honeypot.value = '';
        hideAlert();
        success.hidden = true;
        form.hidden = false;
    };

    const handleResponse = async (response) => {
        if (response.ok) {
            const { message } = await response.json();

            showSuccess(message);
        } else if (response.status === 422) {
            const { errors } = await response.json();

            showErrors(Object.fromEntries(Object.entries(errors).map(([name, messages]) => [name, messages[0]])));
        } else if (response.status === 429) {
            showAlert(RATE_LIMIT_ERROR);
        } else {
            showAlert(SEND_ERROR);
        }
    };

    const send = async () => {
        hideAlert();
        setPending(true);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    name: fieldValue('name'),
                    email: fieldValue('email'),
                    message: fieldValue('message'),
                    website: honeypot.value,
                }),
            });

            await handleResponse(response);
        } catch {
            showAlert(SEND_ERROR);
        } finally {
            setPending(false);
        }
    };

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const errors = validate();

        if (Object.keys(errors).length > 0) {
            showErrors(errors);
        } else {
            send();
        }
    });

    FIELD_NAMES.forEach((name) => {
        fields[name].addEventListener('input', () => {
            if (RULES[name].isValid(fieldValue(name))) {
                setFieldError(name, null);
            }

            if (FIELD_NAMES.every((field) => fields[field].getAttribute('aria-invalid') === 'false')) {
                hideAlert();
            }
        });
    });

    resetLink.addEventListener('click', (event) => {
        event.preventDefault();
        showForm();
        form.closest('section').scrollIntoView();
        fields.name.focus({ preventScroll: true });
    });
}
