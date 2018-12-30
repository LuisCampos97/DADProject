<template>
  <div class="jumbotron" v-if="currentUser.type == 'cashier'">
    <h4 v-if="invoices.length <= 0">You don't have any pending invoices!</h4>    
    <div v-else v-for="invoice in invoices" :key="invoice.id">
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
        <tbody>
          <tr>
            <td>{{ invoice.table_number }}</td>
            <td>{{ invoice.responsible_waiter_id }} : {{ invoice.responsible_waiter_name }}</td>
            <td>{{ invoice.total_price }} €</td>
            <td>
              <router-link :to="{ path: `/invoices/${invoice.id}` }"><a class="btn btn-sm btn-info">Details</a></router-link>
              <a class="btn btn-sm btn-warning" v-on:click.prevent="openPayInvoiceComponent()">Pay</a>
            </td>
          </tr>
        </tbody>
      </table>
      <pay-invoice
        :invoice="invoice"
        :payingInvoice="payingInvoice"
        v-on:cancel-pay="closePayInvoiceComponent()"
        v-on:save-invoice="closePayInvoiceComponent()"
      ></pay-invoice>
    </div>
  </div>
</template>

<script>
module.exports = {
  props: ["currentUser"],
  data: function() {
    return {
      invoices: [],
      payingInvoice: false
    };
  },
  methods: {
    mealForInvoice() {
      axios
        .get("/api/mealForInvoice")
        .then(response => {
          this.invoices = response.data;
          console.log(invoices.length);
        })
        .catch(error => {});
    },
    openPayInvoiceComponent(invoice) {
      this.payingInvoice = true;
    },
    closePayInvoiceComponent() {
      this.payingInvoice = false;
      this.mealForInvoice();
    }
  },
  mounted() {
    this.mealForInvoice();
  }
};
</script>
