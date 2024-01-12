'use strict';

const dropdown = document.querySelector('.dropdown');
/////////////////// INIT
dropdown.value = dropdown.firstElementChild.value


dropdown.addEventListener('change', async () => {

    const movieId = document.getElementById('movieId').innerText;
    const cinemaId = dropdown.value


   const response = await fetch(`/api_screenings?movie=${movieId}&cinema=${cinemaId}`);
    const data = await response.json();
})