require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
let Myevent = require('./components/myevent/MyEvent.vue')

const app = new Vue({
    el: '#app',
    components: {
        Myevent
    }
})
