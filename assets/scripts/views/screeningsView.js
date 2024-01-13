import View from './View.js';

/**
 * Set errorMessage field and generateMarkup method before using.
 */
export default class ScreeningsView extends View {
    errorMessage = `There has been an error. Try again in a while.`
    generateMarkup() {
        console.log(this.data)
        return this.data.map(this.#generateLi).join('');
    }
    #generateLi(screening) {
        if (!screening.movie) {

            return `<li class="container-simple-movie container">
                   <p>Movie information not available</p>
                </li>`;
        }

        return `<li class="container-simple-movie container">
               <p>${screening.movie} - </p>
            </li>`;
    }

}

