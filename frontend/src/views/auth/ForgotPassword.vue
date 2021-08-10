<template>
<div class="wrapper-login">
    <div class="row">
      <div class="left col-md-6 d-flex flex-column justify-content-center">
        <div class="container">
          <div
            class="form-login d-flex flex-column justify-content-center align-items-center"
          >
          <ValidationObserver v-slot="{ handleSubmit }" v-if="!inputCodeOtp">
            <form @submit.prevent="handleSubmit(submitForgotPassword)">
              <h1 class="title text-center mb-2">Reset Password</h1>
              <p class="desc text-center">
                Enter your email, you will be sent OTP-CODE.
              </p>
              <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                <div class="form-group mt-5">
                  <input
                    type="email"
                    class="form-control"
                    placeholder="Enter Your Email" 
                    v-model="forgotPasswordData.au_email"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <div class="form-group">
                <button type="submit" class="btn main-button mt-4">
                  <span class="d-flex justify-content-center align-items-center">
                    Send Code
                  </span>
                </button>
              </div>
            </form>
          </ValidationObserver>
          <ValidationObserver v-slot="{ handleSubmit }" v-else>
            <form @submit.prevent="handleSubmit(submitCheckCodeOtp)">
              <h1 class="title text-center mb-2">Reset Password</h1>
              <p class="desc text-center">
                Enter OTP CODE
              </p>
              <ValidationProvider name="Email" rules="email" v-slot="{ errors }">
                <div class="form-group mt-5">
                  <input
                    type="email"
                    class="form-control"
                    placeholder="Enter Your Email" 
                    v-model="checkCodeOtpData.au_email"
                    disabled
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
                 <ValidationProvider name="OTP Code" rules="required" v-slot="{ errors }" v-if="inputCodeOtp">
                <div class="form-group mt-4">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Enter Your OTP Code"
                    v-model="checkCodeOtpData.au_2fa"
                  />
                  <span class="text-danger">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <div class="form-group">
                <button type="submit" class="btn main-button mt-4">
                  <span class="d-flex justify-content-center align-items-center">
                    Check OTP Code
                  </span>
                </button>
              </div>
            </form>
          </ValidationObserver>
          <span class="my-4 text-muted"><router-link to="/login">Back</router-link></span>
          <b-modal id="modal-1" title="Reset Password" hide-footer centered>
            <span class="text-muted text-center">Your OTP code will be lost if you have reset your password</span>
            <ValidationObserver v-slot="{ handleSubmit }">
              <form @submit.prevent="handleSubmit(submitResetPassword)">
                <ValidationProvider name="Email" rules="email" v-slot="{ errors }">
                  <div class="form-group mt-3">
                    <input
                      type="email"
                      class="form-control"
                      placeholder="Enter Your Email" 
                      v-model="resetPasswordData.au_email"
                      disabled
                    />
                    <span class="text-danger">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>
                  <ValidationProvider name="OTP Code" rules="required" v-slot="{ errors }" v-if="inputCodeOtp">
                  <div class="form-group mt-4">
                    <input
                      type="password"
                      class="form-control"
                      placeholder="Enter your new password"
                      v-model="resetPasswordData.au_password"
                    />
                    <span class="text-danger">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>
                <div class="form-group">
                  <button type="submit" class="btn main-button mt-4">
                    <span class="d-flex justify-content-center align-items-center">
                      Reset Now
                    </span>
                  </button>
                </div>
              </form>
            </ValidationObserver>
          </b-modal>
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
import { mapActions } from "vuex";
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
  data(){
    return{
      inputCodeOtp: false
    }
  },
  computed: {
    ...mapFields("auth", ["forgotPasswordData", "checkCodeOtpData", "resetPasswordData"])
  },
  methods: {
    ...mapActions("auth", ["forgotPassword", "checkCodeOtp", "resetPassword"]),
    async submitForgotPassword(){
      const res = await this.forgotPassword();
      this.inputCodeOtp = true;
      if(res === 200){
         this.$fire({
          type: "success",
          title: "Success",
          text: "OTP Code Sended"
        });
      } else{
         this.$fire({
          type: "error",
          title: "Error",
          text: "Email not find"
        });
      }
    },
    async submitCheckCodeOtp(){
      const res = await this.checkCodeOtp();
      if(res === 200){
         this.$fire({
          type: "success",
          title: "Success",
          text: "OTP Code Match"
        });
        return setTimeout(() => {
          this.$bvModal.show("modal-1");
        }, 2000);
      } else {
         this.$fire({
          type: "error",
          title: "Error",
          text: "OTP Code not match"
        });
      }
    },
    async submitResetPassword(){
      const res = await this.resetPassword();
      if(res === 200){
         this.$fire({
          type: "success",
          title: "Success",
          text: "Password Changed"
        });
        this.$router.push({ name: "Login" });
      }
    }
  },
}
</script>