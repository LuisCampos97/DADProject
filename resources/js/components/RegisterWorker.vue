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
      </div>
      <div class="form-group">
        <label for="inputType">Type</label>
        <select class="form-control" name="inputType" v-model="user.type">
          <option disabled value>-- Please select one --</option>
          <option v-for="option in options" v-bind:value="option.value">{{ option.text }}</option>
        </select>
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
      options: [
        { text: "Manager", value: "manager" },
        { text: "Waiter", value: "waiter" },
        { text: "Cook", value: "cook" },
        { text: "Cashier", value: "cashier" }
      ]
    };
  },
  methods: {
    register() {
      axios.post("api/register", this.user)
      .then(response => {
         console.log('response', response);
      })
      .catch(response => {
         
      });
    }
  }
};
</script>
