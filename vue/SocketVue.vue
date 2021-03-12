<template>
  <div class="ap">
    <socket></socket>
  </div>
</template>

<script>
import Socket from "./components/Socket";
export default {
  name: "SocketVue",
  components: {
    'socket': Socket
  },
}
</script>

<style scoped>

</style>