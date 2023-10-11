import './bootstrap';

import {createApp} from 'vue'
import * as VueRouter from 'vue-router'
import App from './App.vue'
import routes from './router/'
import VueSmoothScroll from 'v-smooth-scroll'
import { pinia } from './stores'
import { setup as setupFirebase } from './firebaseConfig'

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes, // short for `routes: routes`
  })

setupFirebase()

let app = createApp(App)
app
.use(pinia)
.use(VueSmoothScroll)
.use(router).mount("#app")