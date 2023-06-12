<template>
  <router-link
    class="btn btn-primary"
    :to="{
      name: 'NewPerson',
      params: {
        family_id: family_id,
      },
    }"
  >
    <!-- <i class="bi bi-person-plus-fill"></i> -->
    إضافة فرد جديد
  </router-link>
</template>
  
<script>
export default {
  props: {
    family_id: {
      type: String,
    },
  },
};
</script>
  
<style scoped>
</style>