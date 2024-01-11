/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './scripts/dupa.js';

console.log('Main JS files imports correctly!');
//temporary location for main page files
const themeBtn = document.querySelector('.theme-toggle');

themeBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
})


document.querySelector('.navbar-toggle').addEventListener('click', function() {
    const links = document.querySelector('.navbar-links');
    [...links.children].forEach(child => {
        if (!child.classList.contains('always-visible')) child.classList.toggle('active')
    })

});

console.log('Main JS files imports correctly!');

