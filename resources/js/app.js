require('./bootstrap');

window.Vue = require('vue');

import Fragment from 'vue-fragment';
Vue.use(Fragment.Plugin);

import CounterComponent from './components/MessageCounter.vue';
Vue.component('counter', CounterComponent);
import ChatComponent from './components/Chat.vue';
Vue.component('chat', ChatComponent);


const app = new Vue({
    el: '#app'
});
