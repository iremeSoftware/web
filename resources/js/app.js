import './bootstrap';

import {createApp} from 'vue'
import * as VueRouter from 'vue-router'

import App from './App.vue'
import routes from './router/'
import VueSmoothScroll from 'v-smooth-scroll'
import {validations} from "../js/helpers/validations"



const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes, // short for `routes: routes`
  })


let app = createApp(App)
app.config.globalProperties.$validations = "Hello"
app.use(VueSmoothScroll).use(router).mount("#app")