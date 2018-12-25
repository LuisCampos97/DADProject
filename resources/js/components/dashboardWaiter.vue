<template>
<div class="jumbotron" v-if="user.type == 'waiter'">
    <button @click.prevent="registerMeal()">Register Meal</button>

    <registerMeal :registeringMeal="registeringMeal" @cancel-Meal="cancelMeal"></registerMeal>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Meals</th>
            </tr>
        </thead>
        <tbody v-for="meal in meals" :key="meal.id" v-if="meal.responsible_waiter_id == user.id && meal.state == 'active'">
            <tr>
                <td>Meal: {{ meal.id }}</td>
                <td>Table: {{ meal.table_number }}</td>
                <td>{{ meal.start }}</td>
                <td>Total: {{ meal.total_price_preview }}</td>
            </tr>
            <tr v-for="order in orders" :key="order.id " v-if="meal.id == order.meal_id && (order.state == 'confirmed' || order.state == 'pending')">
                <td>Item: {{ order.item_id }}</td>
                <td v-if="order.state == 'confirmed'" style="color: #2bb800">{{ order.state }}</td>
                <td v-if="order.state == 'pending'" style="color: #0062cc">{{ order.state }}</td>
                <td>{{ order.start }}</td>
                <td>Cook: {{ order.responsible_cook_id }}</td>
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
    },
    mounted() {
        this.getMeals();
        this.getOrders();
    }
};
</script>
