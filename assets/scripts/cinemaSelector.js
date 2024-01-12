'use strict';

const dropdown = document.querySelector('.dropdown');
/////////////////// INIT
dropdown.value = dropdown.firstElementChild.value


dropdown.addEventListener('change', async () => {

    const cinemaId = dropdown.value

    // wywalilem to movie z linka bo zrobilem se inaczej ( obczaj kontroler )
    const response = await fetch(`/api_screenings?cinema=${cinemaId}`);
    const data = await response.json();
    console.log(data);
})