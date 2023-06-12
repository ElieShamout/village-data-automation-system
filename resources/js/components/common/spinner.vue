<template>
  <div class="spinner">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</template>

<script>
export default{
  setup(){}
}
</script>

<style scoped>
.spinner {
  width: 100vw;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  display: flex;
  align-items: center;
  justify-content: center;
}
.spinner-border {
  width: 100px;
  height: 100px;
}
</style>