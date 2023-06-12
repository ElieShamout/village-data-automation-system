<template>
  <Nav />
  <div class="container app-content">
    <router-view />
  </div>
</template>
<script>
import Nav from "../components/common/nav.vue";
export default {
  components: { Nav },
};
</script>
<style scoped>
.app-content {
  margin-top: 120px;
}
</style>