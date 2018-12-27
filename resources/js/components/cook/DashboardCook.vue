<template>
  <div class="jumbotron" v-if="user.type == 'cook'">
    <div class="alert alert-success" v-if="showSuccess">
      <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
      <strong>{{ successMessage }}</strong>
    </div>
    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Order ID</th>
          <th>State</th>
          <th>Start</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody
        v-for="order in orders"
        :key="order.id"
        :class="{active: currentOrder === order}"
        v-if="order.state == 'confirmed' || order.state == 'in preparation'"
      >
        <tr v-if="order.state == 'confirmed'" style="color: #2bb800">
          <td>{{ order.id }}</td>
          <td>{{ order.state }}</td>
          <td>{{ order.start }}</td>
          <td>
            <a
              class="btn btn-sm btn-primary"
              v-on:click.prevent="setOrderState(order)"
            >In Preparation</a>
          </td>
        </tr>
        <tr v-if="order.state == 'in preparation'" style="color: #0062cc">
          <td>{{ order.id }}</td>
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
  data: function() {
    return {
      orders: [],
      currentUser: {},
      currentOrder: {},
      showSuccess: false,
      successMessage: "",
    };
  },
  methods: {
    getOrders() {
      axios.get("api/ordersCook/" + currentUser.id).then(response => {
        this.orders = response.data.data;
      });
    },
    setOrderState(order) {
      this.currentOrder = order;
      axios
        .put("api/orders/" + order.id, order)
        .then(response => {
          this.showSuccess = true;
          this.successMessage = `Order ${order.id} status changed to: ${response.data.data.state}`
          this.getOrders();
        })
        .catch();
    }
  },
  computed: {
    user() {
      return this.$store.state.user;
    }
  },
  mounted() {
    currentUser = this.$store.state.user;
    this.getOrders();
  }
};
</script>
