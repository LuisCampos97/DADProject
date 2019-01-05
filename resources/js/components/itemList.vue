<template>
  <div>
    <div class="content-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-dark">{{ title }} </h1>
        </div>
      </div>
    </div>

    <div class="album py-5 bg-light">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="data:image/" data-holder-rendered="true">
                <div class="card-body">
                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                      <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                    </div>
                    <small class="text-muted">9 mins</small>
                  </div>
                </div>
              </div>
            </div>
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
        <tr v-for="item in items" :key="item.id">
          <td>
            <img :src="'/storage/items/' + item.photo_url">
          </td>
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
      title: "Menu"
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

