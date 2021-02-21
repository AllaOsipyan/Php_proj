<template>
  <div class="socket">
    <label>
      <input placeholder="item name" v-model="itemName" class="form-control">
    </label>
    <button v-on:click="sendToSocket">Send</button>
    <div>You recently sent:</div>
    <ul id="messages"></ul>
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
      this.ws = new WebSocket("ws://localhost:1337/multicast");
      this.ws.addEventListener("message", function(e) {
        let list = document.getElementById("messages");
        let listItem = document.createElement('li');
        listItem.className = 'delayed';
        listItem.textContent = e.data;
        console.log(e.data);
        list.append(listItem);

        while (list.children.length > 5) {
          list.removeChild(list.firstChild);
        }
      });

    },
    sendToSocket() {
      try {
          console.log(this.itemName);
          this.ws.send(this.itemName);

      } catch (err) {
        console.log(err);
      }
    },







    example(){
      console.log("I'm fine");

      var ws = new WebSocket("ws://localhost:1337/broadcast");

      // append all received messages to #messages
      ws.addEventListener("message", function(e) {
        console.log(e.data);

        var listItem = document.createElement('li');
        listItem.className = 'delayed';
        listItem.textContent = e.data;

        list.append(listItem);

        while (list.children.length > 5) {
          list.removeChild(list.firstChild);
        }
      });

      input.addEventListener('keyup', function (e) {
        if (e.keyCode === 13) {
          e.preventDefault();

          ws.send(e.target.value);
          e.target.value = "";
          e.target.focus();
        }
      });
    }
  },


}
</script>

<style>
* { padding: 0; margin: 0; box-sizing: border-box; }
body { font-size: 14px; font-family: sans-serif; display: flex; height: 100vh; flex-direction: column; box-sizing: border-box; padding: 50px; }

input[type=text] {
  line-height: 34px;
  height: 34px;
  border: 2px solid #ccc;
  background: white;
  border-radius: 4px;
  padding: 0 10px;
}

input[type=text]:focus {
  border-color: #08e;
  outline: 0;
}

#messages { flex: 1 1 auto; list-style: none; }
#messages > li { margin: 0 20px; padding: 20px; border-bottom: 1px solid #ccc; }
#messages > li:last-child { border-bottom: 0; }

#messages {
  list-style-type: none;
  display: block;
  padding-left: 0;
  width: 100%;
  margin: 0 auto;
}

#messages li {
  border-bottom: 1px solid #eee;
  margin-bottom: 5px;
  padding: 5px 0 5px 0;
}

.delayed {
  -webkit-animation: fadein 1000ms;
  -moz-animation: fadein 1000ms;
  -ms-animation: fadein 1000ms;
  -o-animation: fadein 1000ms;
  animation: fadein 1000ms;
}

/* http://stackoverflow.com/a/11681331/2373138 */
@keyframes fadein {
  from { opacity: 0; }
  to   { opacity: 1; }
}

/* Firefox < 16 */
@-moz-keyframes fadein {
  from { opacity: 0; }
  to   { opacity: 1; }
}

@-webkit-keyframes fadein {
  from { opacity: 0; }
  to   { opacity: 1; }
}

@-ms-keyframes fadein {
  from { opacity: 0; }
  to   { opacity: 1; }
}

@-o-keyframes fadein {
  from { opacity: 0; }
  to   { opacity: 1; }
}
</style>