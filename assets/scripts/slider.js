export default class Slider {
    #parent;
    #slides;
    #offset;
    #current = 0;

    /**
     * Creates a simple slider given a parent container.
     * @param {Element} parent - The container element for the slides.
     * @param {number} offset - Determines the initial positioning of slides.
     *                          0 for stacked, 100 for side by side.
     */
    constructor(parent, offset = 100) {
        this.#parent = parent;
        this.#slides = Array.from(parent.children);
        this.#offset = offset;
        this.#initializeSlider();
    }

    /**
     * Initializes the slider by setting up necessary styles and event listeners.
     */
    #initializeSlider() {
        this.#resizeParent();
        this.#setSlidesPosition();
        this.#offsetSlides();
        this.#addKeyboardHandler();
    }

    /**
     * Sets the position of each slide to absolute and adjusts margin.
     */
    #setSlidesPosition() {
        this.#slides.forEach(slide => {
            slide.style.position = 'absolute';
            slide.style.margin = '0 0 0 25%';
            slide.style.zIndex = 1;
        });
    }

    /**
     * Adjusts the parent container's height to fit the tallest slide.
     */
    #resizeParent() {
        let maxHeight = 0;
        this.#slides.forEach(slide => {
            const img = slide.querySelector('img'); // Assuming each slide contains an <img>
            if (img) {
                maxHeight = Math.max(maxHeight, img.height);
            }
        });
        this.#parent.style.height = `${maxHeight}px`;
        console.log(maxHeight);
    }



    /**
     * Sets the initial offset of the slides.
     */
    #offsetSlides() {
        this.#slides.forEach((slide, i) => {
            slide.dataset.slide = i;
            slide.style.transform = `translateX(${(i - this.#current) * this.#offset + 25}%)`;
        });
    }

    /**
     * Adds keyboard navigation for the slider.
     */
    #addKeyboardHandler() {
        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowRight') this.moveSlides(this.#current + 1);
            if (e.key === 'ArrowLeft') this.moveSlides(this.#current - 1);
        })
    }

    /**
     * Moves the slides based on the given position.
     * @param {number} position - The position to move the slides to.
     */
    moveSlides(position) {
        this.#current = Math.max(0, Math.min(position, this.#slides.length - 1));
        this.#slides.forEach((slide, i) => {
            slide.style.transform = `translateX(${(i - this.#current) * this.#offset + 25}%)`;
            if (+slide.dataset.slide === this.#current) slide.style.zIndex = 2;
            else slide.style.zIndex = 1;
        });
        console.log(this.#current)
    }

    /**
     * Adds an external handler for moving slides to the left.
     * @param {Element} element - The element that triggers the move to the left.
     */
    addHandlerMoveLeft(element) {
        element.addEventListener('click', () => this.moveSlides(--this.#current));
    }

    /**
     * Adds an external handler for moving slides to the right.
     * @param {Element} element - The element that triggers the move to the right.
     */
    addHandlerMoveRight(element) {
        element.addEventListener('click', () => this.moveSlides(++this.#current));
    }
}
