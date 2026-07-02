import { initAlertDialogs } from './alert-dialog.service';
import { initJurnalForm } from './jurnal.service';
import { initPortfolioForm } from './portofolio.service';
import { initPageSkeletons } from './skeleton.service';

document.addEventListener('DOMContentLoaded', () => {
    initPageSkeletons();
    initAlertDialogs();

    if (document.getElementById('portfolio-form')) {
        initPortfolioForm();
    }

    if (document.getElementById('jurnal-form')) {
        initJurnalForm();
    }
});
