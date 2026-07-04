import { initAlertDialogs } from "./hooks/alert-dialog";
import { initAnimations } from "./hooks/animation";
import { initSiteHeader } from "./hooks/site-header";
import { initSplashScreen } from "./hooks/splash-screen";
import { initCategoryDialog } from "./category.service";
import { initDialogs } from "./hooks/dialog";
import { initPaginationRoots } from "./hooks/pagination";
import { initJournalIndex } from "./journal.page";
import { initJurnalForm } from "./jurnal.service";
import { initPortfolioForm } from "./portofolio.service";
import { initPageSkeletons } from "./hooks/skeleton";
import { initTeamForm } from "./teams.service";
import { initFeaturesDialog } from "./features.blade.js";
import { initTestimonialsDialog } from "./testimonials.service";
import { initLegalNav } from "./hooks/legal-nav";
import { initHomePage, initWorksDetail } from "./home.page";
import { initWorksIndex } from "./works.page";

document.addEventListener("DOMContentLoaded", () => {
    initAnimations();
    initSplashScreen();
    initSiteHeader();
    initPageSkeletons();
    initAlertDialogs();
    initDialogs();
    initPaginationRoots();

    if (document.querySelector("[data-legal-page]")) {
        initLegalNav();
    }

    if (document.querySelector("[data-journal-index]")) {
        initJournalIndex();
    }

    if (document.querySelector("[data-works-index]")) {
        initWorksIndex();
    }

    if (document.querySelector("[data-works-detail]")) {
        initWorksDetail();
    }

    if (document.querySelector("[data-home-page]")) {
        initHomePage();
    }

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
