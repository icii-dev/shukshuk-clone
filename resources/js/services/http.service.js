import axios from 'axios';

const APP_ID = 'DBF8BFAF-A834-4045-AB56-D270B894C68C';

const instance = axios.create({

    baseURL: 'https://some-domain.com/api/',
});

const HttpService = {
    get() {
        return instance.get()
    },
    post() {

    }
}

export default HttpService;