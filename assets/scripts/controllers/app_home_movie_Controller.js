import {getJSON, timeout} from "../modules/helpers.js";
import { URL_SCREENINGS, TIMEOUT_SEC } from '../modules/config.js';

const dropdown = document.querySelector('.dropdown');
dropdown.value = dropdown.firstElementChild.value;

const controlCinemaSelector = async function () {
    try {
        if (!dropdown.value) return;
        const cinemaId = dropdown.value;
        const movieId = document.getElementById('movieId').innerText;
        if (!isFinite(+cinemaId) || !isFinite(+movieId))
            throw new Error('Something went wrong! Try again in a while.')
        //TODO: render spinner

        const json = await Promise.race([
            getJSON(`${URL_SCREENINGS}?cinema=${cinemaId}`),
            timeout(TIMEOUT_SEC)]);

        console.log(json)

        //render data
    }
    catch (err) {
        console.error(err);
        //render error in view
    }
}

dropdown.addEventListener('change', controlCinemaSelector)


