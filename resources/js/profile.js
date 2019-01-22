require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'

let Profile = require('./components/profile/Profile.vue')

const app = new Vue({
    el: '#app',
    components: {
        Profile
    }
})
