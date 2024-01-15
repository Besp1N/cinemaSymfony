'use strict';
import SearchView from "../views/searchView.js";
import {getJSON, timeout} from "./helpers.js";
import {URL_MOVIES} from "./config.js";

const results = document.querySelector('.search-results');
const input = document.querySelector('input.navbar-search')
const searchView = new SearchView(document.querySelector('.search-results'));
const state = {
    prevQuery: '',
    data: new Map(),
    noResults: new Set()
};

export default async function searchMovies() {
    try {
        const query = input.value.trim();
        if (query.length < 3) {
            searchView.clear();
            return;
        }

        results.classList.remove('hidden');
        searchView.renderSpinner();

        // Check if the new query is a subset of the previous query
        if (query.startsWith(state.prevQuery) && state.data.has(state.prevQuery)) {
            const filteredResults = state.data.get(state.prevQuery).filter(movie =>
                movie.title.toLowerCase().includes(query.toLowerCase())
            );

            if (filteredResults.length === 0) {
                throw new Error('No movies found!');
            }

            searchView.render(filteredResults);
            return;
        }

        // If it's a completely new query, fetch data from the API
        if (!state.data.has(query)) {
            const response = await getJSON(`${URL_MOVIES}?title=${query}`);
            if (Array.isArray(response) && response.length === 0) {
                state.noResults.add(query);
                throw new Error('No movies found!');
            }

            state.noResults.delete(query);
            state.data.set(query, response);
        }

        state.prevQuery = query;
        searchView.render(state.data.get(query));
    } catch (err) {
        searchView.renderError(err.message);
    }
}

