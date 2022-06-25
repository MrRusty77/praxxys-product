import { createWebHashHistory, createRouter } from "vue-router";

import Login from "../components/Auth/Login.vue";
import Home from "../Components/Main.vue";
// import HelloWorld from "../Components/Example.vue";
import Categories from "../Components/Pages/Categories.vue";
import Users from "../Components/Pages/Users.vue";
import Product from "../Components/Pages/Product.vue";
import Dashboard from "../Components/Pages/Dashboard.vue";

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
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;