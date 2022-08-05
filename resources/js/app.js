import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

import ElementPlus from 'element-plus'

import axios from 'axios'
import VueAxios from 'vue-axios'

import 'element-plus/dist/index.css'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'

import { InertiaProgress } from '@inertiajs/progress'

import VuePaginationTw from "vue-pagination-tw";

import store from './store';

InertiaProgress.init();

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(store)
            .use(VuePaginationTw)
            .use(ElementPlus)
            .use(VueAxios, axios)
            .mount(el);

        for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
            app.component(key, component)
        }
  },
})