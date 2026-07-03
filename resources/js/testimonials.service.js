import { openDialog } from "./dialog.service";
import { bindCrudFormLoading, setButtonLoading } from "./spiner.service";

function resetTestimonialForm(form, dialog, mode = "create") {
    const titleEl = dialog.querySelector("[data-dialog-title]");
    const methodInput = form.querySelector("[data-testimonial-method]");
    const modeField = form.querySelector("[data-testimonial-mode-field]");
    const updateUrlField = form.querySelector(
        "[data-testimonial-update-url-field]",
    );
    const submitBtn = form.querySelector("[data-testimonial-submit]");
    const fields = {
        name: document.getElementById(`${dialog.id}-name-input`),
        jobs: document.getElementById(`${dialog.id}-jobs-input`),
        company: document.getElementById(`${dialog.id}-company-input`),
        message: document.getElementById(`${dialog.id}-message-input`),
    };

    form.reset();
    form.action = form.dataset.storeRoute;
    methodInput.value = "POST";
    modeField.value = mode;
    updateUrlField.value = "";

    if (titleEl) {
        titleEl.textContent =
            mode === "edit" ? "Edit Testimonial" : "Add Testimonial";
    }

    if (submitBtn) {
        setButtonLoading(submitBtn, false);
        submitBtn.textContent =
            mode === "edit" ? "Update Testimonial" : "Save Testimonial";
    }

    Object.values(fields).forEach((field) => {
        if (field) {
            field.value = "";
        }
    });
}

function openTestimonialDialog(dialogId, trigger) {
    const dialog = document.getElementById(dialogId);
    const form = document.getElementById(`${dialogId}-form`);

    if (!dialog || !form) {
        return;
    }

    const mode = trigger.dataset.testimonialMode ?? "create";
    resetTestimonialForm(form, dialog, mode);

    if (mode === "edit") {
        const methodInput = form.querySelector("[data-testimonial-method]");
        const modeField = form.querySelector("[data-testimonial-mode-field]");
        const updateUrlField = form.querySelector(
            "[data-testimonial-update-url-field]",
        );
        const titleEl = dialog.querySelector("[data-dialog-title]");
        const submitBtn = form.querySelector("[data-testimonial-submit]");
        const nameInput = document.getElementById(`${dialogId}-name-input`);
        const jobsInput = document.getElementById(`${dialogId}-jobs-input`);
        const companyInput = document.getElementById(
            `${dialogId}-company-input`,
        );
        const messageInput = document.getElementById(
            `${dialogId}-message-input`,
        );

        form.action = trigger.dataset.testimonialUpdateUrl;
        methodInput.value = "PUT";
        modeField.value = "edit";
        updateUrlField.value = trigger.dataset.testimonialUpdateUrl ?? "";

        if (titleEl) {
            titleEl.textContent = "Edit Testimonial";
        }

        if (submitBtn) {
            submitBtn.textContent = "Update Testimonial";
        }

        if (nameInput) {
            nameInput.value = trigger.dataset.testimonialName ?? "";
        }

        if (jobsInput) {
            jobsInput.value = trigger.dataset.testimonialJobs ?? "";
        }

        if (companyInput) {
            companyInput.value = trigger.dataset.testimonialCompany ?? "";
        }

        if (messageInput) {
            messageInput.value = trigger.dataset.testimonialMessage ?? "";
        }
    }

    openDialog(dialog);
}

export function initTestimonialsDialog(dialogId) {
    const form = document.getElementById(`${dialogId}-form`);

    if (form) {
        bindCrudFormLoading(form, {
            savingText: "Saving...",
            updatingText: "Updating...",
        });
    }

    document
        .querySelectorAll(`[data-testimonial-open="${dialogId}"]`)
        .forEach((trigger) => {
            trigger.addEventListener("click", () => {
                openTestimonialDialog(dialogId, trigger);
            });
        });

    if (form?.dataset.autoOpen === "true") {
        openTestimonialDialog(dialogId, {
            dataset: {
                testimonialMode: form.dataset.initialMode ?? "create",
                testimonialUpdateUrl: form.dataset.initialUpdateUrl ?? "",
            },
        });
    }
}
