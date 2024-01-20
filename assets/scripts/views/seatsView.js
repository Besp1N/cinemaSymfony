import View from './View.js';

/**
 * Set errorMessage field and generateMarkup method before using.
 */
export default class SeatsView extends View {
    constructor(parent) {
        super(parent);
    }

    errorMessage = `<li class="container-simple-movie container">
                   <p>No seats ayo wtf you doin admin</p>
                </li>`;
    generateMarkup() {
        const container = document.querySelector('.container-seats');

        const max = Object.values(this.data)
            .reduce( (max, row) => row.length > max ? row.length : max , 0);

        container.style.gridTemplateColumns = `repeat(${max + 1}, 1fr)`;
        const header = '&#10240;' +
            Array.from({length:max}, (_, i) =>
                `<div>${i + 1}</div>`).join(' ');
        const screen = `<div class="screen"></div>`
        return header + screen + Object.entries(this.data)
            .map(this.#generateRow.bind(this, max)).join('');
    }
    #generateRow(maxSeatNumber, row) {
        const [rowLabel, seats] = row;
        // Generate seat or empty cell based on seat number
        const rowMarkup = Array.from({ length: maxSeatNumber  }, (_, i) => {
            const seat = seats.find(s => +s.col === i + 1  )
            return seat ? this.#generateSeat(seat) : '<div class="seat-empty"></div>';
        }).join('');
        return rowLabel + rowMarkup;
    }
    #generateSeat(seat) {
        console.log(seat);
        let icon;
        let seatClass;
        switch (seat.type) {
            case 'Regular':
                icon = "fas fa-chair";
                break;
            case 'Vip': {
                icon = "fas fa-crown";
                break;
            }
            case 'Handicapped': {
                icon = "fas fa-wheelchair"
                break;
            }
        }
        switch (seat.status) {
            case 'taken':
                seatClass = 'seat-occupied';
                break;
            case 'available':
                seatClass = 'seat-empty';
                break;
        }
        // return `<div class="seat seat-empty" data-id="${seat.id}"><i class="${icon}"></i></div>`;
        return `<div class="seat ${seatClass}" data-id="${seat.id}"><i class="${icon}"></i></div>`;
    }

}

