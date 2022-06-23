import { createWebHashHistory, createRouter } from "vue-router";

import Login from "../components/Auth/Login.vue";
import Home from "../Components/Main.vue";
// import HelloWorld from "../Components/Example.vue";
import Categories from "../Components/Pages/Categories.vue";
import Users from "../Components/Pages/Users.vue";

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
        path: 'users',
        component: Users,
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