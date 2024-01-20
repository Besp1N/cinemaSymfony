import View from './View.js';

/**
 * Set errorMessage field and generateMarkup method before using.
 */
export default class SeatsView extends View {
    errorMessage = `<li class="container-simple-movie container">
                   <p>No seats ayo wtf you doin admin</p>
                </li>`;
    generateMarkup() {
        const max = Object.values(this.data).reduce( (max, row) => row.length > max ? row.length : max , 0);
        const header = '&#10240;' +
            Array.from({length:max}, (_, i) => i + 1).join(' ')+
            '</br>';
        return header + Object.entries(this.data).map(this.#generateRow.bind(this)).join('</br>');
    }
    #generateRow(row) {
        return row[0] + row[1].map(this.#generateSeat).join(' ');
    }
    #generateSeat(seat) {
        return `<div class="seat" data-id="${seat.id}"><i class="fas fa-chair"></i></div>`;
    }

}

