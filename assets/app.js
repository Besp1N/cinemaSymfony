import state from './scripts/state.js';
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
    if (new RegExp('^/\\d').test(path)) {
        await Promise.all([
            import('./scripts/views/screeningsView.js'),
            import('./scripts/modules/starsHandler.js'),
        ]);

    }
    if (new RegExp('^/user/\\d').test(path)) {
        await import('./scripts/controllers/profile_Controller.js');
    }
    if (new RegExp('^/reservation/\\d').test(path)) {
        await Promise.all([
            import('./scripts/modules/mockPayment.js'),
            import('./scripts/controllers/reservation_Controller.js')]);
     }
}


/**
 * Script used on all pages.
 */
function app() {
    // setInterval(() => window.localStorage.setItem('state', JSON.stringify(state)), 10000);
    navbarController();
    if (!state.cinema && !state.visited) {
        state.visited = true;
        geoLocator.getLocation();
    }
    
    document.body.classList.add(state.theme)

}
