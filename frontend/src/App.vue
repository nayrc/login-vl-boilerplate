<template>
  <div id="app">
  <!--
    <div id="nav">
      <router-link to="/">Dashboard</router-link>
    </div>
    -->
    <LoadingScreen v-if="loading.screen"/>
    <router-view />
  </div>
</template>

<script>
import { mapFields } from "vuex-map-fields";

import LoadingScreen from "./components/Loading/Screen";

export default {
  components: {
    LoadingScreen
  },
  computed: {
    ...mapFields(["loading"])
  }
}
</script>

<style lang="scss">
 @use "../public/assets/scss/main.scss";
</style>
