<template>
  <input type="date" class="form-control" @input="event" />
</template>

<script>
import { ref } from "vue";
export default {
  setup(props, context) {
    function event(date) {
      context.emit("inputData", date.target.value);
    }

    return { event };
  },
};
</script>


<style>
</style>