let state =  window.localStorage.getItem('state');
if (!state) state = '{ }';
export default JSON.parse(state);