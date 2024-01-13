
export default class View {
    #parentElement;
    data;
    errorMessage;
    constructor(parentElement) {
        this.#parentElement = parentElement;
    }
    render(data) {
        this.data = data;
        if (!this.data || Array.isArray(this.data) && this.data.length === 0 ) throw new Error('Invalid data.')

        const markup = this.generateMarkup();

        this.#parentElement.innerHTML = '';
        this.#parentElement.insertAdjacentHTML("afterbegin", markup);
    }
    renderError() {
        this.#parentElement.innerHTML = '';
        this.#parentElement.insertAdjacentHTML("afterbegin", this.errorMessage);
    }

    renderSpinner() {
        this.#parentElement.innerHTML = '';
        this.#parentElement.insertAdjacentHTML("afterbegin",
            `<svg style="margin: 10px auto; fill: var(--text-color)" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><style>.spinner_P7sC{transform-origin:center;animation:spinner_svv2 .75s infinite linear}@keyframes spinner_svv2{100%{transform:rotate(360deg)}}</style><path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" class="spinner_P7sC"/></svg>`)
    }
    generateMarkup() {
        return 'Change the method #generateMarkup.'
    }

}