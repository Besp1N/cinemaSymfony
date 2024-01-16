export default class Modal {
    #overlay = document.querySelector('.overlay');
    #modal = document.querySelector('.modal');
    #btnCloseModal = document.querySelector('.btn-close-modal');
    #content = document.querySelector('#modal-content');
    #boundCheckEscape = this.#checkEscape.bind(this);
    #boundCheckClick = this.#checkClick.bind(this);
    constructor() {
        this.#addDefaultHandlers();
    }
    #addDefaultHandlers() {
        document.addEventListener('keydown', this.#boundCheckEscape);
        document.addEventListener('click', this.#boundCheckClick);
        this.#btnCloseModal.addEventListener('click', this.closeModal.bind(this));
    }

    closeModal() {
        this.#overlay.classList.add('hidden');
        this.#modal.classList.add('hidden');
        // Use the same bound function reference to remove the listener
        document.removeEventListener('keydown', this.#boundCheckEscape);
        document.removeEventListener('click', this.#boundCheckClick);
    }
    showModal() {
        document.addEventListener('keydown', this.#boundCheckEscape);
        document.addEventListener('click', this.#boundCheckClick);
        this.#overlay.classList.remove('hidden');
        this.#modal.classList.remove('hidden');
    }

    #checkEscape(e) {
        if (e.target.isEqualNode(document.body) && e.key === 'Escape') this.closeModal();
    }
    #checkClick(e) {
        if (e.target.isEqualNode(this.#overlay)) this.closeModal();
    }

    appendContent(markup) {
        this.#content.insertAdjacentHTML('beforeend', markup);
    }
    prependContent(markup) {
        this.#content.insertAdjacentHTML('afterbegin', markup);
    }
    clearContent() {
        this.#content.innerHTML = '';
    }
    getContent() {
        return this.#content;
    }
}
