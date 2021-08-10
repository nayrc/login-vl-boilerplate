import Vue from "vue";
import VueRouter from "vue-router";

import * as guards from "./guard";

import Dashboard from "../views/Dashboard.vue";
import Login from "../views/auth/Login.vue";
import ForgotPassword from "../views/auth/ForgotPassword.vue";

Vue.use(VueRouter);

const routes = [{
    path: "/",
    name: "Dashboard",
    component: Dashboard,
    beforeEnter: guards.authenticated,
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
    beforeEnter: guards.unauthenticated
  },
  {
    path: "/forgot-password",
    name: "ForgotPassword",
    component: ForgotPassword,
    beforeEnter: guards.unauthenticated
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;