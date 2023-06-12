<template>
  <input
    type="number"
    class="form-control"
    :placeholder="placeholder"
    @keyup="event"
  />
</template>
  
  <script>
export default {
  props: {
    name: String,
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