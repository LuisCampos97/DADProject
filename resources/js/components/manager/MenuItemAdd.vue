<template>
  <div class="container" style="padding: 25px;" v-if="addingMenuItem">
    <h3>Add</h3>
    <div class="form-group">
      <label for="inputPhoto">Photo</label>
      <input
        type="file"
        class="form-control-file"
        ref="file"
        name="photo"
        id="inputPhoto"
        placeholder="Photo"
      >
      <p class="help-block" v-for="error in errors.name" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputName">Name</label>
      <input
        type="text"
        class="form-control"
        v-model="item.name"
        name="name"
        id="inputName"
        placeholder="Name"
      >
      <p class="help-block" v-for="error in errors.name" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputType">Type</label>
      <select class="form-control" name="inputType" v-model="item.type">
        <option
          v-for="option in options"
          v-bind:key="option.key"
          :selected="option.key == item.type"
        >{{ option.key }}</option>
      </select>
      <p class="help-block" v-for="error in errors.type" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputDescription">Description</label>
      <input
        type="text"
        class="form-control"
        v-model="item.description"
        name="description"
        id="inputDescription"
        placeholder="Description"
      >
      <p class="help-block" v-for="error in errors.description" v-bind:key="error">{{ error }}</p>
    </div>
    <div class="form-group">
      <label for="inputPrice">Price</label>
      <input
        type="number"
        class="form-control"
        v-model="item.price"
        name="price"
        id="inputPrice"
        placeholder="Price"
      >
      <p class="help-block" v-for="error in errors.price" v-bind:key="error">{{ error }}</p>
    </div>

    <div class="form-group">
      <a class="btn btn-success" v-on:click.prevent="addMenuItem()">Save</a>
      <a class="btn btn-danger" v-on:click.prevent="cancelAdd()">Cancel</a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["addingMenuItem"],
  data() {
    return {
      item: {
        name: "",
        type: "",
        description: "",
        photo_url: "",
        price: ""
      },
      errors: {
        name: "",
        type: "",
        description: "",
        photo_url: "",
        price: ""
      },
      options: [
        { value: "Dish", key: "dish" },
        { value: "Drink", key: "drink" }
      ]
    };
  },
  methods: {
    addMenuItem() {
      axios
        .post("api/items/register", this.item)
        .then(response => {
          this.$emit("add-menuitem");
        })
        .catch(error => {
          let data = error.response.data.errors;

          for (let key in this.errors) {
            this.errors[key] = [];

            let errorMessage = data[key];

            if (errorMessage) {
              this.errors[key] = errorMessage;
            }
          }
        });
    },
    cancelAdd() {
      this.$emit("cancel-add");
    }
  }
};
</script>

<style>
.help-block {
  color: red;
  display: table-row;
  font-weight: bold;
}
</style>