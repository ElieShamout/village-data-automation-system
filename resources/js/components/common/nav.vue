<template>
  <nav class="fixed-top">
    <router-link to="/persons" class="nav-item">الأشخاص</router-link>
    |
    <router-link to="/town-families" class="nav-item"
      >عائلات البلدة</router-link
    >
    |
    <!-- <router-link to="/displacedFamilies" class="nav-item"
      >العائلات النازحة</router-link
    >
    | -->
    <router-link :to="{ name: 'NewFamily' }" class="nav-item"
      >إضافة عائلة جديدة</router-link
    >
  </nav>
</template>

<script>
export default {};
</script>

<style>
nav {
  padding: 30px;
  background-color: #fff;
  background-color: rgba(230, 230, 230, 0.1) !important;
  backdrop-filter: blur(2px);
  /* box-shadow: 0 0 10px #000000a0; */
  border-bottom: 5px solid #dd2929;
  margin: 0 0 50px 0;
  text-align: center;
  z-index: 100000001 !important;
}

nav a {
  color: #2c3e50;
  margin: 0 10px;
  text-decoration: none;
  font-weight: bold;
}

nav a.router-link-exact-active {
  background-color: #dd2929;
  padding: 10px;
  border-radius: 5px;
  box-shadow: 0 0 4px #00000050;
  color: rgb(255, 255, 255);
}
</style>