<template>
<div class="wrapper-login">
    <div class="row">
      <div class="left col-md-6 d-flex flex-column justify-content-center">
        <div class="container">
          <div
            class="form-login d-flex flex-column justify-content-center align-items-center"
          >
          <ValidationObserver v-slot="{ handleSubmit }">
            <form @submit.prevent="handleSubmit(submitLogin)">
              <h1 class="title text-center mb-2">Welcome Back</h1>
              <p class="desc text-center">
                Enter your credentials to access your account.
              </p>
              <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                <div class="form-group mt-5">
                  <input
                    type="email"
                    class="form-control"
                    placeholder="Enter Your Email"
                    v-model="authData.au_email"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <ValidationProvider name="Password" rules="required" v-slot="{ errors }">
                <div class="form-group mt-4">
                  <input
                    type="password"
                    class="form-control"
                    placeholder="Enter Your Password"
                    v-model="authData.au_password"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <div class="form-group">
                <button type="submit" class="btn main-button mt-4">
                  <span class="d-flex justify-content-center align-items-center">
                    Login
                  </span>
                </button>
              </div>
            </form>
          </ValidationObserver>
          <span class="my-4 text-muted">Forgot your password? <router-link to="/forgot-password">Reset Password</router-link></span>
          </div>
        </div>
      </div>
      <div class="right col-md-6 d-flex justify-content-center">
        <div class="img">
          <img src="../../../public/assets/img/team.png" alt="" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import {mapFields} from "vuex-map-fields";

import { extend } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';

extend('email', email);

// Override the default message.
extend('required', {
  ...required,
  message: 'This field is required'
});

export default {
  name: "Login",
  computed: {
    ...mapFields("auth", ["authData"])
  },
  created(){
    console.log(process.env.VUE_APP_BASE_URL);
  },
  methods: {
    ...mapActions("auth", ["login"]),
    async submitLogin(){
      const res = await this.login();

      if(res === 404){
        this.$fire({
          type: "warning",
          title: "Warning",
          text: "Username and Password cannot be empty"
        });
      } else if(res.status === 401){
        this.$fire({
          type: "warning",
          title: "Warning",
          text: "Username and passwird not match"
        });
      }
    }
  },
}
</script>