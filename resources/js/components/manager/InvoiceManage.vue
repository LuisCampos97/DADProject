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
            <tr v-for="invoiceItem in invoiceItems" v-if="invoiceItem.invoice_id == invoice.id && invoice.state == 'pending'">
                <td>{{findItemName(invoiceItem.item_id)}}</td>
                <td>{{findItemType(invoiceItem.item_id)}} </td>
                <td>{{ invoiceItem.quantity }}</td>
                <td>{{ invoiceItem.unit_price}} €</td>
                <td>{{invoiceItem.sub_total_price}} €</td>
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
            items: [],
            invoiceItems: [],
            showMessage: false,
            message: ""
        };
    },
    methods: {
        findItemName: function (itemId) {
            try {
                return this.items.find(x => x.id === itemId).name;
            } catch (err) {
                return "Error";
            }
        },
        findItemType: function (itemId) {
            try {
                return this.items.find(x => x.id === itemId).type;
            } catch (err) {
                return "Error";
            }
        },
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
        getItems: function () {
            axios.get("api/items").then(response => {
                this.items = response.data.data;
            });
        },
        getInvoices: function () {
            axios.get("api/invoices/all").then(response => {
                this.invoices = response.data.data;
            });
        },
        getInvoiceItems: function () {
            axios.get("api/invoiceItems").then(response => {
                this.invoiceItems = response.data.data;
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
        this.getItems();
        this.getMeals();
        this.getInvoiceItems();
        this.getInvoices();
    }
};
</script>
