import { createApp } from 'vue';
import axios from 'axios'

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import router from './router';
import store from './store';

// import 'equal-vue/dist/style.css';
// import "vue-pagination-tw/styles"; 

// import VuePaginationTw from "vue-pagination-tw";

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

app.config.globalProperties.$axios = axios;

app.use(store);
app.use(router);
// app.use(VuePaginationTw);
app.use(ElementPlus);

app.mount('#app');


