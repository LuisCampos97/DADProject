<template>
  <div class="jumbotron">
    <h2>Invoice Details</h2>
    <p><bold class="bold">Id:</bold> {{ this.currentInvoice.id }}</p>
    <p><bold>Date:</bold> {{ this.currentInvoice.date }}</p>
    <p><bold>Table Number:</bold> {{ this.currentInvoice.table_number }}</p>
    <p><bold>Total Price:</bold> {{ this.currentInvoice.total_price }} €</p>
    <br>
    <p style="font-weight: bold;">List of items:</p>
    <div v-for="item in currentInvoiceItems" v-bind:key="item">
      <p>&emsp;<bold>Name:</bold> {{ item.name }}</p>
      <p>&emsp;<bold>Quantity:</bold> {{ item.quantity }}</p>
      <p>&emsp;<bold>Unit Price:</bold> {{ item.unit_price }} €</p>
      <p>&emsp;<bold>Sub-total price:</bold> {{ item.quantity * item.unit_price }} €</p>
      <br>
    </div>
    <br>
    <router-link to="/dashboard"><a class="btn btn-sm btn-success">Back to Dashboard</a></router-link>
  </div>
</template>

<script>
module.exports = {
  data() {
    return {
      id: this.$route.params.id,
      details: {},
      currentInvoice: {},
      currentInvoiceItems: []
    };
  },
  methods: {
    getCurrentInvoiceDetails() {
      axios
        .get("api/invoiceDetails/" + this.id)
        .then(response => {
          this.currentInvoice = response.data[0];
        })
        .catch(error => {});
    },
    getCurrentInvoiceItems() {
      axios
        .get("api/invoiceItems/" + this.id)
        .then(response => {
          this.currentInvoiceItems = response.data;
        })
        .catch(error => {});
    }
  },
  mounted() {
    this.getCurrentInvoiceDetails();
    this.getCurrentInvoiceItems();
  }
};
</script>

<style>
h2, bold {
  font-weight: bold;
}

p {
  display: table-row;
}
</style>

