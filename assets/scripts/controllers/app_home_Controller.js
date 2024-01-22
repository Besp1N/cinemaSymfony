import Slider from '../modules/slider.js';
import L from '../../vendor/leaflet/leaflet.index.js';
import state from "../state.js";
import {URL_CINEMAS, TIMEOUT_SEC} from "../statics/config.js";
import {getJSON, timeout} from "../modules/helpers.js";

const slider = new Slider(document.querySelectorAll('.slides-poster')[1], 100);
document.querySelectorAll('.slide-poster').forEach(slide => {
    slider.addLink(+slide.dataset.slide, `/${slide.dataset.movie}`)
});
slider.addHandlerMoveRight(document.querySelector('.slider-button-right'));
slider.addHandlerMoveLeft(document.querySelector('.slider-button-left'));

const tabNav = document.querySelector('.container-nav-about-us.tab-list');
const contents = document.querySelectorAll('.about-us-slide');
const showSlide = function (e) {
    let slide;
    const li = e.target.closest('.item-nav-about-us');
    if (!li )  slide = e.target.closest('.about-us-slide');
    else  {
        slide = [...contents].find(c => c.dataset.slide === li.dataset.target);
        [...tabNav.children].forEach(tab => tab.classList.remove('tab-item--selected'))
        li.classList.add('tab-item--selected');
    }
    if (!slide) return;

    [...contents].forEach(c => {
        c.classList.remove('expanded')
        c.children[2].classList.add('hidden');
    });


    slide.classList.add('expanded');
    slide.children[2].classList.remove('hidden');
}
document.querySelector('.about-us-container').addEventListener('click', showSlide);
tabNav.addEventListener('click', showSlide);

const obsSettings = {
    root: null,
    threshold: 0.15
}
const popup = function (e) {
    const entry = e[0];
    if (!entry.isIntersecting) return;
    entry.target.classList.remove('section-hidden');
    this.disconnect();
}
document.querySelectorAll('.section').forEach( section => {
    const obs = new IntersectionObserver(popup, obsSettings);
    obs.observe(section);
});

//Will need to refactor but this is for loading a map
/**
 *
 * @param {Object} cinema
 * @param {Object} map
 */
const addCinemaMarker = function(cinema, map) {
    const pos = cinema.coords.split(',').map(parseFloat);
    const marker = L.marker(pos)
        .bindPopup(`<b>${cinema.name} - ${cinema.address} - ${cinema.city}</b>`)
        .addTo(map);
}
const mapController = async function () {
    let center = state?.coords ?? state?.cinema?.coords ?? [52.1, 19.3];
    if (typeof center === 'string') center = center.split(',');
    const map = L.map('map').setView(center, 7);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    try {
        const cinemas = await Promise.race([getJSON(URL_CINEMAS),
            timeout(TIMEOUT_SEC)]);
        cinemas.forEach(c => addCinemaMarker(c, map));
    }
    catch (err) {
        console.error(err);
        const marker = L.marker([52.1, 19.3]).addTo(map);
        marker.bindPopup("<b>Sorry! Couldn't load the map!</b>").openPopup();
    }

}

window.addEventListener('load', mapController);