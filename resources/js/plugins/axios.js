import axios from 'axios'

axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.baseURL = "http://localhost:8000/api/";

export default axios;