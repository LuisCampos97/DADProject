<template>
  <div class="jumbotron" v-if="user.type == 'cook'">
    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Order ID</th>
          <th>State</th>
          <th>Start</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="order in orders" :key="order.id" v-if="order.state == 'confirmed' || order.state == 'in preparation'">
        <tr v-if="order.state == 'confirmed'" style="color: #2bb800">
          <td>{{ order.id }}</td>
          <td>{{ order.state }}</td>
          <td>{{ order.start }}</td>
          <td>
            <div class="btn btn-primary btn-sm">In Preparation</div>
          </td>
        </tr>
        <tr v-if="order.state == 'in preparation'" style="color: #0062cc">
          <td>{{ order.id }}</td>
          <td>{{ order.state }}</td>
          <td>{{ order.start }}</td>
          <td>
            <div class="btn btn-success btn-sm">Prepared</div>
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
      currentUser: ""
    };
  },
  methods: {
    getOrders() {
      axios.get("api/ordersCook/" + currentUser.id).then(response => {
        this.orders = response.data.data;
      });
    },
    setPrepared() {

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
