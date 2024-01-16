
import searchHandler from "../modules/searchHandler.js";
import  state  from "../modules/state.js";
const isDarkMode = () =>
    window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
export default function() {


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
    state.theme = 'gowno';
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
    searchBox.addEventListener('input', searchHandler);
    searchBox.addEventListener('focus', searchHandler);
    searchBox.addEventListener('focusout', () => {
        setTimeout(() => searchResults.classList.add('hidden'), 150);
    })

    // chuj dupa cipa szukalem kurwa tej scierzki /search/query z 2 godziny
    document.querySelector('#search-form').addEventListener('submit', e => {
        e.preventDefault();
        const query = document.querySelector('.navbar-search').value;
        if (!query) return;
        document.location.href = `/search?q=${query}`;
    })
}