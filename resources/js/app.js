import { createApp } from 'vue';
import axios from 'axios'

import ElementPlus from 'element-plus'

import 'element-plus/dist/index.css'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'

import VuePaginationTw from "vue-pagination-tw";

import router from './router';
import store from './store';

import App from './App.vue';

router.beforeEach((to, from, next) => {

  if(to.matched.some(record => record.meta.requiresAuth)) {
      if(!store.getters.isAuthenticated) next({ path: '/login' });
      else next();
   } else {
      next();
   }

});


const app = createApp(App);

for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
  app.component(key, component)
}


app.config.globalProperties.$axios = axios;

app.use(store);
app.use(router);
app.use(VuePaginationTw);
app.use(ElementPlus);

app.mount('#app');


