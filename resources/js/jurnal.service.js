import { initSlugify, initUpload } from "./portofolio.service";
import { bindCrudFormLoading } from "./hooks/spiner";

export function initJurnalForm() {
    document.querySelectorAll("[data-upload-root]").forEach(initUpload);
    initSlugify();

    const form = document.getElementById("jurnal-form");

    if (form) {
        bindCrudFormLoading(form, {
            savingText: "Saving article...",
            updatingText: "Updating article...",
        });
    }

    if (typeof window.initializeAllQuillEditors === "function") {
        window.initializeAllQuillEditors();
    }
}
