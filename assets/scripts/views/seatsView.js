import View from './View.js';

/**
 * Set errorMessage field and generateMarkup method before using.
 */
export default class SeatsView extends View {

    errorMessage = `<li class="container-simple-movie container">
                   <p>No seats ayo wtf you doin admin</p>
                </li>`;
    generateMarkup() {
        const container = document.querySelector('.container-seats');

        const max = Object.values(this.data)
            .reduce((max, row) => row.length > max ? row.length : max, 0);

        container.style.gridTemplateColumns = `1fr repeat(${max}, 1fr) 1fr`;

        const header = '<div></div>' +
            Array.from({ length: max }, (_, i) =>
                `<div>${i + 1}</div>`).join(' ') + '<div></div>';

        const screen = `<div class="screen" style="grid-column: 1 / -1;"></div>`; // Make screen span all columns

        return header + screen + Object.entries(this.data)
            .map(this.#generateRow.bind(this, max)).join('');
    }

    #generateRow(maxSeatNumber, row) {
        const [rowLabel, seats] = row;
        const rowMarkup = Array.from({ length: maxSeatNumber }, (_, i) => {
            const seat = seats.find(s => +s.col === i + 1)
            return seat ? this.#generateSeat(seat) : '<div class="seat-empty"></div>';
        }).join('');

        // Add empty div at the end for alignment
        return `<div>${rowLabel}</div>${rowMarkup}<div></div>`;
    }

    #generateSeat(seat) {
        let icon;
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
            default: {
                icon = "fas fa-chair";
                break;
            }
        }

        return `<div tabindex="0" class="seat ${seat.status === 'taken' ? 'seat-occupied' : 'seat-empty'}" data-id="${seat.id}"><i class="${icon}"></i></div>`;
    }

}

