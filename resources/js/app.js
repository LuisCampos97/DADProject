/*jshint esversion: 6 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import store from './stores/global-store';
import routes from './routes';

Vue.component('master', require('./components/Master.vue'));
Vue.component('item-list', require('./components/ItemList.vue'));

Vue.component('login', require('./components/auth/Login.vue'));
Vue.component('registerWorker', require('./components/auth/RegisterWorker.vue'));
Vue.component('profile', require('./components/auth/Profile.vue'));
Vue.component('edit-user', require('./components/auth/UserEdit.vue'));

Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('dashboardWaiter', require('./components/dashboardWaiter.vue'));
Vue.component('dashboardCook', require('./components/cook/DashboardCook.vue'));
Vue.component('dashboardCashier', require('./components/cashier/DashboardCashier.vue'));

Vue.component('registerMeal', require('./components/waiter/registerMeal.vue'));
Vue.component('registerOrder', require('./components/waiter/registerOrder.vue'));
Vue.component('orderItems', require('./components/waiter/orderItems.vue'));

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
