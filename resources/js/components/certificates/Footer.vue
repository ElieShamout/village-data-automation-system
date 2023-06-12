<template>
  <div class="certificate-footer" dir="rtl">
    <div class="grant-date mt-4">كفربهم في {{ grant_date }} م</div>
    <div class="parish-name mt-4">مكتب رعيّة كفربهم</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      grant_date: this.getTodayDate(),
    };
  },
  methods: {
    getTodayDate() {
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = today.getFullYear();

      return yyyy + "/" + dd + "/" + mm;
    },
  },
};
</script>

<style scoped>
.certificate-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 30px 0 0 0;
  position: absolute;
  bottom: 30px;
  left: 0;
  right: 0;
  padding: 0 60px;
}
.grant-date,
.parish-name {
  font-size: 18px;
}
</style>