
const handleTabs = function () {
    const tabContainer = document.querySelector('.tab-list');
    const contents = document.querySelector('.tabs-content-container').children;
    tabContainer.addEventListener('click', e => {
        const tab = e.target.closest('.tab-item');
        if (!tab) return;
        const content = document.querySelector(tab.dataset.target);
        [...tabContainer.children].forEach( t => t.classList.remove('tab-item--selected'));
        [...contents].forEach(c => c.classList.remove('tab--selected'))
        tab.classList.add('tab-item--selected')
        content.classList.add('tab--selected')
    })
}
handleTabs();