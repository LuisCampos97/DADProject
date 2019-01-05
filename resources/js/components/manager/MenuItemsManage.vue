<template>
  <div class="jumbotron" v-if="currentUser.type == 'manager'">
    <div class="alert alert-success" v-if="showMessage">
      <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>
    <h3>Menu Items</h3>
    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>Item ID</th>
          <th>Name</th>
          <th>Type</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-for="item in items" :key="item.id">
        <tr>
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.type }}</td>
          <td>
            <a class="btn btn btn-info" v-on:click.prevent="showUpdateModal(item)">
              <i class="fas fa-edit"></i> Edit
            </a>
            <a class="btn btn btn-danger" v-on:click.prevent="deleteItem(item)">
              <i class="fas fa-trash"></i> Delete
            </a>
          </td>
        </tr>
      </tbody>
    </table>

    <modal name="modal-update" :width="600" :height="500">
      <div class="container" style="padding: 25px;">
        <h2>{{ currentItem.name }}</h2>
        <div class="form-group">
          <label for="inputName">Name</label>
          <input
            type="text"
            class="form-control"
            v-model="currentItem.name"
            name="name"
            id="inputName"
            placeholder="Name"
          >
          <p class="help-block" v-for="error in errors.name" v-bind:key="error">{{ error }}</p>
        </div>
        <div class="form-group">
          <label for="inputType">Type</label>
          <select class="form-control" name="inputType" v-model="currentItem.type">
            <option
              v-for="option in options"
              v-bind:key="option.key"
              :selected="option.key == currentItem.type"
            >{{ option.key }}</option>
          </select>
          <p class="help-block" v-for="error in errors.type" v-bind:key="error">{{ error }}</p>
        </div>
        <div class="form-group">
          <label for="inputDescription">Description</label>
          <input
            type="text"
            class="form-control"
            v-model="currentItem.description"
            name="description"
            id="inputDescription"
            placeholder="Description"
          >
          <p class="help-block" v-for="error in errors.description" v-bind:key="error">{{ error }}</p>
        </div>
        <!-- <div class="form-group">
          <label for="inputPhoto">Photo</label>
          <input
            type="file"
            class="form-control"
            ref="file"
            name="photo"
            id="inputPhoto"
          >
          <p class="help-block" v-for="error in errors.photo" v-bind:key="error">{{ error }}</p>
        </div>-->
        <div class="form-group">
          <label for="inputPrice">Price</label>
          <input
            type="number"
            class="form-control"
            v-model="currentItem.price"
            name="price"
            id="inputPrice"
            placeholder="Price"
          >
          <p class="help-block" v-for="error in errors.price" v-bind:key="error">{{ error }}</p>
        </div>

        <div class="form-group">
          <a class="btn btn-success" v-on:click.prevent="updateItem(currentItem)">Save</a>
          <a class="btn btn-danger" v-on:click.prevent="cancelUpdate()">Cancel</a>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  props: ["currentUser"],
  data() {
    return {
      items: [],
      showMessage: false,
      message: "",
      options: [
        { value: "Dish", key: "dish" },
        { value: "Drink", key: "drink" }
      ],
      errors: {
        type: [],
        description: [],
        photo: [],
        price: []
      },
      currentItem: {}
    };
  },
  methods: {
    getItems() {
      axios.get("/api/items").then(response => {
        this.items = response.data.data;
      });
    },
    showUpdateModal(item) {
      this.currentItem = item;
      this.$modal.show("modal-update");
    },
    deleteItem(item) {
      axios.delete("api/items/" + item.id).then(response => {
        this.showMessage = true;
        this.message = `Item "${item.name}" deleted`;
        this.getItems();
      });
    },
    updateItem(item) {
      axios.put("api/items/" + item.id, item).then(response => {
        this.$modal.hide("modal-update");
        this.showMessage = true;
        this.message = `Item "${item.name}" updated`;
        Vue.set(this.currentItem, response.data.data);
      });
    },
    cancelUpdate() {
      this.getItems();
      this.$modal.hide("modal-update");
    }
  },
  mounted() {
    this.getItems();
  }
};
</script>