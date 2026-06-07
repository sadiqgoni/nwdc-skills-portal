document.addEventListener('DOMContentLoaded', () => {
    const revealItems = document.querySelectorAll('[data-reveal]');

    if (revealItems.length) {
        if (window.matchMedia('(max-width: 639px)').matches) {
            revealItems.forEach((item) => item.classList.add('is-visible'));
        } else {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (! entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                });
            }, {
                threshold: 0.14,
            });

            revealItems.forEach((item) => revealObserver.observe(item));
        }
    }

    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.passwordToggle);

            if (! input) {
                return;
            }

            const passwordVisible = input.type === 'text';
            input.type = passwordVisible ? 'password' : 'text';
            button.setAttribute('aria-label', passwordVisible ? 'Show password' : 'Hide password');
        });
    });

    document.querySelectorAll('input[inputmode="numeric"]').forEach((input) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '').slice(0, Number(input.getAttribute('maxlength')) || undefined);
        });
    });

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.skipLoadingButton !== undefined) {
                return;
            }

            const button = event.submitter || form.querySelector('button[type="submit"], button:not([type])');

            if (! button || button.dataset.loading === 'true') {
                return;
            }

            button.dataset.loading = 'true';
            button.dataset.originalText = button.innerHTML;
            button.disabled = true;
            button.classList.add('portal-loading-button');
            button.innerHTML = `<span class="portal-spinner" aria-hidden="true"></span><span>${button.dataset.loadingText || 'Processing...'}</span>`;

            form.querySelectorAll('button[type="submit"], button:not([type])').forEach((submitButton) => {
                submitButton.disabled = true;
            });
        });
    });
});
