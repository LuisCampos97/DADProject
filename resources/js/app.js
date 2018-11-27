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

import store from './stores/global-store';

const itemList = Vue.component('item-list', require('./components/itemList.vue'));
const login = Vue.component('login', require('./components/auth/login.vue'));
const logout = Vue.component('logout', require('./components/auth/logout.vue'));
const dashboard = Vue.component('dashboard', require('./components/dashboard.vue'));
const profile = Vue.component('profile', require('./components/profile.vue'));

<<<<<<< HEAD
const routes = [
    { path: '/', component: itemList, name: 'index' },
    { path: '/login', component: login, name: 'login' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/dashboard', component: dashboard, name: 'dashboard' },
=======
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
    },
    {
        path: '/profile',
        component: profile,
        name: 'profile'
    }
>>>>>>> 64d67ff05ee676b4386bf6c75a78b78928328763
];

const router = new VueRouter({
    routes: routes
});

router.beforeEach((to, from, next) => {
    if ((to.name == 'profile') || (to.name == 'logout')) {
        if (!store.state.user) {
            next("/login");
            return;
        }
    }
    next();
});

const app = new Vue({
    router,
    data: {
        loggedIn: undefined,
    },
    store,
    created() {
        console.log('-----');
        console.log(this.$store.state.user);
        this.$store.commit('loadTokenAndUserFromSession');
        console.log(this.$store.state.user);
    }
}).$mount('#app');
