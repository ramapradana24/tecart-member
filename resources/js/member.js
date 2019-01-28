require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'

let Member = require('./components/admin/Member.vue')

const app = new Vue({
    el: '#app',
    components: {
        Member,
    }
})
