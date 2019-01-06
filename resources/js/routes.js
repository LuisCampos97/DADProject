/*jshint esversion: 6 */
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import ItemList from './components/itemList.vue';
import Login from './components/auth/login.vue';
import Dashboard from './components/dashboard.vue';
import Profile from './components/auth/profile.vue';
import RegisterWorker from './components/auth/RegisterWorker.vue';
import InvoiceDetails from './components/cashier/InvoiceDetails.vue';
import MenuItemsManage from './components/manager/MenuItemsManage.vue';
import TablesManage from './components/manager/TablesManage.vue';
import InvoiceManage from './components/manager/InvoiceManage.vue';
import MealManage from './components/manager/MealManage.vue';
import UserManage from './components/manager/UserManage.vue';

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
    },
    {
        path: '/tablesManage',
        component: TablesManage,
        name: 'tablesManage'
    },
    {
        path: '/menuItemsManage',
        component: MenuItemsManage,
        name: 'menuItemsManage'
    },
    {
        path: '/invoiceManage',
        component: InvoiceManage,
        name: 'invoiceManage'
    },
    {
        path: '/mealManage',
        component: MealManage,
        name: 'mealManage'
    },
    {
        path: '/userManage',
        component: UserManage,
        name: 'userManage'
    }
];

export default routes;
