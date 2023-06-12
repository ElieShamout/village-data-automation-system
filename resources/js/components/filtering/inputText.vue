<template>
  <input
    type="text"
    class="form-control"
    :placeholder="placeholder"
    @keyup="event"
    :dir="dir"
  />
</template>

<script>
export default {
  props: {
    name: String,
    placeholder: String,
    dir: String,
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