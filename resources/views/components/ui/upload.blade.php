@props([
    'name',
    'label' => null,
    'accept' => 'image/*,.heic,.heif,.avif,.jpg,.jpeg,.png,.gif,.webp,.bmp,.svg,.tiff,.tif,.ico,.jfif,.jxl,.apng',
    'multiple' => false,
    'preview' => null,
    'hint' => null,
    'previewAspect' => '21/9',
])

@php
    $inputId = $attributes->get('id', str_replace(['[', ']'], '', $name));
    $previewId = $inputId.'-preview';
    $dropzoneId = $inputId.'-dropzone';
    $pickerId = $inputId.'-picker';
    $storeId = $inputId.'-store';
    $hasPreview = filled($preview);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'relative space-y-2']) }} data-upload-root data-upload-mode="{{ $multiple ? 'gallery' : 'single' }}" data-upload-input-id="{{ $inputId }}">
    @if ($label)
        <p class="text-[10px] uppercase tracking-widest font-bold opacity-40 px-1">
            {{ $label }}
        </p>
    @endif

    @if ($multiple)
        <input
            type="file"
            id="{{ $storeId }}"
            name="{{ $name }}"
            accept="{{ $accept }}"
            multiple
            tabindex="-1"
            class="absolute h-px w-px overflow-hidden opacity-0"
            style="clip: rect(0, 0, 0, 0); white-space: nowrap;"
            data-gallery-store
        >

        {{-- Gallery: dropzone always visible as add tile, files accumulate one-by-one --}}
        <div id="{{ $previewId }}" class="grid grid-cols-3 gap-2" data-gallery-grid>
            <div
                id="{{ $dropzoneId }}"
                data-upload-dropzone
                class="relative aspect-square rounded-xl overflow-hidden border border-dashed border-white/20 flex flex-col items-center justify-center gap-2 cursor-pointer hover:border-white/40 hover:bg-white/[0.02] transition-colors"
            >
                <input
                    type="file"
                    id="{{ $pickerId }}"
                    accept="{{ $accept }}"
                    class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0"
                    data-gallery-picker
                    data-preview-id="{{ $previewId }}"
                    data-dropzone-id="{{ $dropzoneId }}"
                >
                <div class="pointer-events-none flex flex-col items-center justify-center gap-2">
                    <iconify-icon icon="lucide:plus" class="text-2xl opacity-30"></iconify-icon>
                    <span class="text-[9px] font-bold uppercase tracking-widest opacity-40 text-center px-2">Add image</span>
                </div>
            </div>
        </div>
    @else
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $inputId }}"
            accept="{{ $accept }}"
            tabindex="-1"
            class="absolute h-px w-px overflow-hidden opacity-0"
            style="clip: rect(0, 0, 0, 0); white-space: nowrap;"
            data-upload-input
            data-preview-id="{{ $previewId }}"
            data-dropzone-id="{{ $dropzoneId }}"
            data-upload-multiple="false"
        >

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

        <div
            id="{{ $dropzoneId }}"
            data-upload-dropzone
            @class([
                'relative flex flex-col items-center justify-center gap-3 p-8 glass rounded-[1.25rem] border-dashed border-white/10 cursor-pointer hover:border-white/20 transition-colors overflow-hidden',
                'hidden' => $hasPreview,
            ])
        >
            <label for="{{ $inputId }}" class="absolute inset-0 z-10 cursor-pointer" aria-label="Upload image"></label>
            <div class="pointer-events-none flex flex-col items-center justify-center gap-3">
                <iconify-icon icon="lucide:upload-cloud" class="text-3xl opacity-30"></iconify-icon>
                <span class="text-xs opacity-40 font-medium">Click to upload image</span>
            </div>
        </div>
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
