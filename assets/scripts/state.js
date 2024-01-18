let state =  window.localStorage.getItem('state');
if (!state) state = '{ "ratings": {} }';
export default JSON.parse(state);