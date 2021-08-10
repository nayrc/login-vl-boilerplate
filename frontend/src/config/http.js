import axios from "axios";
import cookies from "vue-cookies";

import router from "../router";

const baseUrl = process.env.VUE_APP_BASE_URL,
  baseUrlAPI = `${process.env.VUE_APP_BASE_URL}`;

const http = axios.create({
  baseURL: baseUrlAPI
});

function setToken(token) {
  token ? (token = `Bearer ${token}`) : (token = "");

  http.defaults.headers.common["Authorization"] = token;
}

function catchHttp(err) {
  if (err.response) {
    const arrStatus = [400, 401, 404, 409, 422],
      status = err.response.status,
      url = err.response.config.url;

    if (status && arrStatus.includes(status)) {
      if (status === 401 && url != "auth/login") {
        cookies.remove("access_token");
        cookies.remove("user_data");

        setToken();

        return router.push({
          name: "Login"
        });
      }
      return err.response;
    }
  }
  return alert(err);
}

export {
  baseUrl,
  baseUrlAPI,
  http,
  setToken,
  catchHttp
};