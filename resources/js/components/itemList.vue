<template>
   <table class="table table-striped">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="item in items"  :key="item.id">
            <td><img :src="'/storage/items/' + item.photo_url"></td>
            <td>{{ item.name }}</td>
            <td>{{ item.type }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.price }}</td>
        </tr>
    </tbody>
</table>
</template>

<script>
module.exports = {
  data: function() {
    return {
      items: []
    };
  },
  methods: {
    getItems: function() {
      axios.get("api/items").then(response => {
        this.items = response.data.data;
      });
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

