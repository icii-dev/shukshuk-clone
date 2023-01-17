import axios from 'axios';

const baseApiUrl = process.env.MIX_BASE_API_URL
    ? process.env.MIX_BASE_API_URL
        : ('https://' + location.hostname + (location.port ? ':' + location.port : ''));
;

const axiosInstance = axios.create({
    baseURL: baseApiUrl,
    withCredentials: true,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
});

const ApiService = {
    get(uri) {
        return axiosInstance.get(uri);
    },

    post(uri, data) {
        return axiosInstance.post(uri, data);
    },

    put(uri, data) {
        return axiosInstance.put(uri, data);
    },

    delete(uri) {
        return axiosInstance.delete(uri);
    }
}

export default ApiService;
