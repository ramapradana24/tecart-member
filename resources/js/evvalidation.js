require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let Validation = require('./components/event-validation/Validation.vue')
let DetailValidation = require('./components/event-validation/DetailValidation.vue')

const routes = [{
    path: '/event-validation',
    component: Validation
}, {
    path: '/event-validation/:id',
    name: 'detail',
    component: DetailValidation
}]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        Validation,
        DetailValidation
    }
})
