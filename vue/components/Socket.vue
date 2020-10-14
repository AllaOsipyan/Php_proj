<template>
  <div class="socket">
    <input placeholder="item name" v-model="itemName" class="form-control">
    <button v-on:click="sendToSocket">Send</button>
  </div>
</template>

<script>
export default {
  name: "Socket.vue",
  data: function () {

    return {
      itemName: '',
      ws: ''
    }
  },
  created() {
    this.handshack()
  },
  methods: {
    handshack(){
      alert();
      this.ws = new WebSocket("ws://192.168.99.100:1337");
      this.ws.addEventListener("message", function(e) {
        console.log(e.data);
      })
    },
    sendToSocket() {
      try {
        this.ws.send(this.itemName);
      } catch (err) {
        console.log(err);
      }
    },

  },


}
</script>

<style scoped>

</style>