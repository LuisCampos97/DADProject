<template>
<div class="jumbotron" v-if="user.type == 'waiter'">
    <button @click.prevent="registerMeal()">Register Meal</button>
    
    <registerMeal :registeringMeal="registeringMeal" @cancel-Meal="cancelMeal"></registerMeal>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Table Number</th>
                <th>State</th>
                <th>Start</th>
                <th>Total Price Preview</th>
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
            registeringMeal: false,
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
        registerMeal: function () {
            this.registeringMeal = true;
        },
        cancelMeal: function () {
            this.$emit("cancel-Meal");
        },
        addMeal: function () {

        },
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.meals = response.data.data;
            });
        },
        getOrders: function () {
            axios.get("api/orders").then(response => {
                this.orders = response.data.data;
            });
        }
    }
};
</script>
