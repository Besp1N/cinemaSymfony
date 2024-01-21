import Slider from '../modules/slider.js';

const slider = new Slider(document.querySelectorAll('.slides-poster')[1], 75);
// slider.addLink(1, 'test');
document.querySelectorAll('.slide-poster').forEach(slide => {
    slider.addLink(+slide.dataset.slide, `/${slide.dataset.movie}`)
});
slider.addHandlerMoveRight(document.querySelector('.slider-button-right'));
slider.addHandlerMoveLeft(document.querySelector('.slider-button-left'));

const contents = document.querySelectorAll('.about-us-slide');
const showSlide = function (e) {
    const li = e.target.closest('.item-nav-about-us');
    if (!li ) return;

    [...contents].forEach( c => {
        c.classList.remove('expanded')
        c.children[1].classList.add('hidden');
    });

    const slide = [...contents].find(c => c.dataset.slide === li.dataset.target);
    if (!slide) return;
    slide.classList.add('expanded');
    slide.children[1].classList.remove('hidden');
}
document.querySelector('.about-us-container').addEventListener('click', e => {
    const slide = e.target.closest('.about-us-slide');
    if (!slide) return;
    [...contents].forEach( c => {
        c.classList.remove('expanded')
        c.children[1].classList.add('hidden');
    });
    slide.classList.add('expanded');
    slide.children[1].classList.remove('hidden');
});
const tabNav = document.querySelector('.container-nav-about-us.tab-list');
tabNav.addEventListener('click', showSlide)