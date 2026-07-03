import { slugify } from "./portofolio.service";
import { openDialog } from "./hooks/dialog";
import { bindCrudFormLoading, setButtonLoading } from "./hooks/spiner";

function initCategoryIdSlugify(dialogId) {
    const titleInput = document.getElementById(`${dialogId}-title-input`);
    const categoryIdInput = document.getElementById(
        `${dialogId}-category-id-input`,
    );

    if (!titleInput || !categoryIdInput) {
        return;
    }

    let categoryIdTouched = Boolean(categoryIdInput.value);

    categoryIdInput.addEventListener("input", () => {
        categoryIdTouched = true;
    });

    titleInput.addEventListener("input", () => {
        if (!categoryIdTouched) {
            categoryIdInput.value = slugify(titleInput.value);
        }
    });
}

function resetCategoryForm(form, dialog, mode = "create") {
    const titleEl = dialog.querySelector("[data-dialog-title]");
    const methodInput = form.querySelector("[data-category-method]");
    const submitBtn = form.querySelector("[data-category-submit]");
    const titleInput = document.getElementById(`${dialog.id}-title-input`);
    const categoryIdInput = document.getElementById(
        `${dialog.id}-category-id-input`,
    );

    form.reset();
    form.action = form.dataset.storeRoute;
    methodInput.value = "POST";

    if (titleEl) {
        titleEl.textContent =
            mode === "edit" ? "Edit Category" : "New Category";
    }

    if (submitBtn) {
        setButtonLoading(submitBtn, false);
        submitBtn.textContent =
            mode === "edit" ? "Update Category" : "Save Category";
    }

    if (titleInput) {
        titleInput.value = "";
    }

    if (categoryIdInput) {
        categoryIdInput.value = "";
    }
}

function openCategoryDialog(dialogId, trigger) {
    const dialog = document.getElementById(dialogId);
    const form = document.getElementById(`${dialogId}-form`);

    if (!dialog || !form) {
        return;
    }

    const mode = trigger.dataset.categoryMode ?? "create";
    resetCategoryForm(form, dialog, mode);

    if (mode === "edit") {
        const titleInput = document.getElementById(`${dialogId}-title-input`);
        const categoryIdInput = document.getElementById(
            `${dialogId}-category-id-input`,
        );
        const methodInput = form.querySelector("[data-category-method]");
        const titleEl = dialog.querySelector("[data-dialog-title]");
        const submitBtn = form.querySelector("[data-category-submit]");

        form.action = trigger.dataset.categoryUpdateUrl;
        methodInput.value = "PUT";

        if (titleEl) {
            titleEl.textContent = "Edit Category";
        }

        if (submitBtn) {
            submitBtn.textContent = "Update Category";
        }

        if (titleInput) {
            titleInput.value = trigger.dataset.categoryTitle ?? "";
        }

        if (categoryIdInput) {
            categoryIdInput.value = trigger.dataset.categorySlug ?? "";
        }
    }

    openDialog(dialog);
}

export function initCategoryDialog(dialogId) {
    const form = document.getElementById(`${dialogId}-form`);

    if (form) {
        bindCrudFormLoading(form, {
            savingText: "Saving category...",
            updatingText: "Updating category...",
        });
    }

    initCategoryIdSlugify(dialogId);

    document
        .querySelectorAll(`[data-category-open="${dialogId}"]`)
        .forEach((trigger) => {
            trigger.addEventListener("click", () => {
                openCategoryDialog(dialogId, trigger);
            });
        });
}
