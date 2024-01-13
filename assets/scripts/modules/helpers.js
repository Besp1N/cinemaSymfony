
export const getJSON = async function (url) {
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error(`Ooops. Response is (${response.status})`);
        return await response.json();
    }
    catch (err) {
        throw err;
    }
}
export const timeout = async function(sec) {
    await new Promise((_, reject) => setTimeout(reject, sec*1000));
}