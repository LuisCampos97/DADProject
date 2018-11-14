/*jshint esversion: 6 */

require('./bootstrap');

window.Vue = require('vue');

const itemList = Vue.component('item-list', require('./components/itemList.vue'));

const app = new Vue({
    el: '#app',
    data: {
        title: 'Menu List'
    },
    methods: {
    },
    mounted() {
    }
});
