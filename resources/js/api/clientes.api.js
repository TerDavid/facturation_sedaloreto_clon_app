import axios from 'axios';

export function getBienvenida() {
    return axios.get('/api/bienvenida');
}

export function postFormulario(data) {
    return axios.post('/api/formulario', data);
}
export function searchCliente(search) {
    return axios.get(`/api/clientes/search?search=${search}`);
}
