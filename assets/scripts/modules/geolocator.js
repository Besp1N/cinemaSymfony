import state from '../state.js';
import Modal from './modal.js';
import {getJSON, timeout} from "./helpers.js";
import { URL_CINEMAS, TIMEOUT_SEC } from '../statics/config.js';
import { getDistance } from '../../vendor/geolib/geolib.index.js';
import CinemasDropdown from "../views/cinemasDropdown.js";
class Geolocator {
    #modal = new Modal();
    #cinemas

 async getLocation() {
        this.#modal.clearContent();
     this.#modal.appendContent(this.#markup);
     this.#modal.showModal();
     await this.#getCinemas();

     this.#getLocation()
 }
 #getLocation() {
        this.#modal.appendContent(`<h2>Working on getting your location...</h2>`)
     try {
         navigator.geolocation.getCurrentPosition(this.#handleAccept.bind(this), this.#handleReject.bind(this));
     }
     catch (err) {
            this.#handleReject();
     }
 }

 #handleAccept(data) {
    state.coords = {latitude: data.coords.latitude, longitude: data.coords.longitude};
    this.#cinemas.forEach( cin => cin.coords = {latitude: cin.coords.split[0] ?? 0, longitude: cin.coords.split[1] ?? 0});
    this.cinema = this.#cinemas.reduce( (closest, cin) => {
        return getDistance(state.coords, cin.coords) < closest ? cin : closest;
    }, Infinity);
     this.#modal.clearContent();

    this.#modal.appendContent(`<div class="container"><h2>Your cinema is: </h2><h1>${this.cinema.name} - ${this.cinema.address}</h1></div>`)
     state.cinema = this.cinema;
     window.localStorage.setItem('state', JSON.stringify(state));
 }
 #handleReject() {
     this.#modal.clearContent();
     this.#renderCinemas();
 }
 #renderCinemas() {
     const cinemasDropdown = new CinemasDropdown(this.#modal.getContent());
     cinemasDropdown.render(this.#cinemas);
     document.getElementById('cinema-select-dropdown').value = state.cinema ? state.cinema.id : '';
     this.#modal.appendContent(`<div class="container"><h2>We couldn't get your location! Please select your cinema for better experience.</h2></div>`)

     document.getElementById('selectCinemaModal').addEventListener('submit', this.#handleCinemaSelect.bind(this));
 }
  async #getCinemas() {
        try {
            this.#cinemas = await getJSON(URL_CINEMAS);
        }
        catch (err) {
            this.#handleReject();
        }

 }
async #handleCinemaSelect(e) {
    e.preventDefault();
    const cinemaId = +document.getElementById('cinema-select-dropdown').value;
    if(!cinemaId) return;
    this.#modal.clearContent();
    this.#modal.appendContent(`<div class="container"><h1>Preferences saved!</h1></div>`);
    state.cinema = await getJSON(`${URL_CINEMAS}?id=${cinemaId}`);
    window.localStorage.setItem('state', JSON.stringify(state));

}
 #markup = `
    <div class="container">
    ${state.cinema ? `<h2>Your cinema is: </h2><h2>${state.cinema.name} - ${state.cinema.city} - ${state.cinema.address}</h2>` : 
   `<h1>Hi there!</h1>
   <h2>For better user experience please enable location or select your cinema!<h2>`}
   </div>
 `
}
export default new Geolocator();

