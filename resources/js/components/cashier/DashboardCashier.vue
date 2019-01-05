<template>
  <div class="jumbotron" v-if="currentUser.type == 'cashier'">
    <h3 v-if="invoices.length <= 0">You don't have any pending invoices!</h3>
    <div v-else v-for="invoice in invoices" :key="invoice.id">
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
        <tbody>
          <tr>
            <td>{{ invoice.table_number }}</td>
            <td>{{ invoice.responsible_waiter_id }} : {{ invoice.responsible_waiter_name }}</td>
            <td>{{ invoice.total_price }} €</td>
            <td>
              <router-link :to="{ path: `/invoices/${invoice.id}` }">
                <a class="btn btn-sm btn-info">Details</a>
              </router-link>
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
    <br>
    <h2>Paid Invoices</h2>
    <table id="table" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Table No</th>
          <th>Responsible Waiter</th>
          <th>Total Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody
        v-for="invoice in paidInvoices"
        :key="invoice.id"
      >
        <tr>
          <td>{{ invoice.table_number }}</td>
          <td>{{ invoice.responsible_waiter_id }} : {{ invoice.responsible_waiter_name }}</td>
          <td>{{ invoice.total_price }} €</td>
          <td>
            <a class="btn btn-sm btn-warning" v-on:click.prevent="exportPdf(invoice)">
              <i class="far fa-file-pdf"></i> Export to PDF
            </a>
          </td>
        </tr>
      </tbody>
    </table>
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
      currentInvoiceItems: []
    };
  },
  methods: {
    mealForInvoice() {
      axios.get("/api/mealForInvoice").then(response => {
        this.invoices = response.data;
      });
    },
    openPayInvoiceComponent(invoice) {
      this.payingInvoice = true;
    },
    closePayInvoiceComponent() {
      this.mealForInvoice();
      this.payingInvoice = false;
    },
    paidInvoice() {
      axios.get("/api/invoices").then(response => {
        this.paidInvoices = response.data;
      });
    },
    exportPdf(invoice) {
      //Talvez por ser assincrono, primeiro corre o código do PDF 
      //e só a seguir corre a chamada à API
      axios
        .get("api/invoiceItems/" + invoice.id)
        .then(response => {
          this.currentInvoiceItems = response.data;
        })
        .catch(error => {});

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
    }
  },
  mounted() {
    this.mealForInvoice();
    this.paidInvoice();
  }
};
</script>
