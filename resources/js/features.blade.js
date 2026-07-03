import { openDialog } from "./hooks/dialog";
import { bindCrudFormLoading, setButtonLoading } from "./hooks/spiner";

function resetFeatureForm(form, dialog, mode = "create") {
    const titleEl = dialog.querySelector("[data-dialog-title]");
    const methodInput = form.querySelector("[data-feature-method]");
    const modeField = form.querySelector("[data-feature-mode-field]");
    const updateUrlField = form.querySelector("[data-feature-update-url-field]");
    const submitBtn = form.querySelector("[data-feature-submit]");
    const numberInput = document.getElementById(`${dialog.id}-number-input`);
    const titleInput = document.getElementById(`${dialog.id}-title-input`);

    form.reset();
    form.action = form.dataset.storeRoute;
    methodInput.value = "POST";
    modeField.value = mode;
    updateUrlField.value = "";

    if (titleEl) {
        titleEl.textContent = mode === "edit" ? "Edit Feature" : "Add Feature";
    }

    if (submitBtn) {
        setButtonLoading(submitBtn, false);
        submitBtn.textContent =
            mode === "edit" ? "Update Feature" : "Save Feature";
    }

    if (numberInput) {
        numberInput.value = "";
    }

    if (titleInput) {
        titleInput.value = "";
    }
}

function openFeatureDialog(dialogId, trigger) {
    const dialog = document.getElementById(dialogId);
    const form = document.getElementById(`${dialogId}-form`);

    if (!dialog || !form) {
        return;
    }

    const mode = trigger.dataset.featureMode ?? "create";
    resetFeatureForm(form, dialog, mode);

    if (mode === "edit") {
        const methodInput = form.querySelector("[data-feature-method]");
        const modeField = form.querySelector("[data-feature-mode-field]");
        const updateUrlField = form.querySelector(
            "[data-feature-update-url-field]",
        );
        const titleEl = dialog.querySelector("[data-dialog-title]");
        const submitBtn = form.querySelector("[data-feature-submit]");
        const numberInput = document.getElementById(`${dialogId}-number-input`);
        const titleInput = document.getElementById(`${dialogId}-title-input`);

        form.action = trigger.dataset.featureUpdateUrl;
        methodInput.value = "PUT";
        modeField.value = "edit";
        updateUrlField.value = trigger.dataset.featureUpdateUrl ?? "";

        if (titleEl) {
            titleEl.textContent = "Edit Feature";
        }

        if (submitBtn) {
            submitBtn.textContent = "Update Feature";
        }

        if (numberInput) {
            numberInput.value = trigger.dataset.featureNumber ?? "";
        }

        if (titleInput) {
            titleInput.value = trigger.dataset.featureTitle ?? "";
        }
    }

    openDialog(dialog);
}

export function initFeaturesDialog(dialogId) {
    const form = document.getElementById(`${dialogId}-form`);

    if (form) {
        bindCrudFormLoading(form, {
            savingText: "Saving feature...",
            updatingText: "Updating feature...",
        });
    }

    document
        .querySelectorAll(`[data-feature-open="${dialogId}"]`)
        .forEach((trigger) => {
            trigger.addEventListener("click", () => {
                openFeatureDialog(dialogId, trigger);
            });
        });

    if (form?.dataset.autoOpen === "true") {
        openFeatureDialog(dialogId, {
            dataset: {
                featureMode: form.dataset.initialMode ?? "create",
                featureUpdateUrl: form.dataset.initialUpdateUrl ?? "",
                featureNumber: form.querySelector("#feature-dialog-number-input")?.value ?? "",
                featureTitle: form.querySelector("#feature-dialog-title-input")?.value ?? "",
            },
        });
    }
}
