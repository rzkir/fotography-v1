let activeForm = null;

function openAlertDialog(dialog, { title, description, confirmLabel, formId }) {
    const titleEl = dialog.querySelector('[data-alert-title]');
    const descriptionEl = dialog.querySelector('[data-alert-description]');
    const confirmBtn = dialog.querySelector('[data-alert-confirm]');

    if (title && titleEl) {
        titleEl.textContent = title;
    }

    if (description && descriptionEl) {
        descriptionEl.textContent = description;
    }

    if (confirmLabel && confirmBtn) {
        confirmBtn.textContent = confirmLabel;
    }

    activeForm = formId ? document.getElementById(formId) : null;

    dialog.classList.remove('hidden');
    dialog.classList.add('flex');
    document.body.style.overflow = 'hidden';

    const confirmButton = dialog.querySelector('[data-alert-confirm]');
    confirmButton?.focus();
}

function closeAlertDialog(dialog) {
    dialog.classList.add('hidden');
    dialog.classList.remove('flex');
    document.body.style.overflow = '';
    activeForm = null;
}

function initAlertDialog(dialog) {
    const dialogId = dialog.id;

    dialog.querySelector('[data-alert-cancel]')?.addEventListener('click', () => {
        closeAlertDialog(dialog);
    });

    dialog.querySelector('[data-alert-overlay]')?.addEventListener('click', () => {
        closeAlertDialog(dialog);
    });

    dialog.querySelector('[data-alert-confirm]')?.addEventListener('click', () => {
        if (activeForm) {
            activeForm.submit();
        }

        closeAlertDialog(dialog);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !dialog.classList.contains('hidden')) {
            closeAlertDialog(dialog);
        }
    });

    document.querySelectorAll(`[data-alert-open="${dialogId}"]`).forEach((trigger) => {
        trigger.addEventListener('click', () => {
            openAlertDialog(dialog, {
                title: trigger.dataset.alertTitle,
                description: trigger.dataset.alertDescription,
                confirmLabel: trigger.dataset.alertConfirm,
                formId: trigger.dataset.alertForm,
            });
        });
    });
}

export function initAlertDialogs() {
    document.querySelectorAll('[data-alert-dialog]').forEach(initAlertDialog);
}
