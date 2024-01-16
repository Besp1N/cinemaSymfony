import state from './state.js';
import Modal from './modal.js';
import {getJSON, timeout} from "./helpers.js";
import { URL_SCREENINGS, TIMEOUT_SEC } from '../statics/config.js';
class Geolocator {
    #modal = new Modal();
 getLocation() {
     this.#modal.appendContent(this.#markup);
     this.#modal.showModal();
     this.#getLocation()
 }
 #getLocation() {
     navigator.geolocation.getCurrentPosition(this.#handleAccept.bind(this), this.#handleReject.bind(this));
 }
 #handleAccept() {

 }
 #handleReject() {
     this.#modal.clearContent();
     this.#modal.appendContent(`<h2>We couldn't get your location! Please select your cinema for better experience.</h2>`)
    this.#renderCinemas();
 }
 #renderCinemas() {

 }

 #markup = `
   <h1>Hi there!</h1>
   <h2>For better user experience please enable location or select your cinema!<h2>
 `
}
export default new Geolocator();