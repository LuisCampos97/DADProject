/*jshint esversion: 6 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueSocketio from 'vue-socket.io';
Vue.use(new VueSocketio({
    debug: true,
    connection: 'http://192.168.10.1:8080'
}));

import store from './stores/global-store';
import routes from './routes';

//config axios
axios.defaults.headers.common['Accept'] = "application/json";
axios.defaults.headers.common['Authorization'] = sessionStorage.getItem('access_token');
axios.defaults.headers.common['Content-Type'] = "application/json";

Vue.component('master', require('./components/Master.vue'));
Vue.component('item-list', require('./components/ItemList.vue'));

Vue.component('login', require('./components/auth/Login.vue'));
Vue.component('registerWorker', require('./components/auth/RegisterWorker.vue'));
Vue.component('profile', require('./components/auth/Profile.vue'));
Vue.component('edit-user', require('./components/auth/UserEdit.vue'));

Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('dashboardWaiter', require('./components/waiter/dashboardWaiter.vue'));
Vue.component('dashboardCook', require('./components/cook/DashboardCook.vue'));
Vue.component('dashboardCashier', require('./components/cashier/DashboardCashier.vue'));
Vue.component('userManage', require('./components/manager/UserManage.vue'));
Vue.component('menuItemsManage', require('./components/manager/MenuItemsManage.vue'));
Vue.component('edit-menuitem', require('./components/manager/MenuItemEdit.vue'));
Vue.component('add-menuitem', require('./components/manager/MenuItemAdd.vue'));
Vue.component('tablesManage', require('./components/manager/TablesManage.vue'));
Vue.component('user-editManager', require('./components/manager/UserEditManager.vue'));

Vue.component('registerMeal', require('./components/waiter/registerMeal.vue'));
Vue.component('registerOrder', require('./components/waiter/registerOrder.vue'));
Vue.component('orderItems', require('./components/waiter/orderItems.vue'));

Vue.component('invoiceDetails', require('./components/cashier/InvoiceDetails.vue'));
Vue.component('pay-invoice', require('./components/cashier/PayInvoice.vue'));

Vue.component('MealManage', require('./components/manager/MealManage.vue'));
Vue.component('InvoiceManage', require('./components/manager/InvoiceManage.vue'));

Vue.component('pagination', require('laravel-vue-pagination'));

const router = new VueRouter({
    routes
});

/*router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        //Check if logged in
        //if (!store.getters.loggedIn) {
            //next("/login");
        //} else {
            next();
        //}
    } else {
        next();
    }
}); */

new Vue({
    router,
    store,
    created() {
        this.$store.commit('loadTokenAndUserFromSession');
    },
    template: '<master/>'
}).$mount('#app');
