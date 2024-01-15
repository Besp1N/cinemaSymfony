import {getJSON, timeout} from "../modules/helpers.js";
import { URL_SCREENINGS, TIMEOUT_SEC } from '../statics/config.js';
import ScreeningsView from "../views/screeningsView.js";

const screeningView = new ScreeningsView(document.getElementById('screenings'));
const dropdown = document.querySelector('.dropdown');
dropdown.value = dropdown.firstElementChild.value;
const controlCinemaSelector = async function () {
    try {
        if (!dropdown.value) return;
        const cinemaId = dropdown.value;
        const movieId = document.getElementById('movieId').innerText;
        if (!isFinite(+cinemaId) || !isFinite(+movieId))
            throw new Error('Something went wrong! Try again in a while.')

        screeningView.renderSpinner();
        const json = await Promise.race([
            getJSON(`${URL_SCREENINGS}?cinema=${cinemaId}&movie=${movieId}`),
            timeout(TIMEOUT_SEC)]);
        screeningView.render(json)
    }
    catch (err) {
        console.error(err);
        screeningView.renderError();
    }
}

dropdown.addEventListener('change', controlCinemaSelector)


