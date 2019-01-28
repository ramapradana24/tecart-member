require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let Findevent = require('./components/findevent/FindEvent.vue')
let SingleEvent = require('./components/findevent/SingleEvent.vue')

const routes = [{
    path: '/findevent',
    component: Findevent
}, {
    path: '/findevent/:id',
    component: SingleEvent
}]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        Findevent
    }
})
