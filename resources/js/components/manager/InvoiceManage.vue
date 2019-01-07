<template>
  <div>
    <h3>Invoices</h3>
    <br>
    <table id="table" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>State</th>
          <th>Date</th>
          <th>Responsible Waiter</th>
          <th>Total Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="invoice in invoices.data" :key="invoice.id">
        <tr>
          <td>{{ invoice.state }}</td>
          <td>{{ invoice.date }}</td>
          <td>{{ invoice.responsible_waiter_id }} : {{ invoice.responsible_waiter_name }}</td>
          <td>{{ invoice.total_price }} €</td>
          <td>
            <router-link :to="{ path: `/invoices/${invoice.id}` }">
              <a class="btn btn-info">
                <i class="fas fa-info-circle"></i> Details
              </a>
            </router-link>
            <a class="btn btn-warning" v-on:click.prevent="exportPdf(invoice)">
              <i class="far fa-file-pdf"></i> Export to PDF
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <pagination :limit="10" :data="invoices" @pagination-change-page="getInvoices"></pagination>
    </div>
  </div>
</template>

<script>
import jsPDF from "jspdf";
export default {
  data() {
    return {
      invoices: {},
      options: [{ key: "pending" }, { key: "paid" }, { key: "not paid" }],
      searchResponsible: ''
    };
  },
  methods: {
    getInvoices() {
      axios.get("api/invoices/index").then(response => {
        this.invoices = response.data;
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
    },
    search: function() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("table");
      tr = table.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  },
  mounted() {
    this.getInvoices();
  }
};
</script>

<style scoped>
.pagination {
  justify-content: center !important;
}
</style>