import Slider from '../modules/slider.js';

const slider = new Slider(document.querySelector('.slides-poster'), 75);
// slider.addLink(1, 'test');
document.querySelectorAll('.slide-poster').forEach(slide => {
    slider.addLink(+slide.dataset.slide, `/${slide.dataset.movie}`)
});
slider.addHandlerMoveRight(document.querySelector('.slider-button-right'));

slider.addHandlerMoveLeft(document.querySelector('.slider-button-left'));
