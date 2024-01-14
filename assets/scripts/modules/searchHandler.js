import SearchView from "../views/searchView.js";
import {getJSON, timeout} from "./helpers.js";
import {URL_MOVIES} from "./config.js";

const results = document.querySelector('.search-results');
const input = document.querySelector('input.navbar-search')
const searchView = new SearchView(document.querySelector('.search-results'));
export default async function() {
    try {
        const query = input.value;
        if (query.length < 3 ) return

        results.classList.remove('hidden');
        searchView.renderSpinner();
        const data = await getJSON(`${URL_MOVIES}?title=${query}`);
        if (Array.isArray(data) && data.length === 0) throw new Error('No movies found!')
        searchView.render(data);
    }
    catch (err) {
        searchView.renderError(err.message)
    }
}