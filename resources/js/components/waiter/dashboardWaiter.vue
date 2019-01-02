<template>
<div class="jumbotron" v-if="currentUser.type == 'waiter'">
    <a class="btn btn-sm btn-info" @click.prevent="registerMeal()">Register Meal</a>
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
                <td>Total: {{ meal.total_price_preview }} €</td>
                <td><a class="btn btn-sm btn-primary" @click.prevent="registerOrder(meal)">Register Orders</a>
                    <a class="btn btn-sm btn-primary" @click.prevent="terminate(meal)">Terminate</a></td>
            </tr>
            <tr v-for="order in orders" :key="order.id " v-if="meal.id == order.meal_id">
                <td>{{items[order.item_id - 1].name }}</td>
                <td v-if="order.state == 'confirmed'" style="color: #0062cc">{{ order.state }}</td>
                <td v-else-if="order.state == 'pending'" style="color: #38bdf1">{{ order.state }}</td>
                <td v-else-if="order.state == 'prepared'" style="color: #f08228">{{ order.state }}</td>
                <td v-else-if="order.state == 'delivered'" style="color: #2bb800">{{ order.state }}</td>
                <td v-else>{{ order.state }}</td>
                <td>{{ order.start }}</td>
                <td>Price: {{ items[order.item_id - 1].price }} €</td>
                <td><a class="btn btn-sm btn-success" @click.prevent="setOrderState(order)" v-if="order.state == 'prepared'" >Deliver</a>
                    <a class="btn btn-sm btn-danger" @click.prevent="cancelOrder(order)" v-if=" plusFiveSeconds(order.start) >= currentDate">Cancel</a>
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
            orders: [],
            items: [],
            tables: [],
            meals: [],
            invoiceItems: [],
            currentDate: new Date().toISOString().slice(0, 19).replace('T', ' '),
            registeringMeal: false,
            registeringOrder: false,
            currentMeal: {},
            invoice: {
                state: "pending",
                meal_id: "",
                date: "",
                total_price: 0
            },
            invoiceItem: {
                invoice_id: "",
                item_id: "",
                quantity: 0,
                unit_price: 0,
                sub_total_price: 0
            },
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
        getItems: function () {
            axios.get("api/items").then(response => {
                this.items = response.data.data;
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
            axios
                .put("api/orders/" + order.id, order)
                .then(response => {
                    this.getOrders();
                })
                .catch();
            var meal = this.meals[order.meal_id - 1];
            meal.total_price_preview +=
                axios
                .put("api/meals/" + meal.id + "/" + this.items[order.item_id - 1].price, meal)
                .then(response => {
                    this.getMeals();
                })
                .catch();
        },
        terminate: function (meal) {

            let response = confirm(
                "There are orders not delivered, do you wish to continue?"
            );
            if (response) {

                axios
                    .put("api/meals/terminate/" + meal.id, meal)
                    .then(response => {
                        this.getMeals();
                    })
                    .catch();

                axios
                    .put("api/orders/terminate/" + meal.id, meal)
                    .then(response => {
                        this.getOrders();
                    })
                    .catch();

                this.invoice.meal_id = meal.id;
                this.invoice.date = new Date().toISOString().slice(0, 19).replace('T', ' ');
                this.invoice.total_price = meal.total_price_preview;

                console.log(this.invoice);

                axios.post("api/invoices/register", this.invoice)
                    .then(response => {
                        for (let order of this.orders) {
                            let invoiceitem = {};
                            if (meal.id == order.meal_id) {
                                invoiceitem.quantity = 0;
                                invoiceitem.item_id = order.item_id;
                                invoiceitem.invoice_id = response.data.data.id;
                                for (let element of this.orders) {
                                    if (invoiceitem.item_id == element.item_id && meal.id == element.meal_id) {
                                        invoiceitem.quantity += 1;
                                        invoiceitem.unit_price = this.items[order.item_id - 1].price;
                                    }
                                }

                                invoiceitem.sub_total_price = invoiceitem.unit_price * invoiceitem.quantity;

                                axios
                                    .post("api/invoiceItems/register", invoiceitem)
                                    .then(response => {
                                        this.getOrders();
                                        this.getMeals();
                                    })
                                    .catch();
                            }
                        }

                    })
                    .catch();
            } else {
                console.log("CANCEL");
            }
        },

    },
    mounted() {
        this.getMeals();
        this.getOrders();
        this.getItems();
    }
};
</script>
