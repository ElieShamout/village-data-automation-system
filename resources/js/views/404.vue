<template>
  <div class="container d-flex align-items-center justify-content-center">
    <div class="not-fount text-center">
      <!-- <div class="icon">
        <i class="bi bi-exclamation-circle-fill"></i>
      </div> -->
      <h1 class="errorText">
        <i class="bi bi-exclamation"></i>
        الصفحة المطلوبة غير موجودة
        <i class="bi bi-exclamation"></i>
      </h1>
    </div>
  </div>
  <div class="d-flex justify-content-end">
    <BackBtn />
  </div>
</template>

<script>
import BackBtn from "../components/common/backBtn.vue";

export default {
  components: { BackBtn },
};
</script>

<style scoped>
.container {
  min-height: 70vh;
}
.errorText {
  color: rgba(244, 255, 28);
  color: rgb(255, 28, 28);
  text-shadow: 0 0 10px #00000050;
}
</style>