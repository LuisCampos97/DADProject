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
            <tr v-for="order in orders" :key="order.id " v-if="meal.id == order.meal_id">
                <td>Item: {{ order.item_id }}</td>
                <td v-if="order.state == 'confirmed'" style="color: #0062cc">{{ order.state }}</td>
                <td v-else-if="order.state == 'pending'" style="color: #38bdf1">{{ order.state }}</td>
                <td v-else-if="order.state == 'prepared'" style="color: #f08228">{{ order.state }}</td>
                <td v-else-if="order.state == 'delivered'" style="color: #2bb800">{{ order.state }}</td>
                <td v-else>{{ order.state }}</td>
                <td>{{ order.start }}</td>
                <td>Cook: {{ order.responsible_cook_id }}</td>
                <td><button @click.prevent="setOrderState(order)" v-if="order.state == 'prepared'" >Deliver</button>
                    <button @click.prevent="cancelOrder(order)" v-if=" plusFiveSeconds(order.start) >= currentDate">Cancel</button>
                </td>
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
            currentDate: new Date().toISOString().slice(0, 19).replace('T', ' '),
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

        cancelOrder: function (order) {
            axios.delete("api/orders/" + order.id)
                .then(response => {
                    console.log('response', response);
                })
                .catch(response => {
                    this.showFailure = true;
                    this.failMessage = error.response.data.message;
                    console.dir(error);
                });
        },
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.meals = response.data.data;
                this.meals.forEach(element => {
                    if (element.state == 'active') {
                        this.tables.push(element.table_number);
                    }
                });
            });
        },
        getOrders: function () {
            axios.get("api/orders").then(response => {
                this.orders = response.data.data;
            });
        },
        plusFiveSeconds: function (date) {
            var dt = new Date(date);
            dt.setSeconds(dt.getSeconds() + 5);
            return new Date(dt).toISOString().slice(0, 19).replace('T', ' ');
        },
        setOrderState(order) {
                    console.log('response');
            this.currentOrder = order;
            axios
                .put("api/orders/" + order.id, order)
                .then(response => {
                    this.showSuccess = true;
                    this.successMessage = `Order ${order.id} status changed to: ${response.data.data.state}`
                    this.getOrders();
                })
                .catch();
        }

    },
    mounted() {
        this.getMeals();
        this.getOrders();
    }
};
</script>
