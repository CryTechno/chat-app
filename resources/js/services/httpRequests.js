import axios from "axios";
const Http = function(csrfToken) {
    const baseURL = window.location.origin;
    const headers = {
        'X-Requested-With': 'XMLHttpRequest',
    };
    return axios.create({
        baseURL,
        headers,
    });
}

export default Http;
