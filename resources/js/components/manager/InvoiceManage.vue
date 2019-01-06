<template>
<div>
    <h3>Invoices</h3>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Invoice ID</th>
                <th>Table</th>
                <th>Waiter Responsible</th>
                <th>Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody v-for="invoice in invoices" :key="invoice.id">
            <tr v-if="invoice.state == 'pending'">
                <td>{{ invoice.id }}</td>
                <td>{{ findMealTable(invoice.meal_id) }}</td>
                <td>{{ findMealWaiter(invoice.meal_id) }}</td>
                <td>{{ invoice.date }}</td>
                <td>{{ invoice.total_price }} €</td>
                <td>
                    <a class="btn btn-sm btn-danger" v-on:click.prevent="notPaid(invoice)">Not Paid</a>
                </td>
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
    data() {
        return {
            meals: [],
            tables: [],
            invoices: [],
            showMessage: false,
            message: ""
        };
    },
    methods: {
        findMealTable: function (itemId) {
            try {
                return this.meals.find(x => x.id === itemId).table_number;
            } catch (err) {
                return "Error";
            }
        },
        findMealWaiter: function (itemId) {
            try {
                return this.meals.find(x => x.id === itemId).responsible_waiter_id;
            } catch (err) {
                return "Error";
            }
        },
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.meals = response.data.data;
            });
        },
        getInvoices: function () {
            axios.get("api/invoices/all").then(response => {
                this.invoices = response.data.data;
            });
        },
        notPaid: function (meal) {
            axios
                .put("api/invoices/notPaid/" + meal.id, meal)
                .then(response => {
                    this.getMeals();
                    this.getInvoices();
                })
                .catch();
        }
    },
    mounted() {
        this.getMeals();
        this.getInvoices();
    }
};
</script>
