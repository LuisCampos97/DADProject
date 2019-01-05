<template>
<div>
    <h3>Meals</h3>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Meal ID</th>
                <th>Table</th>
                <th>Start</th>
                <th>Waiter Responsible</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody v-for="meal in meals" :key="meal.id" v-if="meal.state == 'terminated' || meal.state == 'active'">
            <tr>
                <td>Meal: {{ meal.id }}</td>
                <td>Table: {{ meal.table_number }}</td>
                <td>{{ meal.start }}</td>
                <td>{{ meal.responsible_waiter_id }}</td>
                <td>Total: {{ meal.total_price_preview }} €</td>
                <td>
                    <a v-if="meal.state == 'terminated'" class="btn btn-sm btn-danger" v-on:click.prevent="notPaid(meal)">Not Paid</a>
                </td>
            </tr>
            <tr v-for="order in orders" :key="order.id " v-if="meal.id == order.meal_id">
                <td>{{findItemName(order.item_id)}}</td>
                <td>{{findItemType(order.item_id)}} </td>
                <td v-if="order.state == 'confirmed'" style="color: #0062cc">{{ order.state }}</td>
                <td v-else-if="order.state == 'pending'" style="color: #38bdf1">{{ order.state }}</td>
                <td v-else-if="order.state == 'prepared'" style="color: #f08228">{{ order.state }}</td>
                <td v-else-if="order.state == 'delivered'" style="color: #2bb800">{{ order.state }}</td>
                <td v-else>{{ order.state }}</td>
                <td>{{ order.start }}</td>
                <td>Price: {{findItemPrice(order.item_id)}} €</td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
import {
    Vuetable,
    VuetablePagination
} from "vuetable-2";
export default {
    components: {
        Vuetable,
        VuetablePagination
    },
    props: ["currentUser"],
    data() {
        return {
            meals: [],
            tables: [],
            orders: [],
            items: [],
            invoices: [],
            showMessage: false,
            message: ""
        };
    },
    methods: {
        findItemName: function (itemId) {
            try {
                return this.items.find(x => x.id === itemId).name;
            } catch (err) {
                return "No Longer Sold";
            }
        },
        findItemPrice: function (itemId) {
            try {
                return this.items.find(x => x.id === itemId).price;
            } catch (err) {
                return "No Longer Sold";
            }
        },
        findItemType: function (itemId) {
            try {
                return this.items.find(x => x.id === itemId).type;
            } catch (err) {
                return "No Longer Sold";
            }
        },
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.meals = response.data.data;
            });
        },
        paidInvoice() {
            axios.get("/api/invoices").then(response => {
                this.invoices = response.data.data;
            });
        },
        notPaid: function (meal) {
            axios
                .put("api/invoices/notPaid/" + meal.id, meal)
                .then(response => {
                    this.getMeals();
                })
                .catch();
        },
        getItems: function () {
            axios.get("api/items").then(response => {
                this.items = response.data.data;
                console.log(this.items);
            });
        },
        getOrders: function () {
            axios.get("api/orders").then(response => {
                this.orders = response.data.data;
            });
        },
    },
    mounted() {
        this.getItems();
        this.getMeals();
        this.getOrders();
    }
};
</script>
