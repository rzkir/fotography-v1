@props([
    'name',
    'value' => '',
    'id' => null,
    'placeholder' => 'Write content here...',
])

@php
    $editorId = $id ?: 'quill-editor-'.str()->random(8);
@endphp

@once
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js" defer></script>
    <style>
        .quill-editor-shell {
            position: relative;
            min-height: 260px;
            border-radius: 1.25rem;
            overflow: hidden;
        }

        .quill-editor-shell:not([data-initialized='true']) [data-quill-root] {
            visibility: hidden;
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .quill-editor-shell:not([data-initialized='true'])::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1.25rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(245, 242, 237, 0.1);
            animation: quill-shell-pulse 1.5s ease-in-out infinite;
        }

        @keyframes quill-shell-pulse {
            0%, 100% { opacity: 0.45; }
            50% { opacity: 0.9; }
        }

        .quill-editor-shell[data-initialized='true']::before {
            display: none;
        }

        .quill-editor-shell .ql-toolbar.ql-snow {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(245, 242, 237, 0.1);
            border-bottom: 1px solid rgba(245, 242, 237, 0.08);
            border-radius: 1.25rem 1.25rem 0 0;
            padding: 0.75rem 1rem;
        }

        .quill-editor-shell .ql-container.ql-snow {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(245, 242, 237, 0.1);
            border-top: none;
            border-radius: 0 0 1.25rem 1.25rem;
            font-family: 'Outfit', sans-serif;
        }

        .quill-editor-shell .ql-editor {
            min-height: 220px;
            color: #f5f2ed;
            font-size: 0.875rem;
            line-height: 1.7;
            padding: 1rem 1.25rem;
        }

        .quill-editor-shell .ql-editor.ql-blank::before {
            color: rgba(245, 242, 237, 0.3);
            font-style: normal;
            left: 1.25rem;
            right: 1.25rem;
        }

        .quill-editor-shell .ql-snow .ql-stroke {
            stroke: rgba(245, 242, 237, 0.55);
        }

        .quill-editor-shell .ql-snow .ql-fill {
            fill: rgba(245, 242, 237, 0.55);
        }

        .quill-editor-shell .ql-snow .ql-picker {
            color: rgba(245, 242, 237, 0.7);
        }

        .quill-editor-shell .ql-snow .ql-picker-label {
            border-color: rgba(245, 242, 237, 0.15);
        }

        .quill-editor-shell .ql-snow .ql-picker-label:hover,
        .quill-editor-shell .ql-snow .ql-picker-label.ql-active {
            color: #f5f2ed;
        }

        .quill-editor-shell .ql-snow .ql-picker-options {
            background: #1a1a1a;
            border: 1px solid rgba(245, 242, 237, 0.15);
            border-radius: 0.75rem;
            padding: 0.25rem;
        }

        .quill-editor-shell .ql-snow .ql-picker-item {
            color: rgba(245, 242, 237, 0.7);
        }

        .quill-editor-shell .ql-snow .ql-picker-item:hover,
        .quill-editor-shell .ql-snow .ql-picker-item.ql-selected {
            color: #f5f2ed;
            background: rgba(245, 242, 237, 0.08);
        }

        .quill-editor-shell .ql-snow.ql-toolbar button:hover,
        .quill-editor-shell .ql-snow .ql-toolbar button:hover,
        .quill-editor-shell .ql-snow.ql-toolbar button.ql-active,
        .quill-editor-shell .ql-snow .ql-toolbar button.ql-active {
            color: #f5f2ed;
        }

        .quill-editor-shell .ql-snow.ql-toolbar button:hover .ql-stroke,
        .quill-editor-shell .ql-snow .ql-toolbar button:hover .ql-stroke,
        .quill-editor-shell .ql-snow.ql-toolbar button.ql-active .ql-stroke,
        .quill-editor-shell .ql-snow .ql-toolbar button.ql-active .ql-stroke {
            stroke: #f5f2ed;
        }

        .quill-editor-shell .ql-snow.ql-toolbar button:hover .ql-fill,
        .quill-editor-shell .ql-snow .ql-toolbar button.ql-active .ql-fill {
            fill: #f5f2ed;
        }

        .quill-editor-shell .ql-snow a {
            color: #f5f2ed;
        }

        .quill-editor-shell .ql-editor blockquote {
            border-left-color: rgba(245, 242, 237, 0.25);
            color: rgba(245, 242, 237, 0.65);
        }

        .quill-editor-shell .ql-editor pre.ql-syntax {
            background: rgba(0, 0, 0, 0.35);
            color: #f5f2ed;
            border-radius: 0.75rem;
        }

        .quill-editor-shell .ql-snow .ql-tooltip {
            background: #1a1a1a;
            border: 1px solid rgba(245, 242, 237, 0.15);
            color: #f5f2ed;
            border-radius: 0.75rem;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
        }

        .quill-editor-shell .ql-snow .ql-tooltip input[type='text'] {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(245, 242, 237, 0.15);
            color: #f5f2ed;
            border-radius: 0.5rem;
        }

        .quill-editor-shell .ql-snow .ql-tooltip a.ql-action::after,
        .quill-editor-shell .ql-snow .ql-tooltip a.ql-remove::before {
            color: rgba(245, 242, 237, 0.7);
        }
    </style>
    <script>
        (function () {
            function shouldDeferInit(wrapper) {
                const pageContent = wrapper.closest('[data-page-content]');

                return pageContent !== null && pageContent.classList.contains('hidden');
            }

            function initQuillEditor(wrapper) {
                if (!wrapper || wrapper.dataset.initialized === 'true' || shouldDeferInit(wrapper)) {
                    return;
                }

                const editorElement = wrapper.querySelector('[data-quill-root]');
                const inputElement = wrapper.querySelector('textarea[data-quill-input]');

                if (!editorElement || !inputElement) {
                    return;
                }

                if (typeof Quill === 'undefined') {
                    window.setTimeout(() => initQuillEditor(wrapper), 50);

                    return;
                }

                const imageInput = wrapper.querySelector('input[data-quill-image-input]');
                const videoInput = wrapper.querySelector('input[data-quill-video-input]');

                function insertMediaFromFile(file, embedType) {
                    if (!file) {
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const result = event.target?.result;
                        if (typeof result !== 'string') {
                            return;
                        }

                        const range = quill.getSelection(true);
                        const index = range ? range.index : quill.getLength();
                        quill.insertEmbed(index, embedType, result, 'user');
                        quill.setSelection(index + 1, 0, 'silent');
                    };
                    reader.readAsDataURL(file);
                }

                const quill = new Quill(editorElement, {
                    theme: 'snow',
                    placeholder: wrapper.dataset.placeholder || 'Write content here...',
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['blockquote', 'code-block', 'link', 'image', 'video'],
                            ['clean'],
                        ],
                        handlers: {
                            image: function () {
                                if (imageInput) {
                                    imageInput.click();
                                }
                            },
                            video: function () {
                                if (videoInput) {
                                    videoInput.click();
                                }
                            },
                        },
                    },
                });

                if (imageInput) {
                    imageInput.addEventListener('change', function () {
                        const [file] = imageInput.files || [];
                        insertMediaFromFile(file, 'image');
                        imageInput.value = '';
                    });
                }

                if (videoInput) {
                    videoInput.addEventListener('change', function () {
                        const [file] = videoInput.files || [];
                        insertMediaFromFile(file, 'video');
                        videoInput.value = '';
                    });
                }

                const initialValue = inputElement.value;
                if (initialValue) {
                    quill.root.innerHTML = initialValue;
                }

                quill.on('text-change', function () {
                    inputElement.value = quill.root.innerHTML;
                });

                editorElement.style.visibility = 'visible';
                editorElement.style.position = 'static';
                editorElement.style.pointerEvents = 'auto';
                wrapper.dataset.initialized = 'true';
            }

            function initializeAllQuillEditors() {
                document.querySelectorAll('[data-quill-editor]').forEach(initQuillEditor);
            }

            window.initializeAllQuillEditors = initializeAllQuillEditors;
        })();
    </script>
@endonce

<div
    data-quill-editor
    data-placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => 'space-y-2 quill-editor-shell']) }}
>
    <textarea name="{{ $name }}" data-quill-input class="hidden">{!! $value !!}</textarea>
    <input type="file" accept="image/*" data-quill-image-input class="hidden">
    <input type="file" accept="video/*" data-quill-video-input class="hidden">
    <div id="{{ $editorId }}" data-quill-root></div>
</div>
