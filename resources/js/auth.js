require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let Register = require('./components/auth/Register.vue')
let Login = require('./components/auth/Login.vue')
import ForgetPass from './components/auth/ForgetPassword.vue';


const routes = [{
    path: '/register',
    component: Register
}, {
    path: '/login',
    component: Login
}, {
    path: '/forget-pass',
    component: ForgetPass
}]

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        Register,
        Login
    }
})
