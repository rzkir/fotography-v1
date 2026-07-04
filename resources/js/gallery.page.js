import { openDialog } from "./hooks/dialog";

function showGalleryPreviewItem(dialog, items, index) {
    const item = items[index];

    if (!item) {
        return;
    }

    const image = dialog.querySelector("[data-gallery-preview-image]");
    const title = dialog.querySelector("[data-gallery-preview-title]");
    const date = dialog.querySelector("[data-gallery-preview-date]");
    const counter = dialog.querySelector("[data-gallery-preview-counter]");
    const titleHeader = dialog.querySelector("[data-dialog-title]");
    const prevBtn = dialog.querySelector("[data-gallery-preview-prev]");
    const nextBtn = dialog.querySelector("[data-gallery-preview-next]");

    const itemTitle = item.dataset.galleryTitle ?? "";
    const itemDate = item.dataset.galleryDate ?? "";

    if (image) {
        image.src = item.dataset.galleryImageUrl ?? "";
        image.alt = itemTitle;
    }

    if (title) {
        title.textContent = itemTitle;
    }

    if (titleHeader) {
        titleHeader.textContent = itemTitle;
    }

    if (date) {
        date.textContent = itemDate;
    }

    if (counter) {
        counter.textContent = `${index + 1} / ${items.length}`;
    }

    if (prevBtn) {
        prevBtn.disabled = index <= 0;
    }

    if (nextBtn) {
        nextBtn.disabled = index >= items.length - 1;
    }

    dialog.dataset.galleryPreviewIndex = String(index);
}

export function initGalleryPage() {
    const page = document.querySelector("[data-gallery-index]");

    if (!page) {
        return;
    }

    const dialog = document.getElementById("gallery-preview-dialog");

    if (!dialog) {
        return;
    }

    const items = Array.from(page.querySelectorAll("[data-gallery-item]"));

    if (items.length === 0) {
        return;
    }

    const prevBtn = dialog.querySelector("[data-gallery-preview-prev]");
    const nextBtn = dialog.querySelector("[data-gallery-preview-next]");

    const openAt = (index) => {
        showGalleryPreviewItem(dialog, items, index);
        openDialog(dialog);
    };

    page.addEventListener("click", (event) => {
        const item = event.target.closest("[data-gallery-item]");

        if (!item || !page.contains(item)) {
            return;
        }

        openAt(items.indexOf(item));
    });

    page.addEventListener("keydown", (event) => {
        if (event.key !== "Enter" && event.key !== " ") {
            return;
        }

        const item = event.target.closest("[data-gallery-item]");

        if (!item || !page.contains(item)) {
            return;
        }

        event.preventDefault();
        openAt(items.indexOf(item));
    });

    prevBtn?.addEventListener("click", () => {
        const currentIndex = Number(dialog.dataset.galleryPreviewIndex ?? 0);

        showGalleryPreviewItem(dialog, items, currentIndex - 1);
    });

    nextBtn?.addEventListener("click", () => {
        const currentIndex = Number(dialog.dataset.galleryPreviewIndex ?? 0);

        showGalleryPreviewItem(dialog, items, currentIndex + 1);
    });

    document.addEventListener("keydown", (event) => {
        if (dialog.classList.contains("hidden")) {
            return;
        }

        const currentIndex = Number(dialog.dataset.galleryPreviewIndex ?? 0);

        if (event.key === "ArrowLeft") {
            showGalleryPreviewItem(dialog, items, currentIndex - 1);
        }

        if (event.key === "ArrowRight") {
            showGalleryPreviewItem(dialog, items, currentIndex + 1);
        }
    });
}
