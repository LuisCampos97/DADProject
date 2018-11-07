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
  props: ["items"],
  methods: {
  }
};
</script>

<style scoped>
img {
    border-radius: 3px;
    width: 125px;
}
</style>

