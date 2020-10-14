<template>
<div>
  <div>
    <h5> Access Token</h5>
    <input class="form-control" v-model="token">
  </div>
  <br>
  <div >
    <h2> Send telemetry</h2>
    <input class="form-control" placeholder="for example: temp=12" v-model="telemetry">
    <button v-on:click="send">send</button>
    <table class="table">
      <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">values</th>
        <th scope="col">create time</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(item) in this.savedItems">
        <td>{{item.id}}</td>
        <td>{{item.name}}</td>
        <td>{{item.value}}</td>
        <td>{{item.time}}</td>
      </tr>
      </tbody>
    </table>
  </div>
  <div class="api-get">
    <h2> Find telemetry</h2>
    <input placeholder="item name" v-model="itemName" class="form-control">
    <button v-on:click="get">Find</button>



    <table class="table">
      <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">values</th>
        <th scope="col">creation time</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(article) in allArticles">
        <td>{{article.id}}</td>
        <td>{{article.name}}</td>
        <td>{{article.value}}</td>
        <td>{{article.time}}</td>
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
        telemetry: '',
        itemName: '',
        savedItems:[],
        allArticles: []
      }
  },
  methods: {
    async get(){

      axios
          .get('http://192.168.99.100:8500/api/telemetries',
                {
                    params: {
                           name1: this.itemName
                    },
                    headers: {
                      'Authorization': 'Bearer '+this.token,
                    }
                } )
          .then(response => {
            this.allArticles = response.data;
          })
          .catch(error => console.log(error));
    },
    send: function (event){
      this.name = this.telemetry.split('=')[0]
      this.value = this.telemetry.split('=')[1]
      axios
          .post('http://192.168.99.100:8500/api/telemetries', {name: this.name, value:this.value},
              {headers: {'Authorization': 'Bearer '+this.token}
          })
          .then(response => (this.savedItems = response.data))
          .catch(error => console.log(error));

    }

  }

}
</script>

<style scoped>

</style>