import './styles/app.css';

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
    const themeBtn = document.querySelector('.theme-toggle');
    const genreSelect = document.querySelector('.navbar-genres');

    genreSelect.value = genreSelect.firstElementChild.value
    const isDarkMode = () =>
        window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (isDarkMode()) document.body.classList.add('dark-mode');
    themeBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
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
}
