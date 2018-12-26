<template>
  <div>
    <div class="container">
      <h2>Register Worker</h2>
      <div class="form-group">
        <label for="inputEmail">Email</label>
        <input
          type="email"
          class="form-control"
          v-model.trim="user.email"
          name="email"
          id="inputEmail"
          placeholder="Enter email address"
        >
        <p class="help-block" v-for="error in errors.email">{{ error }}</p>
      </div>
      <div class="form-group">
        <label for="inputUsername">Username</label>
        <input
          type="text"
          class="form-control"
          v-model="user.username"
          name="username"
          id="inputUsername"
          placeholder="Enter username"
        >
        <p class="help-block" v-for="error in errors.username">{{ error }}</p>
      </div>
      <div class="form-group">
        <label for="inputName">Name</label>
        <input
          type="text"
          class="form-control"
          v-model="user.name"
          name="name"
          id="inputName"
          placeholder="Enter full name"
        >
        <p class="help-block" v-for="error in errors.name">{{ error }}</p>
      </div>
      <div class="form-group">
        <label for="inputType">Type</label>
        <select class="form-control" name="inputType" v-model="user.type">
          <option disabled value>-- Please select one --</option>
          <option v-for="option in options" v-bind:key="option.key">{{ option.value }}</option>
        </select>
        <p class="help-block" v-for="error in errors.type">{{ error }}</p>
      </div>
      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="register">Register</a>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  data() {
    return {
      user: {
        email: "",
        username: "",
        name: "",
        type: ""
      },
      errors: {
        email: [],
        username: [],
        name: [],
        type: []
      },
      options: [
        { value: "Manager", key: "manager" },
        { value: "Waiter", key: "waiter" },
        { value: "Cook", key: "cook" },
        { value: "Cashier", key: "cashier" }
      ]
    };
  },
  methods: {
    register() {
      axios
        .post("api/register", this.user)
        .then(response => {
          console.log("response", response);
          this.$router.push({ name: "home" });
        })
        .catch(error => {
          console.log(error);
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
.help-block {
  color: red;
  display: table-row;
  font-weight: bold;
}
</style>
