<template>
  <div class="ap">
    <rest-api></rest-api>
  </div>

</template>

<script>
  import Rest from "./components/Rest";

  export default {
    components: {
      'rest-api':Rest,

    },
    name: "App",

  }

</script>

<style scoped>

</style>