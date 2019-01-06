<template>
  <div>
    <div class="content-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-dark">{{ title }}</h1>
        </div>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Photo</th>
          <th>Name</th>
          <th>Type</th>
          <th>Description</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items.data" :key="item.id">
          <td>
            <img :src="'/storage/items/' + item.photo_url">
          </td>
          <td>{{ item.name }}</td>
          <td>{{ item.type }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.price }}</td>
          <td>
            <button @click.prevent="registerOrder(item.id)">Add</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <pagination :data="items" @pagination-change-page="getItems"></pagination>
    </div>
  </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      items: {},
      title: "Menu"
    };
  },
  methods: {
    getItems: function(page = 1) {
      axios.get("api/itemsPaginate?page=" + page).then(response => {
        this.items = response.data;
      });
    },
    registerOrder: function(id) {
      console.dir(id);
      this.$emit("register-order", id);
    }
  },
  mounted() {
    this.getItems();
  }
};
</script>

<style scoped>
img {
  border-radius: 3px;
  width: 125px;
}
</style>

<style scoped>
.pagination {
  justify-content: center !important;
}
</style>