import login from '../pages/login.vue'
import resetPassword from '../pages/reset_password.vue'
import home from '../pages/home.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: home
  },
  {
    path: '/login',
    name: 'login',
    component: login
  },
  {
    path: '/resetPassword',
    name: 'reset_password',
    component: resetPassword
  },
 
]

export default routes