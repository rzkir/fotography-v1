import { initAlertDialogs } from './alert-dialog.service';
import { initPortfolioForm } from './portofolio.service';
import { initPageSkeletons } from './skeleton.service';

document.addEventListener('DOMContentLoaded', () => {
    initPageSkeletons();
    initAlertDialogs();

    if (document.getElementById('portfolio-form')) {
        initPortfolioForm();
    }
});
