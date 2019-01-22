require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'

let Event = require('./components/admin/Event.vue')

const app = new Vue({
    el: '#app',
    components: {
        Event,
    }
})
