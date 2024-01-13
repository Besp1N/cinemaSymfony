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
        // dodalem takiego if ( mozna to zamienic zamiast errorMessage )
        if (!screening.movieTitle || !screening.screeningStartTime || !screening.movieTheaterName) {
            return `<li class="container-simple-movie container">
                   <p>Movie information not available</p>
                </li>`;
        }

        // glowne zwracanie i wyswietlanie
        return `<li class="container-simple-movie container">
               <p>${screening.movieTitle} - ${screening.screeningStartTime} - ${screening.movieTheaterName}</p>
            </li>`;
    }

}

