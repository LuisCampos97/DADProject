<template>
  <div class="jumbotron" v-if="currentUser.type == 'cook'">
    <div class="alert alert-success" v-if="showSuccess">
      <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
      <strong>{{ successMessage }}</strong>
    </div>
    <h3 v-if="orders.length <= 0">You don't have any order!</h3>
    <table v-else class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Item to prepare</th>
          <th>State</th>
          <th>Start</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="order in orders" :key="order.id" :class="{active: currentOrder === order}">
        <tr class="table-success" v-if="order.state == 'confirmed'">
          <td>{{ order.item_name }}</td>
          <td>{{ order.state }}</td>
          <td>{{ order.start }}</td>
          <td>
            <a
              class="btn btn-sm btn-primary"
              v-on:click.prevent="setOrderState(order)"
            >In Preparation</a>
          </td>
        </tr>
        <tr class="table-primary" v-if="order.state == 'in preparation'" >
          <td>{{ order.item_name }}</td>
          <td>{{ order.state }}</td>
          <td>{{ order.start }}</td>
          <td>
            <a class="btn btn-sm btn-success" v-on:click.prevent="setOrderState(order)">Prepared</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
module.exports = {
  props: ["currentUser"],
  data: function() {
    return {
      orders: [],
      currentOrder: {},
      showSuccess: false,
      successMessage: ""
    };
  },
  methods: {
    getOrders() {
      axios.get("api/ordersCook/" + this.currentUser.id).then(response => {
        this.orders = response.data;
      });
    },
    setOrderState(order) {
      this.currentOrder = order;
      axios
        .put("api/orders/" + order.id, order)
        .then(response => {
          this.showSuccess = true;
          this.successMessage = `Order ${order.id} status changed to: ${
            response.data.data.state
          }`;
          this.getOrders();
        });
    }
  },
  mounted() {
    this.getOrders();
  }
};
</script>
