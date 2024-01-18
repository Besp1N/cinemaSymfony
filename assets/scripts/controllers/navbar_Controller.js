
import searchHandler from "../modules/searchHandler.js";
import  state  from "../state.js";
import geolocator from "../modules/geolocator.js";
const isDarkMode = () =>
    window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
export default function() {

    const themeBtn = document.querySelector('.theme-toggle');
    const genreSelect = document.getElementById('navbar-genres');
    const settingsSelect = document.getElementById('navbar-settings');
    const searchBox = document.querySelector('input.navbar-search');
    const searchResults = document.querySelector('.search-results');
    genreSelect.value = genreSelect.firstElementChild.value

    themeBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        state.theme = document.body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode';
        window.localStorage.setItem('state', JSON.stringify(state));
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

    settingsSelect.addEventListener('change', () => {
        const option = settingsSelect.value;
        settingsSelect.value = settingsSelect.firstElementChild.value;
        switch (option) {
            case 'cinema':
                geolocator.getLocation();
                break;
            case 'profile_settings':
                window.location.href = '/user/profile-settings';
                break;
        }
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