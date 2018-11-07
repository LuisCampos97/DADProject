/*jshint esversion: 6 */

require('./bootstrap');

window.Vue = require('vue');

const itemList = Vue.component('item-list', require('./components/itemList.vue'));

const app = new Vue({
    el: '#app',
    data: {
        title: 'Menu',
        items: [],
    },
    methods: {
        getImage: function (url) {
            var imgSrc = String(url);
            return 'items/' + imgSrc;
        },
        getItems: function () {
            axios.get('api/items')
                .then(response => {
                    this.items = response.data.data;
                });
        }
    },
    mounted() {
        this.getItems();
    }
});
