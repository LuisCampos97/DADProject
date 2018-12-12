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
Vue.component('logout', require('./components/auth/Logout.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('profile', require('./components/Profile.vue'));
Vue.component('registerWorker', require('./components/RegisterWorker.vue'));

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
