import Slider from '../modules/slider.js';

const slider = new Slider(document.querySelector('.slides-poster'), 75);
// slider.addLink(1, 'test');
document.querySelectorAll('.slide-poster').forEach(slide => {
    slider.addLink(+slide.dataset.slide, `/${slide.dataset.movie}`)
});
