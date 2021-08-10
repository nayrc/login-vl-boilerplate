import cookies from "vue-cookies";
import {
  setToken
} from "../config/http";

function checkToken() {
  let token = cookies.get("access_token"),
    access = false;

  setToken(token);
  token ? (access = true) : (access = false);

  return access;
}

function authenticated(to, from, next) {
  checkToken() ? next() : next({
    name: "Login"
  });
}

function unauthenticated(to, from, next) {
  checkToken() ? next({
    name: "Dashboard"
  }) : next();
}

export {
  checkToken,
  authenticated,
  unauthenticated
};