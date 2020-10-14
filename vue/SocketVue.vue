<template>
  <div class="ap">
    <h2> Send telemetry</h2>
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