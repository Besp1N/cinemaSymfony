import './styles/app.css';
import "./scripts/views/searchView.js";
import './scripts/modules/searchHandler.js';
import Modal from "./scripts/modules/modal.js";
import('./scripts/modules/helpers.js');
import('./scripts/statics/config.js');
import navbarController from './scripts/controllers/navbar_Controller.js';
import * as forms from './scripts/statics/forms.js';
importModules();
app();

/**
 *
 * Imports different  modules depending on the site visited.
 * IMPORTANT: It only enables the imports in controllers directory.
 * This only allows then for importing from the controller level.
 */
async function importModules() {
    const path = window.location.pathname;

    if (path === '/') {
        await import('./scripts/modules/slider.js');
    }
    if (new RegExp('/\\d').test(path)) {
            import('./scripts/views/screeningsView.js');
    }
}


/**
 * Script used on all pages.
 */
function app() {
    navbarController();
    ///
    ///
    /// TUTAJ WYLACZYSZ OKIENKO
    const modal = new Modal();
    modal.appendContent(forms.dupaForm);
    modal.showModal();
    // tu mozna select form i wziac formdata.
    // i bez odswiezania strony mozna cos zrobic
    // ale to do formularzy np. select city lub seans, wtedy przekierowuje
    // na dedykowana strone np. rezerwuj na ten seans
}
