import {timeout} from "../modules/helpers.js";
import Modal from "../modules/modal.js";
import SeatsView from "../views/seatsView.js";
import MockPayment from "../modules/mockPayment.js";


const controller = function () {
    const form = document.getElementById('reservation-form');
    const seatsInput = document.getElementById('selectedSeat');
    const seatsContainer = document.querySelector('.container-seats');
    const options = [...seatsInput.children].filter(opt => opt.dataset.info);

    const handleMinorCheaters = function () {
        const seat = [...seatsContainer.children].find( s => s.dataset.id === seatsInput.value);
        [...seatsContainer.children]
            .forEach( opt => opt.classList.remove('seat-selected'));
        seat.classList.add('seat-selected');
    }
    const selectSeat = function (e) {
        if (e.key && e.key !== 'Enter') return;
        const seat = e.target.closest('.seat');
        if (!seat) return;
        const option = options
            .find(opt => opt.value === seat.dataset.id);
        if (option && option.dataset.status !== 'taken') {
            if (seat.classList.contains('seat-selected'))
            {
                seatsInput.value = '';
                seat.classList.remove('seat-selected');
                return
            }

            seatsInput.value = option.value;
            [...seatsContainer.children]
                .forEach( opt => opt.classList.remove('seat-selected'));
            seat.classList.add('seat-selected');
        }
    }
    const isScumbag = function () {
        const selSeat =  [...seatsContainer.children]
            .find(s => s.classList?.contains('seat-selected'));
        if (!selSeat && seatsInput.value !== '') {
            seatsInput.value = '';
            return 1;
        }
      if (selSeat && selSeat.dataset.id !== seatsInput.value) {
          selSeat.classList.remove('seat-selected');
          seatsInput.value = '';
          return 1
      }
      const selected = [...seatsInput.options].find( o =>
          o.value === seatsInput.value);
      if (selected && selected.dataset.status !== 'available')
          return 1;
      return 0;
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
    function prevDef(e) { }
    window.addEventListener('beforeunload', prevDef);
    window.addEventListener('pageshow', (event) => {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
    seatsInput.value = '';
    const seats = options.map(opt => {
        return {id: opt.value, row: opt.dataset.info[0], col: opt.dataset.info.slice(1), type: opt.dataset.type, status: opt.dataset.status};
    });
    const seatsSorted = group(seats);

    const seatsView = new SeatsView(seatsContainer);
    seatsView.render(seatsSorted);
    seatsContainer.addEventListener('click', selectSeat);
    seatsContainer.addEventListener('keydown', selectSeat);

    // SECURITY
    seatsInput.addEventListener('change', handleMinorCheaters);

    setInterval(isScumbag, 1000);

    const config = { attributes: true, childList: true, subtree: true };

    const mutationCallback = function(mutationsList, observer) {
        for(const mutation of mutationsList) {
            if (mutation.type === 'attributes') {
                console.log(`The ${mutation.attributeName} attribute was modified.`);
                form.remove();
                document.querySelector('main').insertAdjacentHTML('beforeend',
                    `
                       <h1>FUCK YOU</h1>
                       <div class="container col-on-mobile" style="background: none">
                    <img src="../images/tiger.jpg" style="display: inline">
                    <img src="../images/swat.gif" style="display: inline">
                    </div>
                    <h1>YOU HAVE BEEN REPORTED TO THE POLICE</h1>`);
                window.removeEventListener('beforeunload', prevDef);
                setInterval(() => {
                    let color = document.querySelector('main').style.backgroundColor;
                    document.querySelector('main').style.backgroundColor = color === 'red' ? 'blue' : 'red';
                } , 200)
                setTimeout(() => window.location.href =`https://cbsp.policja.pl/`, 6000);
            }
        }
    };

    const observer = new MutationObserver(mutationCallback);
    observer.observe(seatsInput, config);

    ///////////////////////
    form.addEventListener('submit', async e => {
        try {
            e.preventDefault();
            if (seatsInput.value === '')
                throw new Error('Something went wrong when selecting your seat!');
            const mockPayment = new MockPayment();
            await mockPayment.process();
            window.removeEventListener('beforeunload', prevDef);
            if(isScumbag()) throw new Error('dirty cheater scumbag');
            form.submit();
        } catch (err) {
            console.error(err.message);
        }
    })
}
controller();