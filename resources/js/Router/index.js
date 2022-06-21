import { createWebHashHistory, createRouter } from "vue-router";

import Login from "../components/Auth/Login.vue";
import Home from "../Components/Main.vue";
import HelloWorld from "../Components/Example.vue";
import Categories from "../Components/Pages/Categories.vue";

const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/",
    name: "Home",
    component: Home,
    alias: '/home',
    meta: { requiresAuth: true },
    children: [
      {
        path: 'hello',
        component: HelloWorld,
      },
      {
        path: 'categories',
        component: Categories,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;