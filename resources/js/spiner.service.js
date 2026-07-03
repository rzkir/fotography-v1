const spinnerSizes = {
    sm: "w-4 h-4 border-2",
    md: "w-5 h-5 border-2",
    lg: "w-8 h-8 border-[3px]",
};

export function spinnerMarkup(size = "md", extraClass = "") {
    const sizeClass = spinnerSizes[size] ?? spinnerSizes.md;

    return `<span class="inline-block animate-spin rounded-full border-white/20 border-t-[#ff6b35] ${sizeClass} ${extraClass}" role="status" aria-hidden="true"></span>`;
}

export function setButtonLoading(button, isLoading, loadingText = "Processing...") {
    if (!button) {
        return;
    }

    if (isLoading) {
        if (!button.dataset.originalHtml) {
            button.dataset.originalHtml = button.innerHTML;
        }

        button.disabled = true;
        button.classList.add("opacity-80", "pointer-events-none");
        button.innerHTML = `<span class="inline-flex items-center justify-center gap-2">${spinnerMarkup("sm", "border-t-white")}<span>${loadingText}</span></span>`;

        return;
    }

    button.disabled = false;
    button.classList.remove("opacity-80", "pointer-events-none");

    if (button.dataset.originalHtml) {
        button.innerHTML = button.dataset.originalHtml;
    }
}

export function showCrudOverlay(message = "Processing...") {
    const overlay = document.getElementById("crud-loading-overlay");

    if (!overlay) {
        return;
    }

    const messageEl = overlay.querySelector("[data-crud-overlay-message]");

    if (messageEl) {
        messageEl.textContent = message;
    }

    overlay.classList.remove("hidden");
    overlay.classList.add("flex");
    document.body.style.overflow = "hidden";
}

export function getFormSubmitButtons(form) {
    const buttons = new Set();

    form.querySelectorAll('button[type="submit"]').forEach((button) => {
        buttons.add(button);
    });

    if (form.id) {
        document
            .querySelectorAll(`button[type="submit"][form="${form.id}"]`)
            .forEach((button) => {
                buttons.add(button);
            });
    }

    return [...buttons];
}

export function bindCrudFormLoading(form, options = {}) {
    if (!form || form.dataset.crudLoadingBound === "true") {
        return;
    }

    form.dataset.crudLoadingBound = "true";

    const {
        savingText = "Saving...",
        updatingText = "Updating...",
        methodInputSelector = 'input[name="_method"]',
    } = options;

    form.addEventListener("submit", () => {
        const methodInput = form.querySelector(methodInputSelector);
        const method = methodInput?.value?.toUpperCase() ?? "POST";
        const isUpdate = method === "PUT" || method === "PATCH";
        const loadingText = isUpdate ? updatingText : savingText;

        getFormSubmitButtons(form).forEach((button) => {
            setButtonLoading(button, true, loadingText);
        });

        showCrudOverlay(loadingText);
    });
}

export function hideCrudOverlay() {
    const overlay = document.getElementById("crud-loading-overlay");

    if (!overlay) {
        return;
    }

    overlay.classList.add("hidden");
    overlay.classList.remove("flex");
    document.body.style.overflow = "";
}
