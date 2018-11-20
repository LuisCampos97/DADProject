/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const itemList = Vue.component('item-list', require('./components/itemList.vue'));
const login = Vue.component('login', require('./components/auth/login.vue'));
const logout = Vue.component('logout', require('./components/auth/logout.vue'));
const dashboard = Vue.component('dashboard', require('./components/dashboard.vue'));

const routes = [{
        path: '/',
        component: itemList,
        name: 'index'
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },
    {
        path: '/logout',
        component: logout,
        name: 'logout'
    },
    {
        path: '/dashboard',
        component: dashboard,
        name: 'dashboard'
    }
];

const router = new VueRouter({
    routes: routes
});

const app = new Vue({
    router,
    el: '#app',
    data: {
        loggedIn: undefined,
    }
});
