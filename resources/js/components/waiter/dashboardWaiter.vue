<template>
<div class="jumbotron" v-if="currentUser.type == 'waiter'">
    <button @click.prevent="registerMeal()">Register Meal</button>
    <registerMeal :registeringMeal="registeringMeal" :tables="tables" @cancel-Meal="cancelMeal"></registerMeal>
    <registerOrder :registeringOrder="registeringOrder" :current-meal="currentMeal" @cancel-Order="cancelOrder"></registerOrder>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Meals</th>
            </tr>
        </thead>
        <tbody v-for="meal in meals" :key="meal.id" v-if="meal.responsible_waiter_id == currentUser.id && meal.state == 'active'">
            <tr>
                <td>Meal: {{ meal.id }}</td>
                <td>Table: {{ meal.table_number }}</td>
                <td>{{ meal.start }}</td>
                <td>Total: {{ meal.total_price_preview }}</td>
                <td><button @click.prevent="registerOrder(meal)">Register Orders</button></td>
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
    props: ["currentUser"],
    data: function () {
        return {
            registeringMeal: false,
            registeringOrder: false,
            orders: [],
            tables: [],
            currentMeal: {},
            meals: []
        };
    },
    methods: {
        registerMeal: function () {
            this.registeringMeal = true;
        },
        registerOrder: function (meal) {
            this.registeringOrder = true;
      this.currentMeal = Object.assign({}, meal);
        },
        cancelMeal: function () {
            this.registeringMeal = false;
        },

        cancelOrder: function () {
            this.registeringOrder = false;
        },
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.meals = response.data.data;
                this.meals.forEach(element => {
                    if(element.state == 'active'){
                    this.tables.push(element.table_number);
                    }
                });
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
