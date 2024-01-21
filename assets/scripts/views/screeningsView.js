import View from './View.js';


/**
 * Set errorMessage field and generateMarkup method before using.
 */
export default class ScreeningsView extends View {
    errorMessage = `<li class="container-simple-movie container">
                   <p>No screenings here:( CHECK ANOTHER CINEMA!</p>
                </li>`;
    generateMarkup() {
        return `<h2>Screenings in selected cinema:</h2>` + this.data.map(this.#generateLi).join('');
    }
    #generateLi(screening) {
        return ` <a href="/reservation/${screening.screeningId}">
                <li class="container-simple-movie container">
              ${screening.movieTitle} - ${screening.screeningStartTime} - ${screening.movieTheaterName}
            </li>
            </a>`;
    }

}

