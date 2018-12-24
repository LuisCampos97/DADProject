<template>
<!-- template só pode ter um unico root element -->
<div class="jumbotron" v-if="registeringMeal == true">
    <div class="col-md-8 profile-info">
        <div class="row">
            <div class="col-md-6">
                <label>Table Number: </label>
            </div>
            <div class="col-md-6">
                <input type="number" v-model="meal.table_number">
            </div>
                <div class="row">
                    <div class="col-md-2">
                        <button class="profile-edit-btn"  style="float: right" @click.prevent="registerMeal()">Register</button>
                    </div>
                    <div class="col-md-2">
                        <button class="profile-edit-btn" style="float: right" @click.prevent="cancelMeal()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
module.exports = {
<<<<<<< HEAD
    props: ["registeringMeal", "meals"],
=======
    props: ["registeringMeal"],
>>>>>>> fixes
    data: function () {
        return {
            meal: {
                state: "active",
                table_number: "",
                start: "",
                responsible_waiter_id: "",
                total_price_preview: "0"
            },
            failMessage: "",
            showFailure: false
        };
    },
    methods: {
        cancelMeal: function () {
<<<<<<< HEAD
            this.registeringMeal = false;
        },
        registerMeal: function () {

            var userId =this.$store.state.user.id;
            var mealExists = false;

            this.meal.start = new Date().toISOString().slice(0, 19).replace('T', ' ');
            this.meal.responsible_waiter_id = userId;
            var table = this.meal.table_number;

            this.meals.forEach(function(element) {            
            if(element.table_number == table && element.state == "active"){
                this.showFailure = true;
                this.failMessage = "Meal already exists.";
                mealExists = true;
            }});

            if(mealExists == false){ 

                
=======
            this.$emit("cancel-Meal");
        },
        registerMeal: function () {

            this.meal.start = new Date();
            this.meal.responsible_waiter_id = this.$store.state.user.id;

            console.log(this.meal);

>>>>>>> fixes
            axios.post("api/meals/register", this.meal)
                .then(response => {
                    console.log('response', response);
                })
                .catch(response => {
                    this.showFailure = true;
                    this.failMessage = error.response.data.message;
                    console.dir(error);
                });
<<<<<<< HEAD
            }
=======
>>>>>>> fixes
        }
    },
    mounted() {}
};
</script>
