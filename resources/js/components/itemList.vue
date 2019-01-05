<template>
  <div>
    <div class="content-header">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-dark">{{ title }}</h1>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="card-deck">
          <div v-for="item in items" :key="item.id" class="col-lg-4 d-flex align-items-stretch">
            <div class="card bg-light mt-4">
              <img class="card-img-top img-fluid" :src="'/storage/items/' + item.photo_url" alt="Thumbnail [100px180]" data-holder-rendered="true">
              <div class="card-body">
                <h4 class="card-title">{{ item.name }}</h4>
                <p class="card-text">{{ item.description }}</p>
                <p class="card-text">{{ item.type }}</p>
                <small class="text-muted">{{ item.price }}€</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
.card-img-top {
  width: 100%;
  height: 15vw;
  object-fit: cover;
}
</style>

