<template>
  <div class="container-loading">
    <div class="loading-screen">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoadingScreen"
};
</script>

<style lang="scss">
.container-loading {
  position: fixed;
  z-index: 9999;
  display: flex;
  justify-content: center;
  width: 100%;
  height: 100vh;
  background-color: rgba($color: #000000, $alpha: 0.7);
}

.loading-screen {
  align-self: center;
  display: inline-block;
  position: relative;
  width: 80px;
  height: 60px;
}
.loading-screen div {
  animation: loading-screen 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  transform-origin: 40px 40px;
}
.loading-screen div:after {
  content: " ";
  display: block;
  position: absolute;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #fff;
  margin: -4px 0 0 -4px;
}
.loading-screen div:nth-child(1) {
  animation-delay: -0.036s;
}
.loading-screen div:nth-child(1):after {
  top: 63px;
  left: 63px;
}
.loading-screen div:nth-child(2) {
  animation-delay: -0.072s;
}
.loading-screen div:nth-child(2):after {
  top: 68px;
  left: 56px;
}
.loading-screen div:nth-child(3) {
  animation-delay: -0.108s;
}
.loading-screen div:nth-child(3):after {
  top: 71px;
  left: 48px;
}
.loading-screen div:nth-child(4) {
  animation-delay: -0.144s;
}
.loading-screen div:nth-child(4):after {
  top: 72px;
  left: 40px;
}
.loading-screen div:nth-child(5) {
  animation-delay: -0.18s;
}
.loading-screen div:nth-child(5):after {
  top: 71px;
  left: 32px;
}
.loading-screen div:nth-child(6) {
  animation-delay: -0.216s;
}
.loading-screen div:nth-child(6):after {
  top: 68px;
  left: 24px;
}
.loading-screen div:nth-child(7) {
  animation-delay: -0.252s;
}
.loading-screen div:nth-child(7):after {
  top: 63px;
  left: 17px;
}
.loading-screen div:nth-child(8) {
  animation-delay: -0.288s;
}
.loading-screen div:nth-child(8):after {
  top: 56px;
  left: 12px;
}
@keyframes loading-screen {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
