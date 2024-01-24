
import View from '../views/View.js';
import state from '../state.js';
const ratedView = new View(document.getElementById('rated'));
ratedView.errorMessage = `<div class="container-simple-movie">You haven't rated any movie yet!</div>`
ratedView.generateMarkup = function () {
   return Object.entries(this.data).map((key, value) => '<div class="container-simple-movie">Kurwa trzeba request o film dac odpuszczam sobie</div>' )
       .join('')
}

const tabContainer = document.querySelector('.tab-list');
const contents = document.querySelector('.tabs-content-container').children;
const selectTab = function (id) {
    const tab = [...tabContainer.children].find( t => t.dataset.target === id);
    if (!tab) return;
    const content = document.querySelector(tab.dataset.target);
    if (content.id === 'rated') {
        ratedView.render(state.ratings);
    }
    [...tabContainer.children].forEach( t => t.classList.remove('tab-item--selected'));
    [...contents].forEach(c => c.classList.remove('tab--selected'))
    tab.classList.add('tab-item--selected');
    content.classList.add('tab--selected');
}
window.addEventListener('hashchange', (e) => {
    selectTab(window.location.hash);
});
selectTab(window.location.hash);