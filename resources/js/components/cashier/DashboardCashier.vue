<template>
  <div class="container" v-if="currentUser.type == 'cashier'">
    <h3 v-if="invoices.length <= 0">You don't have any pending invoices!</h3>
    <div v-else>
      <h2 style="font-weight: bold">Pending Invoices</h2>
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
              <router-link :to="{ path: `/invoices/${invoice.id}` }">
                <a class="btn btn-sm btn-info">Details</a>
              </router-link>
              <a
                class="btn btn-sm btn-warning"
                v-on:click.prevent="openPayInvoiceComponent(invoice)"
              >Pay</a>
            </td>
          </tr>
        </tbody>
      </table>
      <pay-invoice
        :invoice="currentInvoice"
        :payingInvoice="payingInvoice"
        v-on:cancel-pay="closePayInvoiceComponent()"
        v-on:save-invoice="closePayInvoiceComponent()"
      ></pay-invoice>
    </div>
    <br>
    <br>
    <br>
    <h2 style="font-weight: bold">Paid Invoices</h2>
    <table id="table" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Table No</th>
          <th>Responsible Waiter</th>
          <th>Total Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="invoice in paidInvoices.data" :key="invoice.id">
        <tr>
          <td>{{ invoice.table_number }}</td>
          <td>{{ invoice.responsible_waiter_id }} : {{ invoice.responsible_waiter_name }}</td>
          <td>{{ invoice.total_price }} €</td>
          <td>
            <a class="btn btn btn-warning" v-on:click.prevent="exportPdf(invoice)">
              <i class="far fa-file-pdf"></i> Export to PDF
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <pagination :limit="3" :data="paidInvoices" @pagination-change-page="paidInvoice"></pagination>
    </div>
  </div>
</template>

<script>
import jsPDF from "jspdf";
export default {
  props: ["currentUser"],
  data: function() {
    return {
      invoices: [],
      paidInvoices: {},
      payingInvoice: false,
      currentInvoiceItems: [],
      currentInvoice: {}
    };
  },
  methods: {
    mealForInvoice() {
      axios.get("/api/mealForInvoice").then(response => {
        this.invoices = response.data;
      });
    },
    openPayInvoiceComponent(invoice) {
      this.currentInvoice = invoice;
      this.payingInvoice = true;
    },
    closePayInvoiceComponent() {
      this.mealForInvoice();
      this.payingInvoice = false;
    },
    paidInvoice(page = 1) {
      axios.get("/api/paidInvoices?page=" + page).then(response => {
        this.paidInvoices = response.data;
      });
    },
    exportPdf(invoice) {
      axios
        .get("api/invoiceItems/" + invoice.id)
        .then(response => {
          this.currentInvoiceItems = response.data;
          var doc = new jsPDF();

          doc.setFontSize(20);
          doc.text("Restaurant Management", 10, 30);

          doc.text("Invoice", 10, 40);

          doc.setFontSize(12);
          doc.text("Invoice ID: " + invoice.id, 13, 45);
          doc.text("Name: " + invoice.name, 13, 49);
          doc.text("NIF: " + invoice.nif, 13, 53);
          doc.text("Date: " + invoice.date, 13, 57);

          doc.addPage();
          doc.setFontSize(17);
          doc.text("List of items:", 10, 20);

          let y = 30;
          doc.setFontSize(12);
          this.currentInvoiceItems.forEach(element => {
            doc.text(element.name, 13, y);
            doc.text("x" + element.quantity, 20, (y += 5));
            doc.text(element.unit_price + " €", 40, y);
            doc.text(element.sub_total_price + " €", 65, y);
            y += 10;
          });

          doc.setFontSize(18);
          doc.text("TOTAL: " + invoice.total_price + " €", 40, (y += 10));

          doc.save("invoice_" + invoice.id + ".pdf");
        })
        .catch(error => {});
    }
  },
  mounted() {
    this.mealForInvoice();
    this.paidInvoice();
  }
};
</script>

<style scoped>
.pagination {
  justify-content: center !important;
}
</style>