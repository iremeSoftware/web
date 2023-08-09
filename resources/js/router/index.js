import login from '../pages/login.vue'
import resetPassword from '../pages/reset_password.vue'
import home from '../pages/home.vue'
import registerSchool from '../pages/register_school.vue'
import pay from '../pages/pay.vue'
import dashboard from '../pages/dashboard/dashboard.vue'


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
  },
  {
    path: '/pay',
    name:'pay',
    component:pay
  },
  {
    path: '/dashboard',
    component:dashboard,
    children: [
      {
        path: '/',
        component: dashboard,
      },
    ],

  }
 
]

export default routes