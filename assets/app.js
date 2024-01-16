import state from './scripts/modules/state.js';
import './styles/app.css';
import "./scripts/views/searchView.js";
import './scripts/modules/searchHandler.js';
import "./scripts/modules/modal.js";
import('./scripts/modules/helpers.js');
import('./scripts/statics/config.js');
import './vendor/geolib/geolib.index.js';
import navbarController from './scripts/controllers/navbar_Controller.js';
import geoLocator from './scripts/modules/geolocator.js';
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
    setInterval(() => window.localStorage.setItem('state', JSON.stringify(state)), 10000);
    if (!state.cinema && !state.visited) {
        //Logic for first visit
        geoLocator.getLocation();
        state.visited = true;

    }



}
