import './styles/app.css';
import SearchView from "./scripts/views/searchView.js";
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
        await Promise.all([
            import('./scripts/modules/helpers.js'),
            import('./scripts/modules/config.js'),
            import('./scripts/views/screeningsView.js')]);
    }
}


/**
 * Script used on all pages.
 */
function app() {
    const isDarkMode = () =>
        window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const themeBtn = document.querySelector('.theme-toggle');
    const genreSelect = document.querySelector('.navbar-genres');
    const searchBox = document.querySelector('input.navbar-search');
    const searchResults = document.querySelector('.search-results');
    genreSelect.value = genreSelect.firstElementChild.value
    //INIT THEME
    const prevTheme = window.localStorage.getItem('isDarkTheme');
    if (prevTheme) {
        document.body.classList.add(prevTheme);
    }
    else {
        if (isDarkMode()) document.body.classList.add('dark-mode');
    }
    /////////////
    themeBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        window.localStorage.setItem('isDarkTheme', document.body.classList.contains('dark-mode') ? 'dark-mode' : "light-mode")
    })
    document.querySelector('.navbar-toggle').addEventListener('click', function () {
        const links = document.querySelector('.navbar-links');
        [...links.children].forEach(child => {
            if (!child.classList.contains('always-visible')) child.classList.toggle('active')
        })
    });

    genreSelect.addEventListener('change', () => {
        const genre = genreSelect.value.toLowerCase();
        window.location.href = `/genre/${genre}`;
    })
    /////////////////// SEARCHBOX

    const controlSearchbox = async function (e) {
    console.log(searchBox.value);
    }
    const searchView = new SearchView(searchResults);
    searchBox.addEventListener('input', controlSearchbox)

    searchView.renderError();
    searchResults.classList.toggle('hidden')
}
