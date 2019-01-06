<template>
  <div class="container" style="padding: 25px;" v-if="item && editingMenuItem">
    <h2>Edit</h2>
    <div class="profile-img">
      <img :src="'/storage/items/' + item.photo_url">
      <div class="file btn btn-lg btn-primary">
        Change Photo
        <input
          type="file"
          id="file"
          ref="file"
          v-on:change.prevent="handleFileUpload()"
        >
      </div>
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
      <a class="btn btn-success" v-on:click.prevent="editItem()">Save</a>
      <a class="btn btn-danger" v-on:click.prevent="cancelEdit()">Cancel</a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["item", "editingMenuItem"],
  data() {
    return {
      options: [
        { value: "Dish", key: "dish" },
        { value: "Drink", key: "drink" }
      ],
      errors: {
        name: [],
        type: [],
        description: [],
        photo: [],
        price: []
      }
    };
  },
  methods: {
    cancelEdit() {
      this.$emit("cancel-edit");
    },
    editItem(item) {
      axios
        .put("api/items/" + item.id, item)
        .then(response => {
          Object.assign(this.item, response.data.data);
          this.$emit("edit-menuitem");
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
    }
  }
};
</script>

<style>
.profile-img {
  text-align: center;
}

.profile-img img {
  width: 30%;
  height: 40%;
}

.profile-img .file {
  position: relative;
  overflow: hidden;
  margin-top: -20%;
  width: 70%;
  border: none;
  border-radius: 0;
  font-size: 12px;
  background: #212529b8;
}

.profile-img .file input {
  position: absolute;
  opacity: 0;
  right: 0;
  top: 0;
}

.help-block {
  color: red;
  display: table-row;
  font-weight: bold;
}
</style>
