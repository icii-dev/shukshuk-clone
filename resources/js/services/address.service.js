import ApiService from './api.service.js';

const RESOURCE = 'user-address';

export default {
    getList() {
        return ApiService.get('/user-addresses');
    },

    getOne(id) {
        return ApiService.get(`/user-addresses/${id}`)
    },

    create(data) {
        return ApiService.post('/user-addresses/create', data);
    },

    update(id, data) {
        return ApiService.post(`/user-addresses/${id}/update`, data);
    },

    delete(id) {
        return ApiService.delete(`/user-addresses/${id}`);
    },

    setAsDefault(id) {
        return ApiService.put(`/user-addresses/${id}/set-default`);
    },

    getListProvince() {
        return ApiService.get('/api/provinces');
    },

    getListCity(provinceId) {
        return ApiService.get(`/api/provinces/${provinceId}/cities`);
    },

    getListDistrict(cityId) {
        return ApiService.get(`/api/cities/${cityId}/districts`);
    },

    getUser() {
        return ApiService.get(`/api/user`);
    }
};
