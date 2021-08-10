import {
  getField,
  updateField
} from "vuex-map-fields";

import {
  http,
  catchHttp,
  setToken
} from "../../config/http";
import router from "../../router";
import cookies from "vue-cookies";

export default {
  namespaced: true,
  state: {
    authData: {
      au_email: "",
      au_password: ""
    },
    userProfile: {},
    forgotPasswordData: {
      au_email: "",
    },
    checkCodeOtpData: {
      au_email: "",
      au_2fa: ""
    },
    resetPasswordData: {
      au_email: "",
      au_password: ""
    },
    userData: cookies.get("user_data")
  },
  getters: {
    getField
  },
  mutations: {
    updateField,
    SET_USER_PROFILE(state, data) {
      state.userProfile = data;
    },
    CLEAR_AUTH_DATA(state) {
      state.authData.au_email = "";
      state.authData.au_password = "";
    },
    CLEAR_RESET_PASSWORD_DATA(state) {
      state.authData.email = "";
      state.authData.password = "";
    },
    SET_AUTH_DATA(state) {
      state.userData = cookies.get("user_data");
    },
    SET_FORGOT_PASSWORD_DATA(state, data) {
      state.forgotPasswordData.au_email = data;
      state.checkCodeOtpData.au_email = data;
    },
    SET_RESET_PASSWORD_DATA(state, data) {
      state.resetPasswordData.au_email = data;
    },
    CLEAR_FORGOT_PASSWORD_DATA(state) {
      state.forgotPasswordData.au_email = "";
    },
    CLEAR_ALL(state) {
      state.authData.au_email = "";
      state.authData.au_password = "";
      state.forgotPasswordData.au_email = "";
      state.checkCodeOtpData.au_email = "";
      state.checkCodeOtpData.au_2fa = "";
      state.resetPasswordData.au_email = "";
      state.resetPasswordData.au_password = "";
    }
  },

  actions: {
    async login({
      state,
      commit,
      rootState
    }) {
      try {
        rootState.loading.screen = true;

        if (state.authData.email === "" || state.authData.password === "")
          return 404;

        const res = await http.post("auth/login", state.authData);
        setToken(res.data.data.token);

        cookies.set("access_token", res.data.data.token);
        cookies.set("user_data", res.data.data.user);

        commit("SET_AUTH_DATA");

        return router.push({
          name: "Dashboard"
        });
      } catch (err) {
        return catchHttp(err);
      } finally {
        rootState.loading.screen = false;
      }
    },

    async forgotPassword({
      state,
      commit,
      rootState
    }) {
      try {
        rootState.loading.screen = true;
        const res = await http.post("auth/forgotPassword", state.forgotPasswordData);

        commit("CLEAR_FORGOT_PASSWORD_DATA");

        commit("SET_FORGOT_PASSWORD_DATA", res.data.data)

        return 200;
      } catch (err) {
        return catchHttp(err);
      } finally {
        rootState.loading.screen = false;
      }
    },

    async checkCodeOtp({
      state,
      commit,
      rootState
    }) {
      try {
        rootState.loading.screen = true;
        const res = await http.post("auth/checkCodeOtp", state.checkCodeOtpData);

        commit("SET_RESET_PASSWORD_DATA", res.data.data);

        return 200;
      } catch (err) {
        return catchHttp(err);
      } finally {
        rootState.loading.screen = false;
      }
    },

    async resetPassword({
      state,
      commit
    }) {
      try {
        await http.post("auth/resetPassword", state.resetPasswordData);

        commit("CLEAR_ALL");

        return 200;
      } catch (err) {
        return catchHttp(err);
      }
    },

    async getProfile({
      state,
      commit
    }) {
      try {
        const res = await http.get(`profile/${state.userData.au_id}`);

        commit("SET_USER_PROFILE", res.data.data);

      } catch (err) {
        cookies.remove("access_token");
        cookies.remove("user_data");

        setToken();

        commit("CLEAR_AUTH_DATA");
        commit("SET_AUTH_DATA");

        return router.push({
          name: "Login"
        });
      }
    },

    async logout({
      state,
      commit,
      rootState
    }) {
      try {
        rootState.loading.screen = true;
        await http.post("auth/logout", {
          au_id: state.userData["au_id"]
        });

        cookies.remove("access_token");
        cookies.remove("user_data");

        setToken();

        commit("CLEAR_AUTH_DATA");
        commit("SET_AUTH_DATA");

        return router.push({
          name: "Login"
        });
      } catch (err) {
        return catchHttp(err);
      } finally {
        rootState.loading.screen = false;
      }
    }
  }
}