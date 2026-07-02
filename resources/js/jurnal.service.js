import { initSlugify, initUpload } from './portofolio.service';

export function initJurnalForm() {
    document.querySelectorAll('[data-upload-root]').forEach(initUpload);
    initSlugify();

    if (typeof window.initializeAllQuillEditors === 'function') {
        window.initializeAllQuillEditors();
    }
}
