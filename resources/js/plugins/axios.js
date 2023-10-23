import axios from 'axios'

let token = localStorage.getItem("token") ?? ""
axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['Authorization'] = token
axios.defaults.baseURL = import.meta.env.VITE_APP_API_URL

export default axios;