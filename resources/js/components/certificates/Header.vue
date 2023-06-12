<template>
  <div class="certificate-header" dir="rtl">
    <div class="item cathedral-name">
      <img
        src="../../../assets/Cathedral-name-transparent-1.png"
        alt=""
        srcset=""
      />
    </div>
    <div class="item crown">
      <img src="../../../assets/Crown-transparent.png" alt="" srcset="" />
    </div>
    <div class="item parish-name">رعيّة كفربهم</div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap");

.certificate-header {
  font-family: "Cairo", sans-serif !important;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #000;
}
.cathedral-name img {
  width: 120px;
}
.crown img {
  width: 100px;
}
.parish-name {
  font-size: 25px;
  font-weight: 600;
}
</style>