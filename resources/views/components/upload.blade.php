@props([
    'name',
    'label' => null,
    'accept' => 'image/*',
    'multiple' => false,
    'preview' => null,
    'hint' => null,
    'previewAspect' => '21/9',
])

@php
    $inputId = $attributes->get('id', str_replace(['[', ']'], '', $name));
    $previewId = $inputId.'-preview';
    $dropzoneId = $inputId.'-dropzone';
    $hasPreview = filled($preview);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'space-y-2']) }} data-upload-root data-upload-mode="{{ $multiple ? 'gallery' : 'single' }}">
    @if ($label)
        <p class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">
            {{ $label }}
        </p>
    @endif

    @if ($multiple)
        {{-- Gallery: dropzone always visible as add tile, files accumulate one-by-one --}}
        <div id="{{ $previewId }}" class="grid grid-cols-3 gap-2" data-gallery-grid>
            <label
                id="{{ $dropzoneId }}"
                for="{{ $inputId }}"
                data-upload-dropzone
                class="relative aspect-square rounded-xl overflow-hidden border border-dashed border-white/20 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-white/40 hover:bg-white/[0.02] transition-colors"
            >
                <iconify-icon icon="lucide:plus" class="text-2xl opacity-30"></iconify-icon>
                <span class="text-[9px] font-bold uppercase tracking-widest opacity-40 text-center px-2">Add image</span>
                <input
                    type="file"
                    name="{{ $name }}"
                    id="{{ $inputId }}"
                    accept="{{ $accept }}"
                    class="sr-only"
                    data-upload-input
                    data-preview-id="{{ $previewId }}"
                    data-dropzone-id="{{ $dropzoneId }}"
                    data-upload-multiple="true"
                >
            </label>
        </div>
    @else
        {{-- Single: hide dropzone when preview exists --}}
        <div
            id="{{ $previewId }}"
            @class(['hidden' => ! $hasPreview])
        >
            @if ($hasPreview)
                <div class="relative rounded-[1.25rem] overflow-hidden border border-white/10 aspect-[21/9] group">
                    <img src="{{ $preview }}" alt="Preview" class="w-full h-full object-cover">
                    <button
                        type="button"
                        data-upload-change
                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest"
                    >
                        <iconify-icon icon="lucide:refresh-cw"></iconify-icon>
                        Change image
                    </button>
                </div>
            @endif
        </div>

        <label
            id="{{ $dropzoneId }}"
            for="{{ $inputId }}"
            data-upload-dropzone
            @class([
                'flex flex-col items-center justify-center gap-3 p-8 glass rounded-[1.25rem] border-dashed border-white/10 cursor-pointer hover:border-white/20 transition-colors',
                'hidden' => $hasPreview,
            ])
        >
            <iconify-icon icon="lucide:upload-cloud" class="text-3xl opacity-30"></iconify-icon>
            <span class="text-xs opacity-40 font-medium">Click to upload image</span>
            <input
                type="file"
                name="{{ $name }}"
                id="{{ $inputId }}"
                accept="{{ $accept }}"
                class="sr-only"
                data-upload-input
                data-preview-id="{{ $previewId }}"
                data-dropzone-id="{{ $dropzoneId }}"
                data-upload-multiple="false"
            >
        </label>
    @endif

    @if ($hint)
        <p class="text-[10px] text-[#f5f2ed]/30 px-1">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="text-xs text-red-400 px-1">{{ $message }}</p>
    @enderror
    @error($name . '.*')
        <p class="text-xs text-red-400 px-1">{{ $message }}</p>
    @enderror
</div>

<script>
    (function () {
        const input = document.getElementById(@json($inputId));
        const previewArea = document.getElementById(@json($previewId));
        const dropzone = document.getElementById(@json($dropzoneId));
        const root = input?.closest('[data-upload-root]');

        if (!input || !previewArea || !dropzone || !root) {
            return;
        }

        const isGallery = root.dataset.uploadMode === 'gallery';

        if (isGallery) {
            const fileStore = [];

            const syncInputFiles = () => {
                const dataTransfer = new DataTransfer();
                fileStore.forEach((file) => dataTransfer.items.add(file));
                input.files = dataTransfer.files;
            };

            const renderGalleryPreviews = () => {
                previewArea.querySelectorAll('[data-pending-preview]').forEach((el) => el.remove());

                fileStore.forEach((file, index) => {
                    const item = document.createElement('div');
                    item.className = 'relative aspect-square rounded-xl overflow-hidden border border-white/10 group';
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

            input.addEventListener('change', function () {
                if (!this.files?.length) {
                    return;
                }

                Array.from(this.files).forEach((file) => {
                    if (file.type.startsWith('image/')) {
                        fileStore.push(file);
                    }
                });

                syncInputFiles();
                renderGalleryPreviews();
                this.value = '';
            });

            previewArea.addEventListener('click', (event) => {
                const removeBtn = event.target.closest('[data-remove-pending]');

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

            return;
        }

        const showDropzone = () => {
            dropzone.classList.remove('hidden');
            previewArea.classList.add('hidden');
            previewArea.innerHTML = '';
            input.value = '';
        };

        const hideDropzone = () => {
            dropzone.classList.add('hidden');
            previewArea.classList.remove('hidden');
        };

        root.addEventListener('click', (event) => {
            if (event.target.closest('[data-upload-change]')) {
                showDropzone();
            }
        });

        input.addEventListener('change', function () {
            const file = this.files?.[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                showDropzone();
                return;
            }

            hideDropzone();

            const reader = new FileReader();
            reader.onload = (event) => {
                previewArea.innerHTML = `
                    <div class="relative rounded-[1.25rem] overflow-hidden border border-white/10 aspect-[21/9] group">
                        <img src="${event.target.result}" alt="${file.name}" class="w-full h-full object-cover">
                        <button type="button" data-upload-change class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-widest">
                            <iconify-icon icon="lucide:refresh-cw"></iconify-icon>
                            Change image
                        </button>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        });
    })();
</script>
