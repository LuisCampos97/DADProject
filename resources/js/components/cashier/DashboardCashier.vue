<template>
  <div class="jumbotron" v-if="currentUser.type == 'cashier'">
    <div v-if="invoices.length >= 1">
      <h3 style="font-weight: bold">Pending Invoices</h3>
          <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Table No</th>
          <th>Responsible Waiter</th>
          <th>Total Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="invoice in invoices" :key="invoice.id">
        <tr>
          <td>{{ invoice.table_number }}</td>
          <td>{{ invoice.responsible_waiter_id }} : {{ invoice.responsible_waiter_name }}</td>
          <td>{{ invoice.total_price }} €</td>
          <td>
            <a class="btn btn-sm btn-info" v-on:click.prevent="">Details</a>
            <a class="btn btn-sm btn-warning" v-on:click.prevent="">Pay</a>
          </td>
        </tr>
      </tbody>
    </table>
    </div>
    <h4 v-else>You don't have any pending invoices</h4>
  </div>
</template>

<script>
module.exports = {
  props: ["currentUser"],
  data: function() {
    return {
      invoices: []
    };
  },
  methods: {
    mealForInvoice() {
      axios
        .get("/api/mealForInvoice")
        .then(response => {
          this.invoices = response.data;
        })
        .catch(error => {});
    }
  },
  mounted() {
    this.mealForInvoice();
  }
};
</script>
