import './bootstrap';

import {createApp} from 'vue'
import * as VueRouter from 'vue-router'

import App from './App.vue'
import routes from './router/'
import VueSmoothScroll from 'v-smooth-scroll'




const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes, // short for `routes: routes`
  })


createApp(App).use(VueSmoothScroll).use(router).mount("#app")