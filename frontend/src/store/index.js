import Vue from "vue";
import Vuex from "vuex";
import {
  getField,
  updateField
} from "vuex-map-fields";

import Auth from "./module/auth";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loading: {
      screen: false,
    },
  },
  getters: {
    getField
  },
  mutations: {
    updateField
  },
  actions: {},
  modules: {
    auth: Auth
  },
});