<template>
  <div class="jumbotron" v-if="invoice && payingInvoice">
    <h2>Pay Invoice {{invoice.id }}</h2>
    <div class="form-group">
      <label for="inputNif">NIF</label>
      <input
        type="number"
        class="form-control"
        v-model="invoice.nif"
        name="nif"
        id="inputNif"
        placeholder="NIF"
      >
      <p class="help-block" v-for="error in errors.nif" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputName">Name</label>
      <input
        type="text"
        class="form-control"
        v-model="invoice.name"
        name="name"
        id="inputName"
        placeholder="Fullname"
      >
      <p class="help-block" v-for="error in errors.name" v-bind:key="error">{{ error }}</p>
    </div>

    <div class="form-group">
      <a class="btn btn-success" v-on:click.prevent="savePayInvoice()">Save</a>
      <a class="btn btn-danger" v-on:click.prevent="cancelPay()">Cancel</a>
    </div>
  </div>
</template>

<script>
module.exports = {
  props: ["invoice", "payingInvoice", "errorsPay"],
  data: function() {
    return {
      errors: {
        nif: [],
        name: []
      }
    };
  },
  methods: {
    savePayInvoice: function() {
      axios
        .put("api/invoices/" + this.invoice.id, this.invoice)
        .then(response => {
          Object.assign(this.invoice, response.data.data);
          this.$emit("save-invoice");
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
    },
    cancelPay: function() {
      this.$emit("cancel-pay");
      $("#inputNif")[0].value = "";
      $("#inputName")[0].value = "";
    }
  }
};
</script>

<style>
.help-block {
  font-size: 7px;
  color: red;
  display: table-row;
  font-weight: bold;
}
</style>