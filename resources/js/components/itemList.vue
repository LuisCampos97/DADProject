<template>
   <table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Photo</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="item in items"  :key="item.id">
            <td>{{ item.name }}</td>
            <td>{{ item.type }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.photo_url }}</td>
            <td>{{ item.price }}</td>
        </tr>
    </tbody>
</table>
</template>

<script>
module.exports = {
   props: ["items"]
}
</script>
