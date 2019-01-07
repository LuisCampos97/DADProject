<template>
  <div class="container">
    <h2>Invoice Details</h2>
    <p><b>Id:</b> {{ this.currentInvoice.id }}</p>
    <p><b>Date:</b> {{ this.currentInvoice.date }}</p>
    <p><b>Table Number:</b> {{ this.currentInvoice.table_number }}</p>
    <p><b>Total Price:</b> {{ this.currentInvoice.total_price }} €</p>
    <br>
    <p style="font-weight: bold;">List of items:</p>
    <div v-for="item in currentInvoiceItems" v-bind:key="item.id">
      <p>&emsp;<b>Name:</b> {{ item.name }}</p>
      <p>&emsp;<b>Quantity:</b> {{ item.quantity }}</p>
      <p>&emsp;<b>Unit Price:</b> {{ item.unit_price }} €</p>
      <p>&emsp;<b>Sub-total price:</b> {{ item.quantity * item.unit_price }} €</p>
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
h2 {
  font-weight: bold;
}

p {
  display: table-row;
}
</style>

