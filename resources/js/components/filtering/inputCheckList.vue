<template>
  <select class="form-select" @chenge="event" dir="ltr">
    <option value="">{{ placeholder }}</option>
    <option v-for="option in 25" :value="option" :key="option">
      {{ option }}
    </option>
  </select>
</template>

<script>
export default {
  props: {
    placeholder: String,
  },
  setup(props, context) {
    const event = (ele) => {
      context.emit("inputData", ele.target.value);
    };

    return { event };
  },
};
</script>

<style>
</style>