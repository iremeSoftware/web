import login from '../pages/login.vue'
import resetPassword from '../pages/reset_password.vue'
import home from '../pages/home.vue'
import registerSchool from '../pages/register_school.vue'

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
  {
    path: '/registerSchool',
    name:'register_school',
    component:registerSchool
  }
 
]

export default routes