import { createWebHashHistory, createRouter } from "vue-router";

import Login from "../Layouts/Auth/Login.vue";
import Home from "../Layouts/Main.vue";
// import HelloWorld from "../Layouts/Example.vue";
import Categories from "../Layouts/Pages/Categories.vue";
import Users from "../Layouts/Pages/Users.vue";
import Product from "../Layouts/Pages/Product.vue";
import Dashboard from "../Layouts/Pages/Dashboard.vue";
import Videos from "../Layouts/Pages/Videos.vue";

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
        path: 'dashboard',
        component: Dashboard,
      },
      {
        path: 'users',
        component: Users,
      },
      {
        path: 'categories',
        component: Categories,
      },
      {
        path: 'product',
        component: Product,
      },
      {
        path: 'videos',
        component: Videos,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;