import View from './View.js';
export default class SearchView extends View {
    errorMessage = 'No results found!';

    generateMarkup() {
        return this.data.forEach(this.generateLi).join('');
    }
    generateLi(result) {
        return result.title
    }
}
