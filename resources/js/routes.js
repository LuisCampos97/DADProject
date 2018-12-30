/*jshint esversion: 6 */
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ItemList from './components/ItemList.vue';
import Login from './components/auth/Login.vue';
import Dashboard from './components/Dashboard.vue';
import Profile from './components/auth/Profile.vue';
import RegisterWorker from './components/auth/RegisterWorker.vue';
import InvoiceDetails from './components/cashier/InvoiceDetails.vue';

const routes = [{
    path: '/',
    component: ItemList,
    name: 'home'
},
{
    path: '/login',
    component: Login,
    name: 'login',
    meta: {
        requiresAuth: false
    }
},
{
    path: '/dashboard',
    component: Dashboard,
    name: 'dashboard',
    meta: {
        requiresAuth: true
    }
},
{
    path: '/profile',
    component: Profile,
    name: 'profile',
    meta: {
        requiresAuth: true
    }
},
{
    path: '/registerWorker',
    component: RegisterWorker,
    name: 'registerWorker',
    meta: {
        requiresAuth: true
    }
},
{
    path: '/invoices/:id',
    component: InvoiceDetails,
}
];

export default routes;
