<template>
  <div class="socket">
    <div class="error" >{{this.error}}</div>
    <div class="form">
      <div class="add-telemetry">
        <h2> Send telemetry</h2>
      <label>
        <div> Name</div>
        <input v-model="telemetryName" class="form-control">
        <div> Value</div>
        <input v-model="telemetryValue" class="form-control">
      </label>
      <button v-on:click="createTelemetry()">Send</button>
      </div>
      <div class="find-telemetry">
        <h2> Find telemetry</h2>
        <label>
          <div> Name</div>
          <input v-model="itemName" class="form-control">
        </label>
        <button v-on:click="findTelemetry()">Send</button>
      </div>
    </div>
    <div>Recently reviewed:</div>
    <ul id="createdMessages"></ul>
  </div>
</template>

<script>
export default {
  name: "Socket.vue",
  data: function () {

    return {
      telemetryName: '',
      telemetryValue: '',
      itemName: '',
      ws: '',
      error:''
    }
  },
  created() {
    this.handshack()
  },
  methods: {
    handshack() {
      this.ws = new WebSocket("ws://localhost:1337/multicast");
      this.ws.addEventListener("message", function (e) {

        let list = document.getElementById("createdMessages");
        let listItem = document.createElement('li');
        listItem.className = 'delayed';
        listItem.textContent = e.data;
        list.append(listItem);
        while (list.children.length > 5) {
          list.removeChild(list.firstChild);
        }

      });
    },
    findTelemetry() {
      this.error='';
      if(this.itemName===''){
        this.error = "Field Name is required"
      }
      else{
        try {
          this.ws.send("GET^^" + this.itemName);

        } catch (err) {
          console.log(err);
        }
      }
    },
    createTelemetry() {
      this.error='';
      if(this.telemetryName==='' || this.telemetryValue==='') {
        this.error = "Field Name and Value is required"
      }
      else{
        try {
          this.ws.send("POST^^" + this.telemetryName + "@@@" + this.telemetryValue);
        } catch (err) {
          this.error = "Access denied. Check your status."
        }
      }
    },
  }

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
.error{
  color: red;
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
.form{
  display: flex;
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