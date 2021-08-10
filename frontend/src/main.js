import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";

import {
  BootstrapVue,
  IconsPlugin
} from "bootstrap-vue";
import VueCookies from "vue-cookies";
import {
  ValidationProvider
} from 'vee-validate';
import {
  ValidationObserver
} from "vee-validate";

import CookiesConfig from "./config/cookies";
import VueSimpleAlert from "vue-simple-alert";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import 'remixicon/fonts/remixicon.css'


Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueCookies);
Vue.use(VueSimpleAlert);

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

Vue.config.productionTip = false;

Vue.$cookies.config(
  CookiesConfig.expiredTime
);

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");