import './styles/app.css';



importModules();
app();

/**
 *
 * Imports different  modules depending on the site visited.
 * IMPORTANT: It only enables the imports in the module files.
 * This only allows for the specific module to import others.
 */
async function importModules() {
    const path = window.location.pathname;

    if (path === '/') {
        await import('./scripts/modules/slider.js');
    }
    if (new RegExp('/\\d').test(path)) {
        await import('./scripts/modules/helpers.js');
        await import('./scripts/modules/config.js');
    }
}

/**
 * Script used on all pages.
 */
function  app() {
    const themeBtn = document.querySelector('.theme-toggle');
    const isDarkMode = () =>
        window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (isDarkMode()) document.body.classList.add('dark-mode');
    themeBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    })
    const query = window.matchMedia('prefers-color-scheme: dark');
    document.querySelector('.navbar-toggle').addEventListener('click', function () {
        const links = document.querySelector('.navbar-links');
        [...links.children].forEach(child => {
            if (!child.classList.contains('always-visible')) child.classList.toggle('active')
        })

    });

}
