<template>
<div class="jumbotron" v-if="user.type == 'waiter'">
    <button @click.prevent="invertShift()">Add Meal</button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>table_number</th>
                <th>state</th>
                <th>start</th>
                <th>total_price_preview</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="order in orders" :key="order.id">
                <td>{{ order.table_number }}</td>
                <td>{{ order.state }}</td>
                <td>{{ order.start }}</td>
                <td>{{ order.price_preview }}</td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
module.exports = {
    data: function () {
        return {
            orders: [],
            meals: []
        };
    },
    computed: {
        user() {
            return this.$store.state.user;
        }
    },
    methods: {
        addMeal: function () {

        },
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.items = response.data.data;
            });
        },
        getOrders: function () {
            axios.get("api/orders").then(response => {
                this.items = response.data.data;
            });
        }
    }
};
</script>
