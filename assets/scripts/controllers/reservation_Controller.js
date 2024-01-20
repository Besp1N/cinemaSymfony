import {timeout} from "../modules/helpers.js";
import Modal from "../modules/modal.js";
import SeatsView from "../views/seatsView.js";


const controller = function () {
    const handlePayment = async function () {

    }
    const selectSeat = function (e) {
        const seat = e.target.closest('.seat');
        if (!seat) return;
        const seatStatus = seat.dataset.status;  // dodalem tu ta linie ale nie wiem czy tu powinnac byc
        seatsInput.value = options
            .find(opt => opt.value === seat.dataset.id)
            .value;
        [...seatsContainer.children]
            .forEach( opt => opt.classList.remove('seat-selected'));
        seat.classList.add('seat-selected');
    }

    const group = function (array) {
        return array.reduce((acc, seat) => {
            const letter = seat.row;
            if (!acc[letter]) {
                acc[letter] = [];
            }
            acc[letter].push(Object.assign(seat));
            return acc;
        }, {});
    };
    const form = document.getElementById('reservation-form');
    const seatsInput = document.getElementById('selectedSeat');
    const seatsContainer = document.querySelector('.container-seats');
    const options = [...seatsInput.children].filter(opt => opt.dataset.info);

    // MAKE SURE TO GET AROUND REFRESH FUCKERY AND RESET THE CHOICE
    seatsInput.value = seatsInput.firstElementChild.value;
    const seats = options.map(opt => {
        // dodalem do zwracania status siedzenia, nie bede oszukiwal, szukalem gdzie to sie odbywa w chuj czasu
        return {id: opt.value, row: opt.dataset.info[0], col: opt.dataset.info.slice(1), type: opt.dataset.type, status: opt.dataset.status};
    });
    const seatsSorted = group(seats);

    const seatsView = new SeatsView(seatsContainer);
    seatsView.render(seatsSorted);
    seatsContainer.addEventListener('click', selectSeat);
    form.addEventListener('submit', async e => {
        try {
            e.preventDefault();
            if (seatsInput.value === '')
                throw new Error('Something went wrong when selecting your seat!');
            await handlePayment();
            form.submit();
        } catch (err) {
            console.error(err.message);
        }
    })
}
controller();