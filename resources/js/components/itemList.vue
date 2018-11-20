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
</div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      items: [],
      title: "Menu Title"
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

