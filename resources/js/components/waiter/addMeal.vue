<template>
<!-- template só pode ter um unico root element -->
<div class="jumbotron" v-if="editingUser">
    <div class="row">
        <div class="col-md-2">
            <button class="profile-edit-btn"  style="float: right" @click.prevent="addMeal()">Add</button>
        </div>
        <div class="col-md-2">
            <button class="profile-edit-btn" style="float: right" @click.prevent="cancelMeal()">Cancel</button>
        </div>
    </div>
</div>
</template>

<script>
module.exports = {
    data: function () {
        return {
            meal: {
                state: "active",
                table_number: "",
                start: "",
                end: "",
                responsible_waiter_id: "",
                total_price_preview: ""
            }
        };
    },
    methods: {
        cancelMeal: function () {
            this.$emit("cancel-edit");
        },
        addMeal: function () {
            this.$emit("save-user");
        }
    },
    mounted() {}
};
</script>