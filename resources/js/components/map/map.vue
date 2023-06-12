<template>
  <MapboxMap
    style="height: 300px"
    map-style="mapbox://styles/mapbox/streets-v11"
    access-token="pk.eyJ1IjoiZWxpLXNoYW1vdXQiLCJhIjoiY2t0bzFydjEzMDhmcDJybDRqOWQ2NW4xOCJ9.BOhDGTM6J1cBUPFfH5RvjQ"
    :center="mapCenter"
    :zoom="1"
  />
</template>

<script>
import { ref } from "vue";
import { MapboxMap } from "@studiometa/vue-mapbox-gl";
import "mapbox-gl/dist/mapbox-gl.css";
export default {
  components: { MapboxMap },
  setup() {
    const apikey =
      "pk.eyJ1IjoiZWxpLXNoYW1vdXQiLCJhIjoiY2t0bzFydjEzMDhmcDJybDRqOWQ2NW4xOCJ9.BOhDGTM6J1cBUPFfH5RvjQ";

    const mapCenter = ref([35.0606388, 36.6901181]);
    return { apikey, mapCenter };
  },
};
</script>

<style>
</style>