
import View from '../views/View.js';
import state from '../state.js';

const tabContainer = document.querySelector('.tab-list');
const contents = document.querySelector('.tabs-content-container').children;
const selectTab = function (id) {
    const tab = [...tabContainer.children].find( t => t.dataset.target === id);
    if (!tab) return;
    const content = document.querySelector(tab.dataset.target);
    [...tabContainer.children].forEach( t => t.classList.remove('tab-item--selected'));
    [...contents].forEach(c => c.classList.remove('tab--selected'))
    tab.classList.add('tab-item--selected');
    content.classList.add('tab--selected');
}
window.addEventListener('hashchange', (e) => {
    selectTab(window.location.hash);
});
selectTab(window.location.hash);