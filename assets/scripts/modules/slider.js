// import {mark} from "regenerator-runtime";

export default class Slider {
    #parent;
    #slides;
    #offset;
    #current = 0;
    #interval;
    #lastSlide;
    #initialHeight

    /**
     * Creates a simple slider given a parent container.
     * @param {Element} parent - The container element for the slides.
     * @param {number} offset - Determines the initial positioning of slides.
     *                          0 for stacked, 100 for side by side.
     */
    constructor(parent, offset = 100) {
        this.#parent = parent;
        if (!this.#parent) throw new Error (`Couldn't construct a slider.`)
        this.#slides = Array.from(parent.children);
        this.#offset = offset;
        this.#initialHeight = window.innerHeight * 0.5;
        this.#initializeSlider();
        this.moveSlides(0);
        // window.addEventListener('resize', this.#resizeParent.bind(this))
    }

    /**
     * Initializes the slider by setting up necessary styles and event listeners.
     */
    #initializeSlider() {
        this.#createLastSlide();
        this.#resizeParent();
        this.#setSlidesPosition();
        this.#offsetSlides();
        this.#addKeyboardHandler();
        this.#addHandlersClick();
        this.#addInterval();

    }

    /**
     * Sets the necessary styling for slides
     */
    #setSlidesPosition() {
        this.#slides.forEach(slide => {
            slide.style.position = 'absolute';
            slide.style.transition = 'all 0.6s ease';
        });
    }
    #createLastSlide() {
        const lastSlide = document.createElement('div');
        lastSlide.style.position = 'absolute';
        lastSlide.style.right = 0;

        lastSlide.innerHTML = `<a href="#tosomesection">
                <div class="container hidden-mobile" style="max-width: 400px; background: none;">
                <h2 >That's not all</h2>
                <h2>We are sure your movie is somewhere nearby. Feel free to search!</h2>
                <div style="display: flex; justify-content: center">
                <i class="fa-solid fa-circle-chevron-down fa-xl" style="margin-bottom: 2rem"></i>
                </div>

                </div>
                                </a>`
        this.#parent.appendChild(lastSlide);
        this.#slides.push(lastSlide)
        this.#lastSlide = lastSlide;
    }

    /**
     * Adjusts the parent container's height to fit the tallest slide.
     */
    #resizeParent() {
        document.querySelectorAll('.slide-poster-image').forEach(slide => {
            slide.style.maxHeight = `${this.#initialHeight}px`;
        });
        let maxHeight = 0;
        this.#slides.forEach(slide => {
            const img = slide.querySelector('img'); // Assuming each slide contains an <img>
            if (img) {
                maxHeight = Math.max(maxHeight, img.height);
            }
        });
        this.#parent.style.height = `${maxHeight}px`;
    }

    /**
     * Sets the initial offset of the slides and data attributes.
     */
    #offsetSlides() {
        this.#slides.forEach((slide, i) => {
            slide.dataset.slide = i;
            if (+slide.dataset.slide === this.#slides.length - 1 ) {
                slide.style.zIndex =  100 + this.#slides.length
                return
            }

            slide.style.transform = `translateX(${(i - this.#current) * this.#offset - slide.dataset.slide * 10}%)`;
        });
    }

    /**
     * Adds keyboard navigation for the slider.
     */
    #addKeyboardHandler() {
        document.addEventListener('keydown', e => {
            if (!e.target.isEqualNode(document.body)) return;
            if (e.key === 'ArrowRight') {
                clearInterval(this.#interval);
                this.moveNext();
            }
            if (e.key === 'ArrowLeft') {
                clearInterval(this.#interval);
                this.movePrevious();
            }
        })
    }
    #addInterval() {
        this.#interval = setInterval(this.moveNext.bind(this), 4000)
    }

    /**
     * Moves the slides based on the given position.
     * @param {number} position - The position to move the slides to.
     */
    moveSlides(position) {
        this.#current = position;
        this.#lastSlide.style.visibility = this.#current >= this.#slides.length - 2 ? 'visible' : 'hidden';
        this.#lastSlide.style.opacity = this.#current >= this.#slides.length - 2 ?  1 : 0;

        this.#slides.forEach((slide, i) => {
            if (+slide.dataset.slide === this.#slides.length - 1 ) {
                return;
            }
            slide.style.transform = `translateX(${(i - this.#current) * this.#offset}%)`;
            if (+slide.dataset.slide === position) {
                slide.style.zIndex = 100;
                slide.style.opacity = 1;
            } else {
                let zIndex = 100 - Math.abs(i - position);
                slide.style.zIndex = zIndex;
                slide.style.opacity = 0.5;
            }
        });
    }
    moveNext() {
        if (this.#current === this.#slides.length - 2) this.moveSlides(0);
        else this.moveSlides(this.#current + 1)
    }
    movePrevious() {
        if (this.#current === 0) this.moveSlides(this.#slides.length - 2);
        else this.moveSlides(this.#current - 1 )
    }

    #addHandlersClick() {
        this.#parent.addEventListener('click', (e) => {
            clearInterval(this.#interval);
            const slide = e.target.closest('.slide-poster');
            if (!slide) return;
            this.moveSlides(+slide.dataset.slide)
        })
        let touchstartX = 0;
        let touchendX = 0;
        let touchstartTime = 0;

        const SWIPE_THRESHOLD = 30; // Minimum distance for a swipe
        const TAP_THRESHOLD = 500; // Maximum time for a tap

        const handleTouchStart = (e) => {
            touchstartX = e.touches[0].clientX;
            touchstartTime = new Date().getTime();
        };

        const handleTouchEnd = (e) => {
            touchendX = e.changedTouches[0].clientX;
            const touchDuration = new Date().getTime() - touchstartTime;

            if (Math.abs(touchendX - touchstartX) > SWIPE_THRESHOLD && touchDuration < TAP_THRESHOLD) {
                if (touchendX < touchstartX) {
                    this.moveNext();
                } else {
                    this.movePrevious();
                }
                clearInterval(this.#interval)
            }
        };

        this.#parent.addEventListener('touchstart', handleTouchStart, { passive: true });
        this.#parent.addEventListener('touchend', handleTouchEnd, { passive: true });

    }

    /**
     * Adds an external handler for moving slides to the left.
     * @param {Element} element - The element that triggers the move to the left.
     */
    addHandlerMoveLeft(element) {
        element.addEventListener('click', () => {
            clearInterval(this.#interval);
            this.movePrevious();
        });
    }

    /**
     * Adds an external handler for moving slides to the right.
     * @param {Element} element - The element that triggers the move to the right.
     */
    addHandlerMoveRight(element) {
        element.addEventListener('click', () => {
            clearInterval(this.#interval);
            this.moveNext()
        });
    }

    /**
     *
     * @param {Number} slideNumber Selects a slide to add an anchor to.
     * @param {Text} url
     */
    addLink(slideNumber, url) {
       const slide =  this.#slides.find( (slide) => +slide.dataset.slide === slideNumber);
       slide.addEventListener('click', () => {
           if (+slide.dataset.slide === this.#current) window.location.href = url;
       })
    }
}
