import { openDialog } from "./hooks/dialog";
import { bindCrudFormLoading, setButtonLoading } from "./hooks/spiner";
import { initUpload } from "./portofolio.service";

function resetUploadPreview(inputId, imageUrl = "") {
    const input = document.getElementById(inputId);
    const previewArea = document.getElementById(inputId + "-preview");
    const dropzone = document.getElementById(inputId + "-dropzone");

    if (!input || !previewArea || !dropzone) {
        return;
    }

    input.value = "";

    if (imageUrl) {
        dropzone.classList.add("hidden");
        previewArea.classList.remove("hidden");
        previewArea.replaceChildren();

        const wrapper = document.createElement("div");
        const uploadRoot = previewArea.closest("[data-upload-root]");
        const previewStyle =
            uploadRoot?.dataset.uploadPreviewStyle ??
            "height: min(300px, 42vh); width: 100%;";
        wrapper.className =
            "relative overflow-hidden border border-white/10 group rounded-3xl";
        wrapper.style.cssText = previewStyle;

        const img = document.createElement("img");
        img.src = imageUrl;
        img.alt = "Current image";
        img.className = "w-full h-full object-cover";

        const changeBtn = document.createElement("button");
        changeBtn.type = "button";
        changeBtn.dataset.uploadChange = "";
        changeBtn.className =
            "absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest";
        changeBtn.innerHTML =
            '<iconify-icon icon="lucide:refresh-cw"></iconify-icon> Change image';

        wrapper.append(img, changeBtn);
        previewArea.append(wrapper);

        return;
    }

    dropzone.classList.remove("hidden");
    previewArea.classList.add("hidden");
    previewArea.innerHTML = "";
}

function resetGalleryForm(form, dialog, mode = "create") {
    const titleEl = dialog.querySelector("[data-dialog-title]");
    const methodInput = form.querySelector("[data-gallery-method]");
    const modeField = form.querySelector("[data-gallery-mode-field]");
    const updateUrlField = form.querySelector("[data-gallery-update-url-field]");
    const imageUrlField = form.querySelector("[data-gallery-image-url-field]");
    const submitBtn = form.querySelector("[data-gallery-submit]");
    const titleInput = document.getElementById(dialog.id + "-title-input");
    const imageInputId = dialog.id + "-image-input";

    form.reset();
    form.action = form.dataset.storeRoute;
    methodInput.value = "POST";
    modeField.value = mode;
    updateUrlField.value = "";
    imageUrlField.value = "";

    if (titleEl) {
        titleEl.textContent =
            mode === "edit" ? "Edit Gallery Item" : "Add Gallery Item";
    }

    if (submitBtn) {
        setButtonLoading(submitBtn, false);
        submitBtn.textContent =
            mode === "edit" ? "Update Gallery Item" : "Save Gallery Item";
    }

    if (titleInput) {
        titleInput.value = "";
    }

    resetUploadPreview(imageInputId);
}

function openGalleryDialog(dialogId, trigger) {
    const dialog = document.getElementById(dialogId);
    const form = document.getElementById(dialogId + "-form");

    if (!dialog || !form) {
        return;
    }

    const mode = trigger.dataset.galleryMode ?? "create";
    resetGalleryForm(form, dialog, mode);

    if (mode === "edit") {
        const methodInput = form.querySelector("[data-gallery-method]");
        const modeField = form.querySelector("[data-gallery-mode-field]");
        const updateUrlField = form.querySelector(
            "[data-gallery-update-url-field]",
        );
        const imageUrlField = form.querySelector(
            "[data-gallery-image-url-field]",
        );
        const titleEl = dialog.querySelector("[data-dialog-title]");
        const submitBtn = form.querySelector("[data-gallery-submit]");
        const titleInput = document.getElementById(dialogId + "-title-input");
        const imageInputId = dialogId + "-image-input";
        const imageUrl = trigger.dataset.galleryImageUrl ?? "";

        form.action = trigger.dataset.galleryUpdateUrl;
        methodInput.value = "PUT";
        modeField.value = "edit";
        updateUrlField.value = trigger.dataset.galleryUpdateUrl ?? "";
        imageUrlField.value = imageUrl;

        if (titleEl) {
            titleEl.textContent = "Edit Gallery Item";
        }

        if (submitBtn) {
            submitBtn.textContent = "Update Gallery Item";
        }

        if (titleInput) {
            titleInput.value = trigger.dataset.galleryTitle ?? "";
        }

        resetUploadPreview(imageInputId, imageUrl);
    }

    openDialog(dialog);
}

export function initGalleryDialog(dialogId) {
    const form = document.getElementById(dialogId + "-form");
    const uploadRoot = form ? form.querySelector("[data-upload-root]") : null;

    if (uploadRoot) {
        initUpload(uploadRoot);
    }

    if (form) {
        bindCrudFormLoading(form, {
            savingText: "Saving...",
            updatingText: "Updating...",
        });
    }

    document
        .querySelectorAll('[data-gallery-open="' + dialogId + '"]')
        .forEach((trigger) => {
            trigger.addEventListener("click", () => {
                openGalleryDialog(dialogId, trigger);
            });
        });

    if (form && form.dataset.autoOpen === "true") {
        const dialog = document.getElementById(dialogId);
        const mode = form.dataset.initialMode ?? "create";

        if (mode === "edit") {
            const methodInput = form.querySelector("[data-gallery-method]");
            const modeField = form.querySelector("[data-gallery-mode-field]");
            const updateUrlField = form.querySelector(
                "[data-gallery-update-url-field]",
            );
            const imageUrlField = form.querySelector(
                "[data-gallery-image-url-field]",
            );
            const titleEl = dialog?.querySelector("[data-dialog-title]");
            const submitBtn = form.querySelector("[data-gallery-submit]");

            form.action = form.dataset.initialUpdateUrl || updateUrlField?.value || form.dataset.storeRoute;
            if (methodInput) {
                methodInput.value = "PUT";
            }
            if (modeField) {
                modeField.value = "edit";
            }
            if (titleEl) {
                titleEl.textContent = "Edit Gallery Item";
            }
            if (submitBtn) {
                submitBtn.textContent = "Update Gallery Item";
            }

            const imageUrl = form.dataset.initialImageUrl || imageUrlField?.value || "";
            if (imageUrl) {
                resetUploadPreview(dialogId + "-image-input", imageUrl);
            }
        }

        if (dialog) {
            openDialog(dialog);
        }

        return;
    }
}
