<template>
<div class="jumbotron" v-if="currentUser.type == 'manager'">
    <div class="alert alert-success" v-if="showMessage">
        <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
        <strong>{{ message }}</strong>
    </div>
    <h3>Menu Items</h3>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Item ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody v-for="item in items" :key="item.id">
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.type }}</td>
                <td>
                    <a class="btn btn-sm btn-info" v-on:click.prevent="updateItem(item)">Edit</a>
                    <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteItem(item)">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
    <MealManage></MealManage>
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
            items: [],
            meals: [],
            tables: [],
            showMessage: false,
            message: ""
        };
    },
    methods: {
        getItems() {
            axios.get("/api/items").then(response => {
                this.items = response.data.data;
            });
        },
        getMeals: function () {
            axios.get("api/meals").then(response => {
                this.meals = response.data.data;
            });
        },
        notPaid: function () {
            axios
                .put("api/meals/notPaid/" + meal.id, meal)
                .then(response => {
                    this.getMeals();
                })
                .catch();
            axios
                .put("api/invoices/notPaid/" + meal.id, meal)
                .then(response => {})
                .catch();
        },
        updateItem(item) {},
        deleteItem(item) {
            axios.delete("api/invoices/" + item.id).then(response => {
                this.showMessage = true;
                this.message = `Item "${item.name}" deleted`;
                this.getItems();
            });
        }
    },
    mounted() {
        this.getItems();
        this.getMeals();
    }
};
</script>
