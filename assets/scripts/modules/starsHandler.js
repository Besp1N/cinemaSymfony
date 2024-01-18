import state from '../state.js';
const movieId = +document.getElementById('movieId').innerText;
if (state.ratings[movieId]) {
    document.getElementById(`star-${6 - state.ratings[movieId]}-full`).checked = true;
}

document.querySelectorAll('.rating input').forEach(async (star) => {
    star.addEventListener('change', function() {
        const ratingValue = 6 - this.value;
        console.log(`Rated: ${ratingValue} stars`);
        console.log(star)
        state.ratings[+movieId] = ratingValue;
        window.localStorage.setItem('state', JSON.stringify(state));
    });
});
