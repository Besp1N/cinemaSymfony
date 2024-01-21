import Modal from './modal.js';
import View from '../views/View.js';
export default class Payment {
    #modal;
    #view;
    #closedPromise
    #rejectModalClose;
    #resolveModalClose;
    #done;
    constructor() {
        this.#modal = new Modal();
        this.#view = new View(this.#modal.getContent());
        this.#closedPromise = new Promise((resolve, reject) => {
            this.#rejectModalClose = reject;
            this.#resolveModalClose = resolve;
        });
        document.addEventListener('modalClosed', () => {
            if (!this.#done) this.#rejectModalClose(new Error('Payment refused.'));
            else this.#resolveModalClose('Success!');
        })
    }
    async process() {
        try {
            this.#modal.showModal();
            this.#view.renderSpinner();
            this.#modal.prependContent(`<h1 style="margin-bottom: 2rem; text-align: center">Processing payment</h1>`);
            await Promise.race([
                new Promise(resolve => setTimeout(resolve, 5000)),
                this.#closedPromise
             ]);
            this.#done = true;
            this.#modal.clearContent();
            this.#modal.appendContent(this.#successMarkup);
            await new Promise(resolve => setTimeout(
                () => {
                    this.#modal.closeModal();
                    resolve();
                },  3000));

        }
        catch (err) {
            throw err;
        }
    }
    #successMarkup = `<h1 style="text-align: center">Payment complete!</h1><h1><i class="fas fa-check-circle fa-2xl" style="color:forestgreen; text-align: center; margin-top: 5rem"></i></h1>`
}
