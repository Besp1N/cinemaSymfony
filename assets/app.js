/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import Slider from './scripts/slider.js';


//temporary location for main page files
const themeBtn = document.querySelector('.theme-toggle');
const isDarkMode = () =>
    window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
if (isDarkMode()) document.body.classList.add('dark-mode');
themeBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
})
const query = window.matchMedia('prefers-color-scheme: dark');
console.log(query);
document.querySelector('.navbar-toggle').addEventListener('click', function() {
    const links = document.querySelector('.navbar-links');
    [...links.children].forEach(child => {
        if (!child.classList.contains('always-visible')) child.classList.toggle('active')
    })

});

console.log('Main JS files imports correctly!');


const slider = new Slider(document.querySelector('.slides-poster'), 75);
// slider.addLink(1, 'test');

