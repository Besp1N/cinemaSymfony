import Slider from '../modules/slider.js';

const slider = new Slider(document.querySelectorAll('.slides-poster')[1], 100);
document.querySelectorAll('.slide-poster').forEach(slide => {
    slider.addLink(+slide.dataset.slide, `/${slide.dataset.movie}`)
});
slider.addHandlerMoveRight(document.querySelector('.slider-button-right'));
slider.addHandlerMoveLeft(document.querySelector('.slider-button-left'));

const tabNav = document.querySelector('.container-nav-about-us.tab-list');
const contents = document.querySelectorAll('.about-us-slide');
const showSlide = function (e) {
    let slide;
    const li = e.target.closest('.item-nav-about-us');
    if (!li )  slide = e.target.closest('.about-us-slide');
    else  {
        slide = [...contents].find(c => c.dataset.slide === li.dataset.target);
        [...tabNav.children].forEach(tab => tab.classList.remove('tab-item--selected'))
        li.classList.add('tab-item--selected');
    }
    if (!slide) return;

    [...contents].forEach(c => {
        c.classList.remove('expanded')
        c.children[2].classList.add('hidden');
    });


    slide.classList.add('expanded');
    slide.children[2].classList.remove('hidden');
}
document.querySelector('.about-us-container').addEventListener('click', showSlide);
tabNav.addEventListener('click', showSlide);

const obsSettings = {
    root: null,
    threshold: 0.15
}
const popup = function (e) {
    const entry = e[0];
    if (!entry.isIntersecting) return;
    entry.target.classList.remove('section-hidden');
    this.disconnect();
}
document.querySelectorAll('.section').forEach( section => {
    const obs = new IntersectionObserver(popup, obsSettings);
    obs.observe(section);
});