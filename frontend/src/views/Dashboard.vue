<template>
  <div class="dashboard">
    <div class="wrapper-dashboard">
      <h1 class="logo">
        <img alt="Vue logo" src="../assets/logo.png" style="width: 35px" />
      </h1>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="typograph my-5">
              <h1 class="typea">das Los Pantheone</h1> 
              <h1 class="text-capitalize">{{ userProfile.au_name }}</h1>
              
              <h1 class="typea">code für Berlin</h1> 

              <img src="../../public/assets/img/caleb-george-5sF6NrB1MEg-unsplash.jpg" alt="" class="w50">
            </div>
          </div>
          <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="logout">
              <form @submit.prevent="logout">
                <button type="submit" class="btn main-button ml-5">Logout</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import {mapFields} from "vuex-map-fields";

export default {
  name: "Dashboard",
  computed: {
    ...mapFields("auth", ["userData", "userProfile"])
  },
  async created() {
    await this.getProfile();
  },
  methods: {
    ...mapActions("auth", ["getProfile", "logout"]),
  },
};
</script>
