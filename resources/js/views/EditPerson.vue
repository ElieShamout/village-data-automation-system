<template>
  <div class="d-flex justify-content-between">
    <PageTitle pageTitle="تعديل بيانات العائلة" />
    <div class="">
      <BackBtn />
    </div>
  </div>
</template>

<script>

</script>

<style scoped>
.input-field {
  margin: 0 0 10px 0;
}
.input-field label {
  font-weight: 600;
}
.exclamation-mark {
  font-size: 60px;
}

.other-info-title {
  font-weight: 600;
}
.diseasesTable {
  /* border: 2px solid #dd2929; */
  overflow: hidden !important;
  width: 80%;
  margin: 0 auto 30px auto;
}
.diseaseBtn {
  font-size: 25px;
  background: #0074d9;
  color: white;
  box-shadow: 0 0 2px #000000a0;
  border-radius: 5px;
  width: 35px;
  height: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transform: scale(1);
}
.diseaseBtn:hover {
  animation: diseaseBtn 1s linear 0s infinite alternate;
}
.removeDis {
  cursor: pointer;
}
@keyframes diseaseBtn {
  from {
    transform: scale(1);
  }
  to {
    transform: scale(1.15);
  }
}

.adjectiveTable {
  overflow: hidden !important;
  width: 80%;
  margin: 0 auto 30px auto;
}
.cursorPointer {
  cursor: pointer;
}
</style>