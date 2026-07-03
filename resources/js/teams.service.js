import { initRepeatableList, initUpload } from "./portofolio.service";
import { bindCrudFormLoading } from "./spiner.service";

export function initTeamForm() {
    document.querySelectorAll("[data-upload-root]").forEach(initUpload);

    initRepeatableList({
        listId: "social-media-list",
        templateId: "social-media-template",
        addButtonId: "add-social-media",
        itemSelector: "[data-social-media-item]",
        removeSelector: "[data-remove-social-media]",
        labelSelector: ".social-media-label",
        labelPrefix: "Link",
        fields: [
            { key: "type", namePrefix: "social_media" },
            { key: "label", namePrefix: "social_media" },
            { key: "link", namePrefix: "social_media" },
        ],
    });

    const form = document.getElementById("team-form");

    if (form) {
        bindCrudFormLoading(form, {
            savingText: "Saving team member...",
            updatingText: "Updating team member...",
        });
    }
}
