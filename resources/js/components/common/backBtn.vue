<template>
  <div class="btn btn-secondary back-btn" @click="this.$router.go(-1)">
    عودة للخلف
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.back-btn {
  color: white;
  position: relative;
  z-index: 1000000;
}
</style>