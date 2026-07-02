const IMAGE_EXTENSION_PATTERN =
    /\.(jpe?g|png|gif|webp|bmp|svg|heic|heif|avif|tiff?|ico|jfif|pjpeg|pjp|jxl|apng)$/i;

export function isImageFile(file) {
    if (file.type.startsWith("image/")) {
        return true;
    }

    return IMAGE_EXTENSION_PATTERN.test(file.name);
}

export function slugify(text) {
    return text
        .toLowerCase()
        .trim()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/[^a-z0-9\s-]/g, "")
        .replace(/[\s_]+/g, "-")
        .replace(/-+/g, "-")
        .replace(/^-+|-+$/g, "");
}

export function initUpload(root) {
    const inputId = root.dataset.uploadInputId;
    const isGallery = root.dataset.uploadMode === "gallery";

    if (isGallery) {
        initGalleryUpload(root, inputId);

        return;
    }

    initSingleUpload(root, inputId);
}

function initGalleryUpload(root, inputId) {
    const picker = root.querySelector("[data-gallery-picker]");
    const store = root.querySelector("[data-gallery-store]");
    const previewArea = document.getElementById(`${inputId}-preview`);
    const dropzone = document.getElementById(`${inputId}-dropzone`);

    if (!picker || !store || !previewArea || !dropzone) {
        return;
    }

    const fileStore = [];

    const syncInputFiles = () => {
        const dataTransfer = new DataTransfer();
        fileStore.forEach((file) => dataTransfer.items.add(file));
        store.files = dataTransfer.files;
    };

    const renderGalleryPreviews = () => {
        previewArea
            .querySelectorAll("[data-pending-preview]")
            .forEach((element) => element.remove());

        fileStore.forEach((file, index) => {
            const item = document.createElement("div");
            item.className =
                "relative aspect-square rounded-xl overflow-hidden border border-white/10 group";
            item.dataset.pendingPreview = String(index);
            item.innerHTML = `
                <img src="${URL.createObjectURL(file)}" alt="${file.name}" class="w-full h-full object-cover">
                <button type="button" data-remove-pending="${index}" class="absolute top-1 right-1 w-6 h-6 bg-black/60 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <iconify-icon icon="lucide:x" class="text-xs"></iconify-icon>
                </button>
                <span class="absolute bottom-1 left-1 right-1 text-[8px] px-1 py-0.5 bg-black/60 rounded truncate opacity-0 group-hover:opacity-100 transition-opacity">${file.name}</span>
            `;
            previewArea.insertBefore(item, dropzone);
        });
    };

    picker.addEventListener("change", function () {
        if (!this.files?.length) {
            return;
        }

        Array.from(this.files).forEach((file) => {
            if (isImageFile(file)) {
                fileStore.push(file);
            }
        });

        syncInputFiles();
        renderGalleryPreviews();
        this.value = "";
    });

    previewArea.addEventListener("click", (event) => {
        const removeBtn = event.target.closest("[data-remove-pending]");

        if (!removeBtn) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const index = parseInt(removeBtn.dataset.removePending, 10);
        fileStore.splice(index, 1);
        syncInputFiles();
        renderGalleryPreviews();
    });

    const form = root.closest("form");
    if (form) {
        form.addEventListener("submit", () => {
            syncInputFiles();
        });
    }
}

function initSingleUpload(root, inputId) {
    const input = document.getElementById(inputId);
    const previewArea = document.getElementById(`${inputId}-preview`);
    const dropzone = document.getElementById(`${inputId}-dropzone`);

    if (!input || !previewArea || !dropzone) {
        return;
    }

    const showDropzone = () => {
        dropzone.classList.remove("hidden");
        previewArea.classList.add("hidden");
        previewArea.innerHTML = "";
        input.value = "";
    };

    const hideDropzone = () => {
        dropzone.classList.add("hidden");
        previewArea.classList.remove("hidden");
    };

    root.addEventListener("click", (event) => {
        if (event.target.closest("[data-upload-change]")) {
            showDropzone();
        }
    });

    input.addEventListener("change", function () {
        const file = this.files?.[0];

        if (!file) {
            return;
        }

        if (!isImageFile(file)) {
            showDropzone();

            return;
        }

        hideDropzone();

        const reader = new FileReader();
        reader.onload = (loadEvent) => {
            previewArea.innerHTML = `
                <div class="relative rounded-[1.25rem] overflow-hidden border border-white/10 aspect-21/9 group">
                    <img src="${loadEvent.target.result}" alt="${file.name}" class="w-full h-full object-cover">
                    <button type="button" data-upload-change class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest">
                        <iconify-icon icon="lucide:refresh-cw"></iconify-icon>
                        Change image
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    });
}

export function initSlugify() {
    const titleInput = document.getElementById("title");
    const slugInput = document.getElementById("slug");

    if (!titleInput || !slugInput) {
        return;
    }

    let slugTouched = Boolean(slugInput.value);

    slugInput.addEventListener("input", () => {
        slugTouched = true;
    });

    titleInput.addEventListener("input", () => {
        if (!slugTouched) {
            slugInput.value = slugify(titleInput.value);
        }
    });
}

export function initRepeatableList({
    listId,
    templateId,
    addButtonId,
    itemSelector,
    removeSelector,
    labelSelector,
    labelPrefix,
    fields,
}) {
    const list = document.getElementById(listId);
    const template = document.getElementById(templateId);
    const addButton = document.getElementById(addButtonId);

    if (!list || !template || !addButton) {
        return;
    }

    const reindexItems = () => {
        const items = list.querySelectorAll(itemSelector);

        items.forEach((item, index) => {
            const label = item.querySelector(labelSelector);
            if (label) {
                label.textContent = `${labelPrefix} ${index + 1}`;
            }

            fields.forEach(({ key, namePrefix }) => {
                const field =
                    item.querySelector(`[data-field="${key}"]`) ||
                    item.querySelector(`[name*="[${key}]"]`);

                if (field) {
                    field.name = `${namePrefix}[${index}][${key}]`;
                }
            });

            const removeBtn = item.querySelector(removeSelector);
            if (removeBtn) {
                removeBtn.classList.toggle("hidden", items.length === 1);
            }
        });
    };

    addButton.addEventListener("click", () => {
        const clone = template.content.cloneNode(true);
        list.appendChild(clone);
        reindexItems();
    });

    list.addEventListener("click", (event) => {
        const removeBtn = event.target.closest(removeSelector);

        if (!removeBtn) {
            return;
        }

        const items = list.querySelectorAll(itemSelector);

        if (items.length <= 1) {
            return;
        }

        removeBtn.closest(itemSelector)?.remove();
        reindexItems();
    });
}

export function initSavedGalleryRemove() {
    document.querySelectorAll(".gallery-remove").forEach((button) => {
        button.addEventListener("click", () => {
            const index = parseInt(button.dataset.index, 10);
            const input = document.getElementById("existing_gallery");
            const gallery = JSON.parse(input.value || "[]");
            gallery.splice(index, 1);
            input.value = JSON.stringify(gallery);
            button.closest("[data-gallery-index]")?.remove();
        });
    });
}

export function initContributors() {
    const list = document.getElementById("contributors-list");
    const template = document.getElementById("contributor-template");
    const addButton = document.getElementById("add-contributor");

    if (!list || !template || !addButton) {
        return;
    }

    const showContributorDropzone = (item) => {
        const previewWrap = item.querySelector(
            "[data-contributor-preview-wrap]",
        );
        const dropzone = item.querySelector("[data-contributor-dropzone]");
        const existingInput = item.querySelector(
            '[data-field="existing_image"]',
        );
        const fileInput = item.querySelector("[data-contributor-image-input]");

        if (previewWrap) {
            previewWrap.classList.add("hidden");
            previewWrap.innerHTML = "";
        }

        if (dropzone) {
            dropzone.classList.remove("hidden");
        }

        if (existingInput) {
            existingInput.value = "";
        }

        if (fileInput) {
            fileInput.value = "";
        }
    };

    const showContributorPreview = (item, src, alt = "Contributor") => {
        const previewWrap = item.querySelector(
            "[data-contributor-preview-wrap]",
        );
        const dropzone = item.querySelector("[data-contributor-dropzone]");

        if (!previewWrap) {
            return;
        }

        previewWrap.innerHTML = `
            <div class="relative aspect-square rounded-xl overflow-hidden border border-white/10 group">
                <img src="${src}" alt="${alt}" class="w-full h-full object-cover" data-contributor-preview-img>
                <button type="button" data-remove-contributor-image class="absolute top-2 right-2 w-7 h-7 bg-black/60 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <iconify-icon icon="lucide:x" class="text-xs"></iconify-icon>
                </button>
            </div>
        `;
        previewWrap.classList.remove("hidden");

        if (dropzone) {
            dropzone.classList.add("hidden");
        }
    };

    const reindexContributors = () => {
        const items = list.querySelectorAll("[data-contributor-item]");

        items.forEach((item, index) => {
            const label = item.querySelector(".contributor-label");
            if (label) {
                label.textContent = `Contributor ${index + 1}`;
            }

            item.querySelectorAll("[data-field]").forEach((field) => {
                const key = field.dataset.field;

                if (key === "image") {
                    const inputId = `contributor-image-${index}`;
                    field.id = inputId;
                    field.name = `contributors[${index}][image]`;

                    const trigger = item.querySelector(
                        "[data-contributor-image-trigger]",
                    );
                    if (trigger) {
                        trigger.setAttribute("for", inputId);
                    }
                } else {
                    field.name = `contributors[${index}][${key}]`;
                }
            });

            const removeBtn = item.querySelector("[data-remove-contributor]");
            if (removeBtn) {
                removeBtn.classList.toggle("hidden", items.length === 1);
            }
        });
    };

    addButton.addEventListener("click", () => {
        const clone = template.content.cloneNode(true);
        list.appendChild(clone);
        reindexContributors();
    });

    list.addEventListener("click", (event) => {
        const removeContributorBtn = event.target.closest(
            "[data-remove-contributor]",
        );
        if (removeContributorBtn) {
            const items = list.querySelectorAll("[data-contributor-item]");

            if (items.length <= 1) {
                return;
            }

            removeContributorBtn.closest("[data-contributor-item]")?.remove();
            reindexContributors();

            return;
        }

        const removeImageBtn = event.target.closest(
            "[data-remove-contributor-image]",
        );
        if (removeImageBtn) {
            const item = removeImageBtn.closest("[data-contributor-item]");
            if (item) {
                showContributorDropzone(item);
            }
        }
    });

    list.addEventListener("change", (event) => {
        const input = event.target.closest("[data-contributor-image-input]");

        if (!input?.files?.[0]) {
            return;
        }

        const file = input.files[0];
        const item = input.closest("[data-contributor-item]");

        if (!item || !isImageFile(file)) {
            input.value = "";

            return;
        }

        const existingInput = item.querySelector(
            '[data-field="existing_image"]',
        );
        if (existingInput) {
            existingInput.value = "";
        }

        showContributorPreview(item, URL.createObjectURL(file), file.name);
    });
}

export function initPortfolioForm() {
    document.querySelectorAll("[data-upload-root]").forEach(initUpload);

    initSlugify();

    initRepeatableList({
        listId: "content-sections-list",
        templateId: "content-section-template",
        addButtonId: "add-content-section",
        itemSelector: "[data-section-item]",
        removeSelector: "[data-remove-section]",
        labelSelector: ".section-label",
        labelPrefix: "Section",
        fields: [
            { key: "title", namePrefix: "content_sections" },
            { key: "description", namePrefix: "content_sections" },
        ],
    });

    initRepeatableList({
        listId: "post-processing-list",
        templateId: "post-processing-template",
        addButtonId: "add-post-processing-step",
        itemSelector: "[data-post-processing-item]",
        removeSelector: "[data-remove-post-processing]",
        labelSelector: ".post-processing-label",
        labelPrefix: "Step",
        fields: [
            { key: "title", namePrefix: "post_processing" },
            { key: "text", namePrefix: "post_processing" },
        ],
    });

    initRepeatableList({
        listId: "timeline-list",
        templateId: "timeline-template",
        addButtonId: "add-timeline-item",
        itemSelector: "[data-timeline-item]",
        removeSelector: "[data-remove-timeline]",
        labelSelector: ".timeline-label",
        labelPrefix: "Phase",
        fields: [
            { key: "title", namePrefix: "timeline" },
            { key: "text", namePrefix: "timeline" },
        ],
    });

    initSavedGalleryRemove();
    initContributors();
}
