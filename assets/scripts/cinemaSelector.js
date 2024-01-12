'use strict';

const dropdown = document.querySelector('.dropdown');
/////////////////// INIT
dropdown.value = dropdown.firstElementChild.value
dropdown.addEventListener('change', async () => {
    const data = {movie: 1, cinema: 1};

   const response = await fetch('/api/api_screenings',
       {method: "GET",
           headers: {"Content-Type": "application/json"},
           body: JSON.stringify(data)});
})