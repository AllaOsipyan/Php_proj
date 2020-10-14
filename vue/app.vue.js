import Vue from 'vue';
import App from './App.vue';
import Socket from './SocketVue.vue';

new Vue({
    el:'#app',
    render:h=>h(App)
})

new Vue({
    el:'#socket',
    render:h=>h(Socket)
})