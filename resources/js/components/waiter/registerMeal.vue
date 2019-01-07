<template>
  <div class="container" v-if="registeringMeal == true">
    <div class="form-group">
      <label for="inputType">Table Number:</label>
      <select class="form-control" name="inputType" v-model="meal.table_number">
        <option disabled value>--- Please select one ---</option>
        <option v-for="table in tables" v-bind:key="table.table_number">{{ table.table_number }}</option>
      </select>
      <p class="help-block" v-for="error in errors.table_number" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <a class="btn btn-success" v-on:click.prevent="registerMeal()">Register</a>
      <a class="btn btn-danger" v-on:click.prevent="cancelMeal()">Cancel</a>
    </div>
  </div>
</template>

<script>
module.exports = {
  props: ["registeringMeal"],
  data: function() {
    return {
      meal: {
        state: "active",
        table_number: "",
        start: "",
        responsible_waiter_id: "",
        total_price_preview: "0"
      },
      tables: {},
      errors: {
        table_number: []
      }
    };
  },
  methods: {
    cancelMeal: function() {
      this.$emit("cancel-Meal");
    },
    registerMeal: function() {
      var i = this.tables.length;
      var bol = false;

      while (i--) {
        if (this.tables[i] == this.meal.table_number) {
          bol = true;
        }
      }

      if (bol) {
        console.dir("error");
      } else {
        this.meal.start = new Date()
          .toISOString()
          .slice(0, 19)
          .replace("T", " ");
        this.meal.responsible_waiter_id = this.$store.state.user.id;

        axios
          .post("api/meals/register", this.meal)
          .then(response => {
            this.$emit("save-Meal");
          })
          .catch(error => {
            let data = error.response.data.errors;

            for (let key in this.errors) {
              this.errors[key] = [];

              let errorMessage = data[key];

              if (errorMessage) {
                this.errors[key] = errorMessage;
              }
            }
          });
      }
    },
    getTablesWitoutActiveMeals() {
      axios.get("api/tablesWitoutActiveMeals").then(response => {
        this.tables = response.data;
      });
    }
  },
  mounted() {
    this.getTablesWitoutActiveMeals();
  }
};
</script>

<style>
.help-block {
  color: red;
  display: table-row;
  font-weight: bold;
}
</style>