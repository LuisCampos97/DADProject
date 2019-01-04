<template>
  <div class="jumbotron" v-if="item && editingItem">
    <h2>Edit Item</h2>
    <div class="form-group">
      <label for="inputType">Type</label>
      <select class="form-control" name="inputType" v-model="item.type">
        <option disabled value>-- Please select one --</option>
        <option v-for="option in options" v-bind:key="option.key">{{ option.value }}</option>
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
      <label for="inputPhoto">Photo</label>
      <input
        type="file"
        class="form-control"
        ref="file"
        name="price"
        id="inputPrice"
        placeholder="Price"
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
      <p class="help-block" v-for="error in errors.description" v-bind:key="error">{{ error }}</p>
    </div>

    <div class="form-group">
      <a class="btn btn-success" v-on:click.prevent="savePayInvoice()">Save</a>
      <a class="btn btn-danger" v-on:click.prevent="cancelPay()">Cancel</a>
    </div>
  </div>
</template>

<script>
module.exports = {
  data() {
    return {
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
      file: ""
    };
  },
  methods: {
    savePayInvoice() {

    },
    cancelPay() {

    }
  }
};
</script>