<template>
<!-- template só pode ter um unico root element -->
<div class="jumbotron" v-if="registeringOrder == true">
    <div class="col-md-8 profile-info">
        <div class="row">
            <div class="col-md-6">
                <orderItems v-on:register-order="registerOrder"></orderItems>>
            </div>
        </div>
    </div>
</div>
</template>

<script>
module.exports = {
    props: ["registeringOrder", "currentMeal"],
    data: function () {
        return {
            order: {
                state: "active",
                item_id: "",
                meal_id: "",
                responsible_cook_id: "1",
                start: ""
            },
            failMessage: "",
            showFailure: false
        };
    },
    methods: {
        cancelOrder: function () {
            this.$emit("cancel-Order");
        },
        registerOrder: function (item) {
            console.log(item);

            this.order.state = "pending";
            this.order.item_id = item;
            this.order.meal_id = this.currentMeal.id;
            this.order.start = new Date().toISOString().slice(0, 19).replace('T', ' ');

            console.log(this.order);

            axios.post("api/orders/register", this.order)
                .then(response => {
                    console.log('response', response);
                })
                .catch(response => {
                    this.showFailure = true;
                    this.failMessage = error.response.data.message;
                    console.dir(error);
                });
        }
    },
    mounted() {}
};
</script>
