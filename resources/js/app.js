import { initAlertDialogs } from "./alert-dialog.service";
import { initCategoryDialog } from "./category.service";
import { initDialogs } from "./dialog.service";
import { initJurnalForm } from "./jurnal.service";
import { initPortfolioForm } from "./portofolio.service";
import { initPageSkeletons } from "./skeleton.service";
import { initTeamForm } from "./teams.service";
import { initFeaturesDialog } from "./features.blade.js";
import { initTestimonialsDialog } from "./testimonials.service";

document.addEventListener("DOMContentLoaded", () => {
    initPageSkeletons();
    initAlertDialogs();
    initDialogs();

    document.querySelectorAll("[data-category-form]").forEach((form) => {
        initCategoryDialog(form.id.replace("-form", ""));
    });

    document.querySelectorAll("[data-testimonial-form]").forEach((form) => {
        initTestimonialsDialog(form.id.replace("-form", ""));
    });

    document.querySelectorAll("[data-feature-form]").forEach((form) => {
        initFeaturesDialog(form.id.replace("-form", ""));
    });

    if (document.getElementById("portfolio-form")) {
        initPortfolioForm();
    }

    if (document.getElementById("jurnal-form")) {
        initJurnalForm();
    }

    if (document.getElementById("team-form")) {
        initTeamForm();
    }
});
