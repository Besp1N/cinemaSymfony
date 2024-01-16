import View from './View.js';

export default class CinemasDropdown extends View {

    generateMarkup() {
        return `<form id="selectCinemaModal" class="flex-form"">
                <h2><label for="cinema">Select your cinema:</label></h2>
                <select name="cinema" class="dropdown" id="cinema-select-dropdown">
                        <option value="" selected>---</option>
                        ${this.data.map(this.#generateOption).join('')}
                </select>
                <button type="submit" id="btnSubmitCinema">OK</button>
            </form>`
    }
    #generateOption(cinema) {
        return `<option value="${cinema.id}">${ cinema.city } - ${ cinema.name } - ${ cinema.address }</option>`

}
}