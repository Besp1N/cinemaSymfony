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
        console.log(screening);
        return `<li class="container-simple-movie container">
               <a href="/reservation/${screening.screeningId}">${screening.movieTitle} - ${screening.screeningStartTime} - ${screening.movieTheaterName}</a>
            </li>`;
    }

}

