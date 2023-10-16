import axios from 'axios'

let token = localStorage.getItem("token") ?? ""
axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['Authorization'] = token
axios.defaults.baseURL = "http://localhost:8000/api/"

export default axios;