import axios from 'axios';
import Toastfy from 'toastify-js';
import "toastify-js/src/toastify.css";

const api = axios.create({
  baseURL: '/api',
});

const brasilApi = axios.create({
  baseURL: 'https://brasilapi.com.br',
})

export default {
  getAll() {
    return api.get('/fornecedores');
  },
  get(id) {
    return api.get(`/fornecedores/${id}`);
  },
  create(data) {
    return api.post('/fornecedores', data);
  },
  update(id, data) {
    return api.put(`/fornecedores/${id}`, data);
  },
  delete(id) {
    return api.delete(`/fornecedores/${id}`);
  },
  buscaCnpjCpf(value) {
    return brasilApi.get(`/api/cnpj/v1/${value}`);
  }
}

export function showToast(message, type = 'success'){
  Toastfy({
    text: message,
    duration: 3000,
    gravity: 'top',
    position: 'right',
    backgroundColor: type === 'sucess' ? 'green' : 'red',
    stopOnFocus: true,
  }).showToast();
}