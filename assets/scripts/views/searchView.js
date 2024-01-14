import View from './View.js';
export default class SearchView extends View {
    errorMessage = `<li class="container-simple-movie container">
                   <p>No results!</p>
                </li>`;
    generateMarkup() {
        return this.data.map(this.#generateItem).join('');
    }
    #generateItem(result) {
        return `<a class="container container-simple-movie" href="/${result.id}">
                   <p>${result.title}</p>
                </a>`
    }
}
