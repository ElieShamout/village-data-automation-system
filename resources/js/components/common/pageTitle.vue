<template>
  <h1 class="page-title">{{ pageTitle }}</h1>
</template>
<script>
export default {
  props: {
    pageTitle: {
      type: String,
      default: "عنوان الصفحة",
    },
  },
};
</script>
<style scoped>
</style>