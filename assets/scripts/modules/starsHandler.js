import state from '../state.js';
const movieId = +document.getElementById('movieId').innerText;
if(!state.ratings) state.ratings = {};
let checked;
if (state.ratings[movieId]) {
    document.getElementById(`star-${6 - state.ratings[movieId]}-full`).checked = true;
    checked = state.ratings[movieId];
}

document.querySelectorAll('.rating input').forEach(async (star) => {
    star.addEventListener('click', function() {
        if (6 - star.value === checked) {
           star.checked = false;
           checked = undefined;
           state.ratings[movieId] = undefined;
           window.localStorage.setItem('state', JSON.stringify(state));
           return;
        }
        checked = 6 - this.value;
        state.ratings[movieId] = checked;
        window.localStorage.setItem('state', JSON.stringify(state));
        //TODO: Pobierac dane z uzytkowanika zalogowanego zamiast state
    });
});
