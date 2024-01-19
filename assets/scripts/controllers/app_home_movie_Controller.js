import {getJSON, timeout} from "../modules/helpers.js";
import { URL_SCREENINGS, TIMEOUT_SEC } from '../statics/config.js';
import ScreeningsView from "../views/screeningsView.js";
import state  from '../state.js';

const screeningView = new ScreeningsView(document.getElementById('screenings'));
const dropdown = document.querySelector('#cinema-select-dropdown');
const dropdownAdvanced = document.querySelector('#cinema-select-dropdown-advanced');
const movieId = document.getElementById('movieId').innerText;
const btnGoTo = document.querySelector('.movie-goto-book');
const sectionAS = document.getElementById('section-advanced-screenings');
const advancedSearchForm = document.getElementById('advanced-screenings');
const advancedScreeningView = new ScreeningsView(document.getElementById('advanced-results'))
const controlCinemaSelector = async function (view) {
    try {
        const cinemaId = dropdown.value;
        if (!cinemaId) return;
        if (!isFinite(+cinemaId) || !isFinite(+movieId))
            throw new Error('Something went wrong! Try again in a while.')
        screeningView.renderSpinner();
        const json = await Promise.race([
            getJSON(`${URL_SCREENINGS}?cinema=${cinemaId}&movie=${movieId}`),
            timeout(TIMEOUT_SEC)]);
        screeningView.render(json);

    }
    catch (err) {
        screeningView.renderError();
    }
}
const controlAdvancedSearch = async function (e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(advancedSearchForm).entries());
    if (!data.date || !data.cinema) return;
    try {
        if (!isFinite(+data.cinema) || !isFinite(+data.movie))
            throw new Error('Something went wrong! Try again in a while.')
        advancedScreeningView.renderSpinner();
        const json = await Promise.race([
            getJSON(`${URL_SCREENINGS}?cinema=${cinemaId}&movie=${movieId}&datetime=${data.date}`),
            timeout(TIMEOUT_SEC)]);
        advancedScreeningView.render(json)
    }
    catch (err) {
        advancedScreeningView.renderError();
    }
}
const init = function () {
    dropdown.addEventListener('change', controlCinemaSelector);
    dropdown.value = state.cinema?.id ?? dropdown.firstElementChild.value;
    controlCinemaSelector();

    btnGoTo.addEventListener('click', e => {
        e.preventDefault();
        sectionAS.scrollIntoView({behavior: 'smooth'});
    })

    dropdownAdvanced.value = state.cinema?.id ?? dropdownAdvanced.firstElementChild.value;
    document.getElementById('date-input').value = new Date().toISOString().split('T')[0]
    advancedSearchForm.addEventListener('submit', controlAdvancedSearch);
}

init();

