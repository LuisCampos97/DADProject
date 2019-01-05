<template>
<div>
    <h3>Meals</h3>
    <table class="table table-striped">        
        <thead class="thead-dark">
            <tr>
                <th>Meal ID</th>
                <th>Table</th>
                <th>Start</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody v-for="meal in meals" :key="meal.id" v-if="meal.state == 'terminated'">
            <tr>
                <td>{{ meal.id }}</td>
                <td>{{ meal.table_number }}</td>
                <td>{{ meal.start }}</td>
                <td>{{ meal.total_price_preview }} €</td>
                <td>
                    <a class="btn btn-sm btn-danger" v-on:click.prevent="notPaid(meal)">Not Paid</a>
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
    props: ["currentUser"],
    data() {
        return {
            meals: [],
            tables: [],
            showMessage: false,
            message: ""
        };
    },
    methods: {
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.meals = response.data.data;
            });
        },
        notPaid: function (meal) {
            axios
                .put("api/invoices/notPaid/" + meal.id, meal)
                .then(response => {
                    this.getMeals();})
                .catch();
        },
    },
    mounted() {
        this.getMeals();
    }
};
</script>
