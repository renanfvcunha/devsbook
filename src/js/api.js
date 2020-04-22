import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8080/devsbook/public',
});

export default api;
