<template>
<div>
  <div>
    <div class="error">{{this.error}}</div>
    <h5> Access Token</h5>
    <label>
      <input class="form-control" v-model="token">
    </label>
  </div>
  <br>
  <div >
    <h2> Send telemetry</h2>
    <label>
      <div> Name</div>
        <input class="form-control" v-model="telemetryName">
      <div> Value </div>
        <input class="form-control" v-model="telemetryValue">
    </label>
    <button v-on:click="send">send</button>
    <div v-if="telemetryId!==''">Telemetry was added with id: {{this.telemetryId}}</div>
    <div class="error" v-if="this.accessError!==''">{{this.accessError}}</div>
  </div>
  <div class="api-get">
    <h2> Find telemetry</h2>
    <label>
      <input placeholder="item name" v-model="itemName" class="form-control">
    </label>
    <button v-on:click="get">Find</button>

    <table v-if="selectedTelemetries.length!==0" class="table">
      <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">values</th>
        <th scope="col">creation time</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(telemetry) in selectedTelemetries">
        <td>{{telemetry.id}}</td>
        <td>{{telemetry.name}}</td>
        <td>{{telemetry.value}}</td>
        <td>{{telemetry.time}}</td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
import axios from "axios";

export default {
  name: "RestGet",
  data: function () {

      return {
        token: '',
        telemetryName: '',
        telemetryValue:'',
        itemName: '',
        telemetryId: '',
        selectedTelemetries: [],
        error:'',
        accessError:'',

      }
  },
  methods: {

    async get(){
      this.error = '';
      this.selectedTelemetries = [];
      if(this.token===''){
        this.error = "Token is required";
      }
      else if(this.itemName===''){
        this.error = "Field Name is required";
      }
      else if(this.itemName!=='') {

        axios
            .get('http://localhost:8500/api/telemetries',
                {
                  params: {
                    name1: this.itemName
                  },
                  headers: {
                    'Authorization': 'Bearer ' + this.token,
                  }
                })
            .then(response => {
              this.selectedTelemetries = response.data;
              if(this.selectedTelemetries.length===0)
                this.error = "Telemetries are not found"

            })
            .catch(error => console.log(error));
      }
    },
    send: function (event){
      this.error = '';
      if(this.token===''){
        this.error = "Field is required";
      }
      else if(this.telemetryName===''|| this.telemetryValue===''){
        this.error = "Field Name and Value is required";
      }
      else if(this.telemetryName !== '' && this.telemetryValue !== '') {
        axios
            .post('http://localhost:8500/api/telemetries', {name: this.telemetryName, value: this.telemetryValue},
                {
                  headers: {'Authorization': 'Bearer ' + this.token}
                })
            .then(response => {

              if(response.data!==null)
                this.telemetryId = response.data.id;

            })
            .catch(error =>{
              this.error = "Access is denied. Check your status and token."
        });
      }
    },
  }
}
</script>

<style scoped>
.error{
  color: red;

}
</style>