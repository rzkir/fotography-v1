<?php

export function openDialog(dialog) {
    dialog.classList.remove('hidden');
    dialog.classList.add('flex');
    document.body.style.overflow = 'hidden';

    const firstInput = dialog.querySelector('input:not([type="hidden"])');
    firstInput?.focus();
}

export function closeDialog(dialog) {
    dialog.classList.add('hidden');
    dialog.classList.remove('flex');
    document.body.style.overflow = '';
}

export function initDialogs() {
    document.querySelectorAll('[data-dialog]').forEach((dialog) => {
        dialog.querySelectorAll('[data-dialog-close]').forEach((button) => {
            button.addEventListener('click', () => closeDialog(dialog));
        });

        dialog.querySelector('[data-dialog-overlay]')?.addEventListener('click', () => {
            closeDialog(dialog);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !dialog.classList.contains('hidden')) {
                closeDialog(dialog);
            }
        });
    });
}
